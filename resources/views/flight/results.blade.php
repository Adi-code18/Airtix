<!DOCTYPE html>
<html class="light" lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries">
        </script>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
        </script>
        <title>Flight Results - Airtix</title>
    </head>
    <body class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white transition-colors duration-200">
        <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
            <div class="layout-container flex h-full grow flex-col">
                <!-- Navigation Bar -->
                <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-[#dbe0e6] dark:border-[#2d3a4a] px-10 py-3 bg-white dark:bg-[#1a2530]">
                    <div class="flex items-center gap-4 text-primary">
                        <div class="size-8 flex items-center justify-center">
                            <span class="material-symbols-outlined text-4xl">
                                
                            </span>
                        </div>
                        <h2 class="text-[#111418] dark:text-white text-xl font-extrabold leading-tight tracking-[-0.015em]">
                            Airtix
                        </h2>
                    </div>
                    <div class="flex flex-1 justify-end gap-8">
                        <div class="flex items-center gap-9">
                            <a class="text-[#111418] dark:text-gray-300 text-sm font-semibold leading-normal hover:text-primary transition-colors" href="{{ route('homepage') }}">
                                Home
                            </a>
                            <a class="text-[#111418] dark:text-gray-300 text-sm font-semibold leading-normal hover:text-primary transition-colors" href="#">
                                My Bookings
                            </a>
                            <a class="text-[#111418] dark:text-gray-300 text-sm font-semibold leading-normal hover:text-primary transition-colors" href="#">
                                Promotions
                            </a>
                        </div>
                        <div class="flex items-center gap-3">
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
                                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border-2 border-primary/20" style='background-image: url("{{ Auth::user()->avatar ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->email))) . '?d=mp' }}");'>
                                    </div>
                                    <form action="{{ route('logout') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="flex cursor-pointer items-center justify-center rounded-lg h-10 px-4 bg-red-500 hover:bg-red-600 text-white text-sm font-bold leading-normal transition-colors">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="flex min-w-[100px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary hover:bg-primary/90 text-white text-sm font-bold leading-normal tracking-[0.015em] transition-all">
                                    Sign In
                                </a>
                            @endauth
                        </div>
                    </div>
                </header>

                <main class="flex flex-col flex-1 pb-20">
                    <!-- Search Summary Section -->
                    <div class="max-w-6xl mx-auto w-full px-6 mt-8">
                        <div class="flex items-center justify-between mb-2">
                            <h1 class="text-3xl font-bold">
                                Flight Results
                            </h1>
                            <a href="{{ route('homepage') }}" class="text-primary font-bold text-sm flex items-center gap-1 hover:underline">
                                <span class="material-symbols-outlined text-lg">edit</span>
                                Modify Search
                            </a>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800/50 rounded-lg p-4 mb-8">
                            <p class="text-sm text-blue-900 dark:text-blue-300">
                                <strong>{{ $origin ?? 'Unknown' }}</strong> → <strong>{{ $destination ?? 'Unknown' }}</strong>
                                @if($departure_date)
                                    on <strong>{{ \Carbon\Carbon::parse($departure_date)->format('d M Y') }}</strong>
                                @endif
                                for <strong>{{ $passengers ?? 1 }} passenger(s)</strong>
                            </p>
                        </div>
                    </div>

                    <!-- Results Container -->
                    <div class="max-w-6xl mx-auto w-full px-6">
                        @if($schedules->count() > 0)
                            <div class="space-y-4">
                                @foreach($schedules as $schedule)
                                    @php
                                        $departure = \Carbon\Carbon::parse($schedule->departure_time);
                                        $arrival = \Carbon\Carbon::parse($schedule->arrival_time);
                                        $duration = $departure->diffInMinutes($arrival);
                                        $hours = floor($duration / 60);
                                        $minutes = $duration % 60;
                                    @endphp
                                    <div class="bg-white dark:bg-[#1a2530] border border-gray-200 dark:border-gray-700 rounded-xl p-6 hover:shadow-lg transition-shadow">
                                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center mb-4">
                                            <!-- Flight Info -->
                                            <div class="md:col-span-3">
                                                <div class="flex items-center justify-between">
                                                    <!-- Departure -->
                                                    <div class="text-center">
                                                        <p class="text-2xl font-bold text-primary">
                                                            {{ $departure->format('H:i') }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            {{ $schedule->origin_airport->data_airport_code ?? 'N/A' }}
                                                        </p>
                                                        <p class="text-xs text-gray-500">
                                                            {{ $departure->format('d M Y') }}
                                                        </p>
                                                    </div>

                                                    <!-- Duration & Route -->
                                                    <div class="flex-1 px-4 text-center">
                                                        <p class="text-xs text-gray-500 font-medium mb-2">
                                                            {{ $hours }}h {{ $minutes }}m
                                                        </p>
                                                        <div class="flex items-center gap-2 justify-center">
                                                            <div class="h-px flex-1 bg-gray-300 dark:bg-gray-600"></div>
                                                            <span class="material-symbols-outlined text-lg text-primary">
                                                                flight_takeoff
                                                            </span>
                                                            <div class="h-px flex-1 bg-gray-300 dark:bg-gray-600"></div>
                                                        </div>
                                                    </div>

                                                    <!-- Arrival -->
                                                    <div class="text-center">
                                                        <p class="text-2xl font-bold text-primary">
                                                            {{ $arrival->format('H:i') }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            {{ $schedule->destination_airport->data_airport_code ?? 'N/A' }}
                                                        </p>
                                                        <p class="text-xs text-gray-500">
                                                            {{ $arrival->format('d M Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Price & Action -->
                                            <div class="md:col-span-2 text-right">
                                                <div class="mb-3">
                                                    <p class="text-gray-500 text-xs">Price from</p>
                                                    <p class="text-3xl font-bold text-primary">
                                                        Rp 890.000
                                                    </p>
                                                </div>
                                                <button class="w-full py-2 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold text-sm transition-all">
                                                    Select
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Flight Details -->
                                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-xs">
                                                <div>
                                                    <p class="text-gray-500">Airline</p>
                                                    <p class="font-bold">
                                                        @if($schedule->flights->count() > 0)
                                                            Flight #{{ $schedule->flights->first()->flight_call }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500">Aircraft</p>
                                                    <p class="font-bold">
                                                        @if($schedule->flights->first() && $schedule->flights->first()->aircraft_instance)
                                                            {{ $schedule->flights->first()->aircraft_instance->id }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500">Status</p>
                                                    <p class="font-bold">
                                                        @if($schedule->flights->first() && $schedule->flights->first()->flight_status)
                                                            {{ $schedule->flights->first()->flight_status->id }}
                                                        @else
                                                            On Time
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500">Stops</p>
                                                    <p class="font-bold">Non-stop</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-gray-700 block mb-4">
                                    info
                                </span>
                                <h3 class="text-xl font-bold mb-2">No Flights Found</h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-6">
                                    Sorry, we couldn't find any flights matching your criteria. Try searching with different dates or destinations.
                                </p>
                                <a href="{{ route('homepage') }}" class="inline-block px-6 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold text-sm transition-all">
                                    Back to Search
                                </a>
                            </div>
                        @endif
                    </div>
                </main>

                <!-- Footer -->
                <footer class="mt-20 bg-white dark:bg-[#1a2530] border-t border-[#dbe0e6] dark:border-[#2d3a4a]">
                    <div class="max-w-[1100px] mx-auto px-6 py-12">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                            <div>
                                <h4 class="font-bold mb-3">About Airtix</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Your trusted partner for finding the best flight deals at the lowest prices.
                                </p>
                            </div>
                            <div>
                                <h4 class="font-bold mb-3">Company</h4>
                                <ul class="space-y-2 text-sm">
                                    <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary">About Us</a></li>
                                    <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary">Careers</a></li>
                                    <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary">Press</a></li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-bold mb-3">Support</h4>
                                <ul class="space-y-2 text-sm">
                                    <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary">Help Center</a></li>
                                    <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary">Contact Us</a></li>
                                    <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary">FAQ</a></li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-bold mb-3">Legal</h4>
                                <ul class="space-y-2 text-sm">
                                    <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary">Privacy</a></li>
                                    <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary">Terms</a></li>
                                    <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary">Cookies</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-8 text-center text-sm text-gray-500">
                            <p>&copy; 2026 Airtix. All rights reserved.</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
