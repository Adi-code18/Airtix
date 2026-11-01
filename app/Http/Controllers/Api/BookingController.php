<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aircraft_seat;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Flight;
use App\Models\Flight_seat_price;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $client = $this->client($request);
        if (!$client) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $rows = Booking::where('client_id', $client->client_id)
            ->orderBy('created_at')
            ->get();

        $bookings = $rows->groupBy('flight_call')->map(
            fn ($group) => $this->payload($group)
        );

        return response()->json(['success' => true, 'data' => $bookings->values()]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'schedule_id' => 'required',
            'seats' => ['required', 'array'],
            'seats.*' => 'required',
            'passenger_names' => ['array'],
            'passenger_names.*' => 'string',
        ]);

        $client = $this->client($request);
        if (!$client) {
            return response()->json(['success' => false, 'message' => 'Data klien tidak ditemukan.'], 422);
        }

        $schedule = Schedule::with('flights')->find($data['schedule_id'] ?? '');
        $flight = $schedule?->flights->first();
        if (!$flight) {
            return response()->json(['success' => false, 'message' => 'Penerbangan tidak ditemukan.'], 404);
        }

        $aircraftId = $this->aircraftIdForFlight($flight);
        $existing = Booking::where('client_id', $client->client_id)
            ->where('flight_call', $flight->flight_call)
            ->pluck('seat_id')
            ->toArray();

        foreach ($data['seats'] as $label) {
            $seatId = $this->seatIdFromLabel((string) $label);
            if ($seatId === null || in_array($seatId, $existing, true)) {
                continue;
            }
            Booking::create([
                'client_id' => $client->client_id,
                'flight_call' => $flight->flight_call,
                'seat_id' => $seatId,
                'aircraft_id' => $aircraftId,
            ]);
            $existing[] = $seatId;
        }

        $rows = Booking::where('client_id', $client->client_id)
            ->where('flight_call', $flight->flight_call)
            ->orderBy('created_at')
            ->get();

        return response()->json(['success' => true, 'data' => $this->payload($rows)]);
    }

    public function refund(Request $request, string $bookingId): JsonResponse
    {
        $client = $this->client($request);
        if (!$client) {
            return response()->json(['success' => false, 'message' => 'Data klien tidak ditemukan.'], 422);
        }

        $parts = explode('-', $bookingId);
        $flightCall = (int) end($parts);

        $deleted = Booking::where('client_id', $client->client_id)
            ->where('flight_call', $flightCall)
            ->delete();

        if ($deleted === 0) {
            return response()->json(['success' => false, 'message' => 'Tiket tidak ditemukan.'], 404);
        }

        return response()->json(['success' => true]);
    }

    private function payload($rows): array
    {
        $first = $rows->first();
        if ($first === null) {
            return [];
        }

        $flight = Flight::where('flight_call', $first->flight_call)->first();
        $schedule = $flight ? Schedule::with(['origin_airport', 'destination_airport'])->find($flight->schedule_id) : null;
        $client = Client::find($first->client_id);

        $seatLabels = $rows->map(fn (Booking $row) => $this->labelFromSeatId($row->seat_id))->sort()->values();
        $totalPrice = 0;
        $bookedAt = $first->created_at;

        foreach ($rows as $row) {
            $price = Flight_seat_price::where('flight_call', $row->flight_call)
                ->where('seat_id', $row->seat_id)
                ->value('price');
            $totalPrice += (float) ($price ?? 0);
        }

        $name = trim(($client->first_name ?? '') . ' ' . (($client->middle_name ?? '') !== '' ? $client->middle_name . ' ' : '') . ($client->last_name ?? ''));

        return [
            'id' => 'BK-' . $first->client_id . '-' . $first->flight_call,
            'booking_code' => 'BK-' . str_pad((string) $first->client_id, 3, '0', STR_PAD_LEFT) . '-' . $first->flight_call,
            'schedule_id' => $schedule?->schedule_id,
            'airline' => 'Airtix',
            'flight_number' => (string) $first->flight_call,
            'origin_city' => $schedule?->origin_airport?->city ?? '',
            'origin_code' => $schedule?->origin_airport?->data_airport_code ?? '',
            'destination_city' => $schedule?->destination_airport?->city ?? '',
            'destination_code' => $schedule?->destination_airport?->data_airport_code ?? '',
            'departure' => $schedule?->departure_time?->toIso8601String(),
            'arrival' => $schedule?->arrival_time?->toIso8601String(),
            'cabin_class' => 'Reguler',
            'passenger_count' => $rows->count(),
            'passenger_names' => $name !== '' ? [$name] : [],
            'seats' => $seatLabels->toArray(),
            'total_price' => (int) round($totalPrice),
            'booked_at' => $bookedAt?->toIso8601String(),
            'status' => 'confirmed',
            'paid' => true,
        ];
    }

    private function client(Request $request): ?Client
    {
        if (!empty($request->user()->email)) {
            return Client::where('email', $request->user()->email)->first();
        }

        return null;
    }

    private function aircraftIdForFlight(Flight $flight): ?int
    {
        $link = \App\Models\Flight_aircraft_instance::where('flight_call', $flight->flight_call)->first();
        if ($link) {
            return \App\Models\Aircraft_instance::find($link->aircraft_instance_id)?->aircraft_id;
        }

        return $flight->aircraft_instance?->aircraft_id;
    }

    private function seatIdFromLabel(string $label): ?int
    {
        if (ctype_digit($label)) {
            return (int) $label;
        }

        $row = (int) substr($label, 0, -1);
        $col = strtoupper(substr($label, -1));
        $colIndex = ord($col) - ord('A');
        return ($row - 1) * 6 + $colIndex + 1;
    }

    private function labelFromSeatId(int $seatId): string
    {
        $letters = ['A', 'B', 'C', 'D', 'E', 'F'];
        $row = intdiv($seatId - 1, 6) + 1;
        $col = $letters[($seatId - 1) % 6];

        return (string) $row . $col;
    }
}