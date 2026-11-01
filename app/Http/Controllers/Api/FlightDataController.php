<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aircraft;
use App\Models\Aircraft_instance;
use App\Models\Aircraft_seat;
use App\Models\Airport;
use App\Models\Booking;
use App\Models\Flight;
use App\Models\Flight_aircraft_instance;
use App\Models\Flight_seat_price;
use App\Models\Schedule;
use App\Models\Travel_class;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FlightDataController extends Controller
{
    private const CLASS_MAP = [
        'economy' => 'regular',
        'business' => 'business',
        'first' => 'vip',
    ];

    public function airports(Request $request): JsonResponse
    {
        $query = trim((string) $request->query('q', ''));

        $airports = Airport::query()
            ->when($query !== '', function ($q) use ($query) {
                $q->where('city', 'like', "%{$query}%")
                    ->orWhere('name', 'like', "%{$query}%")
                    ->orWhere('data_airport_code', 'like', "%{$query}%");
            })
            ->limit(50)
            ->get();

        return response()->json(['success' => true, 'data' => $airports->map(
            fn (Airport $airport) => [
                'code' => $airport->data_airport_code,
                'city' => $airport->city,
                'name' => $airport->name,
            ]
        )->values()]);
    }

    public function flights(Request $request): JsonResponse
    {
        $origin = $request->query('origin');
        $destination = $request->query('destination');
        $date = $request->query('date');

        $schedules = Schedule::query()
            ->when($origin, fn ($q) => $q->where('origin_data_airport_code', $origin))
            ->when($destination, fn ($q) => $q->where('destination_data_airport_code', $destination))
            ->with(['origin_airport', 'destination_airport', 'flights.flight_status'])
            ->orderBy('departure_time')
            ->get()
            ->when($date !== null, function ($collection) use ($date) {
                return $collection->filter(
                    fn (Schedule $schedule) => $schedule->departure_time?->format('Y-m-d') === $date
                )->values();
            });

        $items = $schedules->map(fn (Schedule $schedule) => $this->schedulePayload($schedule))->filter()->values();

        return response()->json(['success' => true, 'data' => $items]);
    }

    public function seats(Request $request, int $scheduleId): JsonResponse
    {
        $schedule = Schedule::with('flights')->findOrFail($scheduleId);
        $flight = $schedule->flights->first();

        if (!$flight) {
            return response()->json(['success' => false, 'message' => 'Penerbangan tidak ditemukan.'], 404);
        }

        $aircraftId = $this->aircraftIdForFlight($flight) ?? 0;
        $aircraft = Aircraft::find($aircraftId);
        $capacity = $aircraft ? $this->seatMap()->count() : 0;
        $bookedSeatIds = Booking::where('flight_call', $flight->flight_call)->pluck('seat_id')->toArray();

        $classRows = [];
        foreach (Travel_class::all() as $class) {
            $seatIds = $this->seatMap()->keys()->toArray();
            $available = array_values(array_diff($seatIds, $bookedSeatIds));
            $classRows[] = [
                'class' => strtolower($class->name),
                'class_label' => $class->name,
                'seats' => array_values($this->seatMap()->keys()->toArray()),
                'available_count' => count($available),
                'capacity' => $capacity,
                'booked_count' => count($bookedSeatIds),
            ];
        }

        return response()->json(['success' => true, 'data' => [
            'schedule_id' => $schedule->schedule_id,
            'flight_call' => $flight->flight_call,
            'capacity' => $capacity,
            'booked_count' => count($bookedSeatIds),
            'classes' => $classRows,
        ]]);
    }

    private function seatMap()
    {
        static $seats;
        if ($seats === null) {
            $seats = Aircraft_seat::select('aircraft_seat_id', 'travel_class_id')
                ->orderBy('aircraft_seat_id')
                ->get()
                ->mapWithKeys(fn (Aircraft_seat $s) => [
                    $s->aircraft_seat_id => $s->travel_class_id,
                ]);
        }

        return $seats;
    }

    private function schedulePayload(Schedule $schedule): ?array
    {
        $flight = $schedule->flights->first();
        if (!$flight) {
            return null;
        }

        $aircraftId = $this->aircraftIdForFlight($flight);
        $aircraft = $aircraftId ? Aircraft::with('manufacturer')->find($aircraftId) : null;
        $airline = $aircraft?->manufacturer?->name ?? 'Airtix';
        $capacity = $this->seatMap()->count();
        $seatsBooked = Booking::where('flight_call', $flight->flight_call)->count();

        $priceByClass = $this->classPrices($flight->flight_call, $aircraftId);
        $primary = $priceByClass->sortBy('price')->first();
        $cabinClass = 'regular';
        if ($primary && isset(self::CLASS_MAP[$primary['class']])) {
            $cabinClass = self::CLASS_MAP[$primary['class']];
        }

        $origin = $schedule->origin_airport;
        $destination = $schedule->destination_airport;

        return [
            'id' => (string) $schedule->schedule_id,
            'schedule_id' => $schedule->schedule_id,
            'airline' => $airline,
            'flight_number' => (string) $flight->flight_call,
            'flight_call' => $flight->flight_call,
            'origin' => $origin ? ['code' => $origin->data_airport_code, 'city' => $origin->city, 'name' => $origin->name] : null,
            'destination' => $destination ? ['code' => $destination->data_airport_code, 'city' => $destination->city, 'name' => $destination->name] : null,
            'departure' => $schedule->departure_time?->toIso8601String(),
            'arrival' => $schedule->arrival_time?->toIso8601String(),
            'price' => $primary ? $primary['price'] : 0,
            'capacity' => $capacity,
            'seats_booked' => $seatsBooked,
            'available' => max(0, $capacity - $seatsBooked),
            'cabin_class' => $cabinClass,
            'classes' => $priceByClass->values(),
        ];
    }

    private function aircraftIdForFlight(Flight $flight): ?int
    {
        $link = Flight_aircraft_instance::where('flight_call', $flight->flight_call)->first();
        if ($link) {
            return Aircraft_instance::find($link->aircraft_instance_id)?->aircraft_id;
        }

        return $flight->aircraft_instance?->aircraft_id;
    }

    private function classPrices(int $flightCall, ?int $aircraftId)
    {
        $rows = Flight_seat_price::where('flight_call', $flightCall)
            ->when($aircraftId !== null, fn ($q) => $q->where('aircraft_id', $aircraftId))
            ->get();

        $seatClass = $this->seatMap();
        $classNames = Travel_class::all()->mapWithKeys(
            fn (Travel_class $c) => [$c->travel_class_id => $c->name]
        );

        $prices = [];
        foreach ($rows as $row) {
            $classId = $seatClass[$row->seat_id] ?? null;
            if ($classId === null) {
                continue;
            }
            $name = $classNames[$classId] ?? 'Economy';
            $key = strtolower($name);
            if (!isset($prices[$key]) || (float) $row->price < $prices[$key]['price']) {
                $prices[$key] = [
                    'class' => $key,
                    'class_label' => $name,
                    'price' => (int) round((float) $row->price),
                ];
            }
        }

        return collect($prices);
    }
}