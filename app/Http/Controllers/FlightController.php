<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Schedule;
use App\Models\Airport;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function search(Request $request)
    {
        $origin = $request->query('origin');
        $destination = $request->query('destination');
        $departure_date = $request->query('departure_date');
        $return_date = $request->query('return_date');
        $passengers = $request->query('passengers', 1);

        // Query schedules berdasarkan bandara keberangkatan dan tujuan
        $schedules = Schedule::query()
            ->where('origin_data_airport_code', 'LIKE', '%' . $origin . '%')
            ->where('destination_data_airport_code', 'LIKE', '%' . $destination . '%')
            ->with(['origin_airport', 'destination_airport', 'flights.flight_status', 'flights.aircraft_instance'])
            ->orderBy('departure_time', 'asc')
            ->get();

        // Filter berdasarkan tanggal jika ada
        if ($departure_date) {
            $schedules = $schedules->filter(function ($schedule) use ($departure_date) {
                return \Carbon\Carbon::parse($schedule->departure_time)->format('Y-m-d') === $departure_date;
            });
        }

        // Jika request adalah AJAX, return JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'schedules' => $schedules->values(),
                'count' => $schedules->count()
            ]);
        }

        // Jika bukan AJAX, return view
        return view('flight.results', [
            'schedules' => $schedules,
            'origin' => $origin,
            'destination' => $destination,
            'departure_date' => $departure_date,
            'return_date' => $return_date,
            'passengers' => $passengers
        ]);
    }

    public function index()
    {
        $flights = Flight::with(['schedule', 'flight_status'])->get();
        return view('flight.index', ['flights' => $flights]);
    }

    public function show($id)
    {
        $flight = Flight::with(['schedule', 'flight_status', 'aircraft_instance'])->findOrFail($id);
        return view('flight.show', ['flight' => $flight]);
    }

    public function getAirports(Request $request)
    {
        $search = $request->query('q', '');
        
        $airports = Airport::where('city', 'LIKE', '%' . $search . '%')
            ->orWhere('name', 'LIKE', '%' . $search . '%')
            ->orWhere('data_airport_code', 'LIKE', '%' . $search . '%')
            ->limit(10)
            ->get()
            ->map(function ($airport) {
                return [
                    'code' => $airport->data_airport_code,
                    'name' => $airport->name,
                    'city' => $airport->city,
                    'label' => $airport->city . ' (' . $airport->data_airport_code . ')',
                    'value' => $airport->data_airport_code
                ];
            });

        return response()->json($airports);
    }
}
