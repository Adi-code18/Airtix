<!DOCTYPE html>
<html class="light" lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <title>
            List Maskapai dan Jadwal - FlightBooker
        </title>
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries">
        </script>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
        <script id="tailwind-config">
            tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#137fec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
        </script>
        <style>
            body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        </style>
    </head>
    <body class="bg-background-light dark:bg-background-dark text-[#111418] dark:text-gray-100">
        <div class="relative flex min-h-screen flex-col">
            <!-- Navigation Header -->
            <header class="sticky top-0 z-50 bg-white dark:bg-gray-900 border-b border-solid border-[#f0f2f4] dark:border-gray-800 px-6 lg:px-20 py-3">
                <div class="flex items-center justify-between gap-8 max-w-[1440px] mx-auto">
                    <div class="flex items-center gap-8">
                        <div class="flex items-center gap-3 text-primary">
                            <span class="material-symbols-outlined text-3xl">
                                flight_takeoff
                            </span>
                            <h2 class="text-[#111418] dark:text-white text-xl font-bold leading-tight tracking-[-0.015em]">
                                FlightBooker
                            </h2>
                        </div>
                        <div class="hidden md:flex items-center gap-6 ml-8">
                            <a class="text-[#111418] dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors" href="#">
                                Hotels
                            </a>
                            <a class="text-primary text-sm font-bold border-b-2 border-primary pb-1" href="#">
                                Flights
                            </a>
                            <a class="text-[#111418] dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors" href="#">
                                Trains
                            </a>
                            <a class="text-[#111418] dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors" href="#">
                                Car Rental
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            <div class="flex items-center gap-3">
                                <div class="text-right hidden sm:block">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Masuk sebagai</p>
                                    <p class="text-sm font-bold text-[#111418] dark:text-white">
                                        {{ Auth::user()->name }}
                                        @if(Auth::user()->role === 'admin')
                                            <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded ml-1">Admin</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border border-gray-200 dark:border-gray-700" style='background-image: url("{{ Auth::user()->avatar ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->email))) . '?d=mp' }}");'>
                                </div>
                                <form action="{{ route('logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="flex cursor-pointer items-center justify-center rounded-lg h-10 px-4 bg-red-500 hover:bg-red-600 text-white text-sm font-bold leading-normal transition-colors">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="flex min-w-[84px] cursor-pointer items-center justify-center rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold tracking-[0.015em] hover:bg-primary/90 transition-all">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="flex min-w-[84px] cursor-pointer items-center justify-center rounded-lg h-10 px-4 bg-[#f0f2f4] dark:bg-gray-800 text-[#111418] dark:text-white text-sm font-bold hover:bg-gray-200 dark:hover:bg-gray-700 transition-all">
                                Sign Up
                            </a>
                        @endauth
                    </div>
                </div>
            </header>
            <!-- Search Summary Banner -->
            <div class="bg-white dark:bg-gray-900 border-b border-[#f0f2f4] dark:border-gray-800 px-6 lg:px-20 py-6">
                <div class="max-w-[1440px] mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2 text-[#617589] dark:text-gray-400 text-sm font-medium mb-1">
                            <a class="hover:text-primary" href="#">
                                Home
                            </a>
                            <span class="material-symbols-outlined text-sm">
                                chevron_right
                            </span>
                            <a class="hover:text-primary" href="#">
                                Search Results
                            </a>
                            <span class="material-symbols-outlined text-sm">
                                chevron_right
                            </span>
                            <span class="text-[#111418] dark:text-white">
                                Jakarta to Bali
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <h1 class="text-2xl lg:text-3xl font-bold text-[#111418] dark:text-white">
                                Jakarta (JKT) → Bali (DPS)
                            </h1>
                            <span class="px-2 py-1 bg-primary/10 text-primary text-xs font-bold rounded">
                                One Way
                            </span>
                        </div>
                        <p class="text-[#617589] dark:text-gray-400 text-sm">
                            Tue, 24 Oct 2023 | 1 Passenger | Economy Class
                        </p>
                    </div>
                    <button class="flex self-start md:self-center min-w-[140px] items-center justify-center gap-2 rounded-lg h-10 px-4 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111418] dark:text-white text-sm font-bold shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                        <span class="material-symbols-outlined text-lg">
                            edit
                        </span>
                        Change Search
                    </button>
                </div>
            </div>
            <!-- Main Content Area -->
            <main class="flex-1 max-w-[1440px] mx-auto w-full px-6 lg:px-20 py-8">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <!-- Sidebar Filters -->
                    <aside class="lg:col-span-1 flex flex-col gap-6">
                        <div class="bg-white dark:bg-gray-900 rounded-xl p-6 border border-[#f0f2f4] dark:border-gray-800 shadow-sm">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-lg font-bold">
                                    Filters
                                </h2>
                                <button class="text-primary text-sm font-semibold hover:underline">
                                    Reset All
                                </button>
                            </div>
                            <!-- Price Range Filter -->
                            <div class="mb-8">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="material-symbols-outlined text-primary">
                                        payments
                                    </span>
                                    <h3 class="text-sm font-bold">
                                        Price Range
                                    </h3>
                                </div>
                                <div class="px-2">
                                    <div class="relative h-1.5 w-full bg-gray-200 dark:bg-gray-700 rounded-full mb-6">
                                        <div class="absolute left-[10%] right-[30%] h-full bg-primary rounded-full">
                                        </div>
                                        <div class="absolute left-[10%] -top-1.5 size-4 bg-white border-2 border-primary rounded-full cursor-pointer shadow-md">
                                        </div>
                                        <div class="absolute right-[30%] -top-1.5 size-4 bg-white border-2 border-primary rounded-full cursor-pointer shadow-md">
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center text-xs font-semibold text-gray-500">
                                        <span>
                                            Rp 850k
                                        </span>
                                        <span>
                                            Rp 4.500k
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Transit Filter -->
                            <div class="mb-8">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="material-symbols-outlined text-primary">
                                        alt_route
                                    </span>
                                    <h3 class="text-sm font-bold">
                                        Transit
                                    </h3>
                                </div>
                                <div class="space-y-3">
                                    <label class="flex items-center justify-between cursor-pointer group">
                                        <div class="flex items-center gap-3">
                                            <input checked="" class="w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary" type="checkbox"/>
                                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                                Direct
                                            </span>
                                        </div>
                                        <span class="text-xs text-gray-400 font-medium">
                                            From Rp 950k
                                        </span>
                                    </label>
                                    <label class="flex items-center justify-between cursor-pointer group">
                                        <div class="flex items-center gap-3">
                                            <input class="w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary" type="checkbox"/>
                                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                                1 Transit
                                            </span>
                                        </div>
                                        <span class="text-xs text-gray-400 font-medium">
                                            From Rp 1.2M
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <!-- Airlines Filter -->
                            <div class="mb-8">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="material-symbols-outlined text-primary">
                                        flight
                                    </span>
                                    <h3 class="text-sm font-bold">
                                        Airlines
                                    </h3>
                                </div>
                                <div class="space-y-3">
                                    <label class="flex items-center justify-between cursor-pointer">
                                        <div class="flex items-center gap-3">
                                            <input checked="" class="w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary" type="checkbox"/>
                                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                                Garuda Indonesia
                                            </span>
                                        </div>
                                    </label>
                                    <label class="flex items-center justify-between cursor-pointer">
                                        <div class="flex items-center gap-3">
                                            <input checked="" class="w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary" type="checkbox"/>
                                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                                Batik Air
                                            </span>
                                        </div>
                                    </label>
                                    <label class="flex items-center justify-between cursor-pointer">
                                        <div class="flex items-center gap-3">
                                            <input checked="" class="w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary" type="checkbox"/>
                                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                                Lion Air
                                            </span>
                                        </div>
                                    </label>
                                    <label class="flex items-center justify-between cursor-pointer">
                                        <div class="flex items-center gap-3">
                                            <input checked="" class="w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary" type="checkbox"/>
                                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                                Citilink
                                            </span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <!-- Departure Time Filter -->
                            <div>
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="material-symbols-outlined text-primary">
                                        schedule
                                    </span>
                                    <h3 class="text-sm font-bold">
                                        Departure Time
                                    </h3>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <button class="flex flex-col items-center justify-center p-2 rounded-lg border border-primary bg-primary/10 text-primary">
                                        <span class="material-symbols-outlined text-xl">
                                            wb_sunny
                                        </span>
                                        <span class="text-[10px] font-bold uppercase mt-1">
                                            Morning
                                        </span>
                                        <span class="text-[10px]">
                                            04:00 - 11:00
                                        </span>
                                    </button>
                                    <button class="flex flex-col items-center justify-center p-2 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:border-primary transition-all">
                                        <span class="material-symbols-outlined text-xl">
                                            light_mode
                                        </span>
                                        <span class="text-[10px] font-bold uppercase mt-1">
                                            Afternoon
                                        </span>
                                        <span class="text-[10px]">
                                            11:00 - 18:00
                                        </span>
                                    </button>
                                    <button class="flex flex-col items-center justify-center p-2 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:border-primary transition-all">
                                        <span class="material-symbols-outlined text-xl">
                                            bedtime
                                        </span>
                                        <span class="text-[10px] font-bold uppercase mt-1">
                                            Evening
                                        </span>
                                        <span class="text-[10px]">
                                            18:00 - 04:00
                                        </span>
                                    </button>
                                    <button class="flex flex-col items-center justify-center p-2 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:border-primary transition-all">
                                        <span class="material-symbols-outlined text-xl">
                                            all_inclusive
                                        </span>
                                        <span class="text-[10px] font-bold uppercase mt-1">
                                            Anytime
                                        </span>
                                        <span class="text-[10px]">
                                            All Hours
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!-- Flight List Area -->
                    <div class="lg:col-span-3 space-y-4">
                        <!-- Results Controls -->
                        <div class="flex items-center justify-between mb-4 px-2">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Showing
                                <span class="font-bold text-[#111418] dark:text-white">
                                    48 flights
                                </span>
                                for your trip
                            </p>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-500 font-medium">
                                    Sort by:
                                </span>
                                <select class="text-sm border-none bg-transparent focus:ring-0 font-bold text-primary cursor-pointer">
                                    <option>
                                        Cheapest Price
                                    </option>
                                    <option>
                                        Shortest Duration
                                    </option>
                                    <option>
                                        Earliest Flight
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!-- Flight Card 1 -->
                        <div class="bg-white dark:bg-gray-900 rounded-xl border border-[#f0f2f4] dark:border-gray-800 shadow-sm overflow-hidden hover:shadow-md transition-all group">
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-6">
                                    <!-- Airline Info -->
                                    <div class="flex flex-col gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="size-12 rounded-lg bg-gray-50 dark:bg-gray-800 flex items-center justify-center border border-gray-100 dark:border-gray-700">
                                                <span class="material-symbols-outlined text-primary text-3xl">
                                                    airlines
                                                </span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-[#111418] dark:text-white">
                                                    Garuda Indonesia
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    GA-402 • Airbus A330
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <span class="px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-[10px] font-bold rounded">
                                                Eco-Friendly
                                            </span>
                                            <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-[10px] font-bold rounded">
                                                Full Service
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Schedule -->
                                    <div class="md:col-span-2 flex items-center justify-between px-4">
                                        <div class="text-center">
                                            <p class="text-xl font-bold text-[#111418] dark:text-white">
                                                08:30
                                            </p>
                                            <p class="text-xs text-gray-500 font-medium">
                                                CGK
                                            </p>
                                        </div>
                                        <div class="flex-1 px-8 flex flex-col items-center">
                                            <p class="text-[10px] text-gray-400 font-bold mb-1">
                                                1h 50m
                                            </p>
                                            <div class="relative w-full h-[1px] bg-gray-300 dark:bg-gray-700">
                                                <div class="absolute -top-1 left-0 size-2 rounded-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
                                                </div>
                                                <div class="absolute -top-1 right-0 size-2 rounded-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
                                                </div>
                                                <span class="material-symbols-outlined absolute left-1/2 -translate-x-1/2 -top-3 text-primary bg-white dark:bg-gray-900 px-1">
                                                    flight
                                                </span>
                                            </div>
                                            <p class="text-[10px] text-green-600 dark:text-green-400 font-bold mt-1">
                                                Direct
                                            </p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xl font-bold text-[#111418] dark:text-white">
                                                11:20
                                            </p>
                                            <p class="text-xs text-gray-500 font-medium">
                                                DPS
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Price and Action -->
                                    <div class="flex flex-col items-end gap-1">
                                        <p class="text-2xl font-black text-primary">
                                            Rp 1.450.000
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            /passenger
                                        </p>
                                        <button class="mt-2 w-full md:w-auto min-w-[120px] bg-primary text-white font-bold py-2.5 px-6 rounded-lg hover:bg-primary/90 transition-all shadow-sm">
                                            Select
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-2 flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 dark:border-gray-800">
                                <div class="flex gap-4">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">
                                            luggage
                                        </span>
                                        20kg
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">
                                            restaurant
                                        </span>
                                        Meal included
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">
                                            power
                                        </span>
                                        Power/USB
                                    </span>
                                </div>
                                <button class="font-bold text-primary hover:underline">
                                    Flight Details
                                </button>
                            </div>
                        </div>
                        <!-- Flight Card 2 -->
                        <div class="bg-white dark:bg-gray-900 rounded-xl border border-[#f0f2f4] dark:border-gray-800 shadow-sm overflow-hidden hover:shadow-md transition-all group">
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-6">
                                    <div class="flex flex-col gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="size-12 rounded-lg bg-gray-50 dark:bg-gray-800 flex items-center justify-center border border-gray-100 dark:border-gray-700">
                                                <span class="material-symbols-outlined text-orange-500 text-3xl">
                                                    flight_takeoff
                                                </span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-[#111418] dark:text-white">
                                                    Batik Air
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    ID-6506 • Boeing 737
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-[10px] font-bold rounded">
                                                Full Service
                                            </span>
                                        </div>
                                    </div>
                                    <div class="md:col-span-2 flex items-center justify-between px-4">
                                        <div class="text-center">
                                            <p class="text-xl font-bold text-[#111418] dark:text-white">
                                                10:45
                                            </p>
                                            <p class="text-xs text-gray-500 font-medium">
                                                CGK
                                            </p>
                                        </div>
                                        <div class="flex-1 px-8 flex flex-col items-center">
                                            <p class="text-[10px] text-gray-400 font-bold mb-1">
                                                1h 55m
                                            </p>
                                            <div class="relative w-full h-[1px] bg-gray-300 dark:bg-gray-700">
                                                <div class="absolute -top-1 left-0 size-2 rounded-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
                                                </div>
                                                <div class="absolute -top-1 right-0 size-2 rounded-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
                                                </div>
                                                <span class="material-symbols-outlined absolute left-1/2 -translate-x-1/2 -top-3 text-primary bg-white dark:bg-gray-900 px-1">
                                                    flight
                                                </span>
                                            </div>
                                            <p class="text-[10px] text-green-600 dark:text-green-400 font-bold mt-1">
                                                Direct
                                            </p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xl font-bold text-[#111418] dark:text-white">
                                                13:40
                                            </p>
                                            <p class="text-xs text-gray-500 font-medium">
                                                DPS
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-1">
                                        <p class="text-2xl font-black text-primary">
                                            Rp 1.125.000
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            /passenger
                                        </p>
                                        <button class="mt-2 w-full md:w-auto min-w-[120px] bg-primary text-white font-bold py-2.5 px-6 rounded-lg hover:bg-primary/90 transition-all shadow-sm">
                                            Select
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-2 flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 dark:border-gray-800">
                                <div class="flex gap-4">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">
                                            luggage
                                        </span>
                                        20kg
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">
                                            restaurant
                                        </span>
                                        Meal included
                                    </span>
                                </div>
                                <button class="font-bold text-primary hover:underline">
                                    Flight Details
                                </button>
                            </div>
                        </div>
                        <!-- Flight Card 3 - Budget Option -->
                        <div class="bg-white dark:bg-gray-900 rounded-xl border border-primary/30 dark:border-primary/50 shadow-md overflow-hidden relative group">
                            <div class="absolute top-0 right-0">
                                <div class="bg-primary text-white text-[10px] font-black px-4 py-1 rounded-bl-lg uppercase tracking-wider">
                                    Cheapest
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-6">
                                    <div class="flex flex-col gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="size-12 rounded-lg bg-gray-50 dark:bg-gray-800 flex items-center justify-center border border-gray-100 dark:border-gray-700">
                                                <span class="material-symbols-outlined text-red-500 text-3xl">
                                                    flight_land
                                                </span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-[#111418] dark:text-white">
                                                    Lion Air
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    JT-32 • Boeing 737
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-[10px] font-bold rounded">
                                                LCC
                                            </span>
                                        </div>
                                    </div>
                                    <div class="md:col-span-2 flex items-center justify-between px-4">
                                        <div class="text-center">
                                            <p class="text-xl font-bold text-[#111418] dark:text-white">
                                                05:00
                                            </p>
                                            <p class="text-xs text-gray-500 font-medium">
                                                CGK
                                            </p>
                                        </div>
                                        <div class="flex-1 px-8 flex flex-col items-center">
                                            <p class="text-[10px] text-gray-400 font-bold mb-1">
                                                1h 55m
                                            </p>
                                            <div class="relative w-full h-[1px] bg-gray-300 dark:bg-gray-700">
                                                <div class="absolute -top-1 left-0 size-2 rounded-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
                                                </div>
                                                <div class="absolute -top-1 right-0 size-2 rounded-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
                                                </div>
                                                <span class="material-symbols-outlined absolute left-1/2 -translate-x-1/2 -top-3 text-primary bg-white dark:bg-gray-900 px-1">
                                                    flight
                                                </span>
                                            </div>
                                            <p class="text-[10px] text-green-600 dark:text-green-400 font-bold mt-1">
                                                Direct
                                            </p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xl font-bold text-[#111418] dark:text-white">
                                                07:55
                                            </p>
                                            <p class="text-xs text-gray-500 font-medium">
                                                DPS
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-1">
                                        <p class="text-2xl font-black text-primary">
                                            Rp 890.000
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            /passenger
                                        </p>
                                        <button class="mt-2 w-full md:w-auto min-w-[120px] bg-primary text-white font-bold py-2.5 px-6 rounded-lg hover:bg-primary/90 transition-all shadow-sm">
                                            Select
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-2 flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 dark:border-gray-800">
                                <div class="flex gap-4">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">
                                            luggage
                                        </span>
                                        Not Included
                                    </span>
                                    <span class="flex items-center gap-1 text-red-500 font-bold">
                                        <span class="material-symbols-outlined text-sm">
                                            error
                                        </span>
                                        Non-refundable
                                    </span>
                                </div>
                                <button class="font-bold text-primary hover:underline">
                                    Flight Details
                                </button>
                            </div>
                        </div>
                        <!-- Pagination -->
                        <div class="flex items-center justify-center gap-2 pt-8">
                            <button class="size-10 flex items-center justify-center rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 text-gray-500 hover:text-primary transition-all">
                                <span class="material-symbols-outlined">
                                    chevron_left
                                </span>
                            </button>
                            <button class="size-10 flex items-center justify-center rounded-lg bg-primary text-white font-bold">
                                1
                            </button>
                            <button class="size-10 flex items-center justify-center rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 text-[#111418] dark:text-white font-bold hover:border-primary transition-all">
                                2
                            </button>
                            <button class="size-10 flex items-center justify-center rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 text-[#111418] dark:text-white font-bold hover:border-primary transition-all">
                                3
                            </button>
                            <span class="px-2 text-gray-400">
                                ...
                            </span>
                            <button class="size-10 flex items-center justify-center rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 text-[#111418] dark:text-white font-bold hover:border-primary transition-all">
                                12
                            </button>
                            <button class="size-10 flex items-center justify-center rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 text-gray-500 hover:text-primary transition-all">
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </main>
            <!-- Footer Footer -->
            <footer class="bg-white dark:bg-gray-900 border-t border-[#f0f2f4] dark:border-gray-800 px-6 lg:px-20 py-12 mt-12">
                <div class="max-w-[1440px] mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
                    <div class="col-span-1 md:col-span-1">
                        <div class="flex items-center gap-3 text-primary mb-6">
                            <span class="material-symbols-outlined text-2xl">
                                flight_takeoff
                            </span>
                            <h2 class="text-[#111418] dark:text-white text-lg font-bold">
                                FlightBooker
                            </h2>
                        </div>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Your trusted partner for effortless flight reservations and travel planning worldwide. Modern, fast, and secure.
                        </p>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#111418] dark:text-white mb-6">
                            About
                        </h3>
                        <ul class="space-y-4 text-sm text-gray-500">
                            <li>
                                <a class="hover:text-primary transition-colors" href="#">
                                    How it works
                                </a>
                            </li>
                            <li>
                                <a class="hover:text-primary transition-colors" href="#">
                                    Partnership
                                </a>
                            </li>
                            <li>
                                <a class="hover:text-primary transition-colors" href="#">
                                    Business
                                </a>
                            </li>
                            <li>
                                <a class="hover:text-primary transition-colors" href="#">
                                    Reviews
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#111418] dark:text-white mb-6">
                            Support
                        </h3>
                        <ul class="space-y-4 text-sm text-gray-500">
                            <li>
                                <a class="hover:text-primary transition-colors" href="#">
                                    Help Center
                                </a>
                            </li>
                            <li>
                                <a class="hover:text-primary transition-colors" href="#">
                                    Contact Us
                                </a>
                            </li>
                            <li>
                                <a class="hover:text-primary transition-colors" href="#">
                                    Privacy Policy
                                </a>
                            </li>
                            <li>
                                <a class="hover:text-primary transition-colors" href="#">
                                    Terms of Service
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#111418] dark:text-white mb-6">
                            Follow Us
                        </h3>
                        <div class="flex gap-4">
                            <div class="size-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center cursor-pointer hover:bg-primary hover:text-white transition-all">
                                <span class="material-symbols-outlined text-xl">
                                    public
                                </span>
                            </div>
                            <div class="size-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center cursor-pointer hover:bg-primary hover:text-white transition-all">
                                <span class="material-symbols-outlined text-xl">
                                    share
                                </span>
                            </div>
                            <div class="size-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center cursor-pointer hover:bg-primary hover:text-white transition-all">
                                <span class="material-symbols-outlined text-xl">
                                    alternate_email
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="max-w-[1440px] mx-auto mt-12 pt-8 border-t border-gray-100 dark:border-gray-800 text-center text-xs text-gray-400">
                    <p>
                        © 2023 FlightBooker Inc. All rights reserved.
                    </p>
                </div>
            </footer>
        </div>
    </body>
</html>