<?php

namespace Database\Seeders;

use App\Models\Aircraft;
use App\Models\Aircraft_instance;
use App\Models\Aircraft_manufactures;
use App\Models\Aircraft_seat;
use App\Models\Airport;
use App\Models\Country;
use App\Models\Flight;
use App\Models\Flight_aircraft_instance;
use App\Models\Flight_seat_price;
use App\Models\Flight_status;
use App\Models\Schedule;
use App\Models\Travel_class;
use Illuminate\Database\Seeder;

class AirtixSeeder extends Seeder
{
    public function run(): void
    {
        Country::firstOrCreate(['data_country_code' => 'ID'], ['name' => 'Indonesia']);

        $this->seedAirports();

        $classes = [
            'first' => Travel_class::firstOrCreate(['name' => 'First'], ['description' => 'Kelas Pertama (VIP)']),
            'business' => Travel_class::firstOrCreate(['name' => 'Business'], ['description' => 'Kelas Bisnis']),
            'economy' => Travel_class::firstOrCreate(['name' => 'Economy'], ['description' => 'Kelas Ekonomi (Reguler)']),
        ];

        $onTime = Flight_status::firstOrCreate(['name' => 'Tepat Waktu']);

        $aircraftByManufacturer = $this->seedAircraft();
        $instances = Aircraft_instance::all();

        $seatClassById = $this->seedSeats($classes);

        if (Flight::exists()) {
            return;
        }

        $routes = [
            ['CGK', 'DPS', 135], ['CGK', 'SUB', 95], ['CGK', 'KNO', 150],
            ['CGK', 'UPG', 185], ['CGK', 'BPN', 155], ['DPS', 'CGK', 135],
            ['SUB', 'CGK', 95], ['KNO', 'CGK', 150], ['CGK', 'YIA', 55],
            ['CGK', 'SOC', 60], ['BPN', 'CGK', 155], ['UPG', 'CGK', 185],
            ['YIA', 'DPS', 60], ['SOC', 'DPS', 65],
        ];

        $flightCall = 1000;
        foreach (range(0, 6) as $dayOffset) {
            foreach ($routes as $route) {
                [$origin, $destination, $duration] = $route;
                $hour = 6 + $flightCall % 14;
                $minute = ($flightCall * 7) % 50;
                $departure = now()->addDays($dayOffset)->startOfDay()
                    ->addHours($hour)->addMinutes($minute);
                $arrival = $departure->copy()->addMinutes($duration + (int) ($flightCall % 30));

                $schedule = Schedule::create([
                    'origin_data_airport_code' => $origin,
                    'destination_data_airport_code' => $destination,
                    'departure_time' => $departure,
                    'arrival_time' => $arrival,
                ]);

                $instance = $instances->get($flightCall % count($instances));
                $aircraft = Aircraft::find($instance->aircraft_id);
                $manufacturerName = $aircraft->manufacturer->name;

                Flight::create([
                    'flight_call' => $flightCall,
                    'schedule_id' => $schedule->schedule_id,
                    'flight_status_id' => $onTime->flight_status_id,
                ]);

                Flight_aircraft_instance::create([
                    'flight_call' => $flightCall,
                    'aircraft_instance_id' => $instance->aircraft_instance_id,
                ]);

                $baseByClass = [
                    'first' => 2100000,
                    'business' => 1400000,
                    'economy' => 700000,
                ];

                foreach ($seatClassById as $seatId => $className) {
                    $base = $baseByClass[$className];
                    $price = $base + ($seatId % 5) * 25000 + ($seatId % 13) * 7000;
                    Flight_seat_price::create([
                        'flight_call' => $flightCall,
                        'aircraft_id' => $aircraft->aircraft_id,
                        'seat_id' => $seatId,
                        'price' => $price,
                    ]);
                }

                $flightCall++;
            }
        }
    }

    private function seedAirports(): void
    {
        $airports = [
            ['CGK', 'Soekarno–Hatta International', 'Jakarta'],
            ['DPS', 'Ngurah Rai International', 'Denpasar'],
            ['SUB', 'Juanda International', 'Surabaya'],
            ['KNO', 'Kualanamu International', 'Medan'],
            ['UPG', 'Sultan Hasanuddin International', 'Makassar'],
            ['BPN', 'Sepinggan International', 'Balikpapan'],
            ['YIA', 'Yogyakarta International', 'Yogyakarta'],
            ['SOC', 'Adisumarmo International', 'Surakarta'],
        ];

        foreach ($airports as [$code, $name, $city]) {
            Airport::firstOrCreate(
                ['data_airport_code' => $code],
                ['name' => $name, 'city' => $city, 'data_country_code' => 'ID']
            );
        }
    }

    private function seedAircraft(): array
    {
        $aircraft = [];

        $manufacturers = [
            'Garuda Indonesia' => ['Airbus A330-300', 'Boeing 737-800'],
            'Lion Air' => ['Boeing 737 MAX 9', 'Airbus A320'],
            'Batik Air' => ['Airbus A320neo'],
            'Citilink' => ['Airbus A320'],
            'Super Air Jet' => ['Airbus A320'],
        ];

        foreach ($manufacturers as $name => $models) {
            $manufacturer = Aircraft_manufactures::firstOrCreate(['name' => $name]);
            foreach ($models as $model) {
                $plain = Aircraft::where('model', $model)->first();
                if ($plain === null) {
                    $plain = Aircraft::create([
                        'aircraft_manufacture_id' => $manufacturer->aircraft_manufacture_id,
                        'model' => $model,
                    ]);
                }
                Aircraft_instance::firstOrCreate(
                    ['aircraft_id' => $plain->aircraft_id],
                    ['aircraft_id' => $plain->aircraft_id]
                );
                $aircraft[$name] = $plain;
            }
        }

        return $aircraft;
    }

    private function seedSeats(array $classes): array
    {
        if (Aircraft_seat::count() > 0) {
            $classById = collect($classes)->mapWithKeys(
                fn (Travel_class $class, string $key) => [$class->travel_class_id => $key]
            );

            return Aircraft_seat::select('aircraft_seat_id', 'travel_class_id')
                ->get()
                ->mapWithKeys(fn (Aircraft_seat $seat) => [
                    $seat->aircraft_seat_id => $classById[$seat->travel_class_id] ?? 'economy',
                ])
                ->toArray();
        }

        $plan = [
            'first' => 8,
            'business' => 16,
            'economy' => 128,
        ];

        $map = [];
        $seatId = 1;
        foreach ($plan as $className => $count) {
            $classId = $classes[$className]->travel_class_id;
            for ($i = 0; $i < $count; $i++) {
                Aircraft_seat::create([
                    'aircraft_seat_id' => $seatId,
                    'travel_class_id' => $classId,
                ]);
                $map[$seatId] = $className;
                $seatId++;
            }
        }

        return $map;
    }
}