<!DOCTYPE html>
<html class="light" lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries">
        </script>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
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
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
        </script>
        <title>
            Airtix - Flight Reservation
        </title>
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
                            <a class="text-[#111418] dark:text-gray-300 text-sm font-semibold leading-normal hover:text-primary transition-colors" href="#">
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
                    <!-- Flash Messages / Toast Banners -->
                    @if(session('success') || session('warning') || session('error'))
                        <div class="max-w-[1100px] mx-auto w-full px-6 mt-6">
                            @if(session('success'))
                                <div class="flex items-center justify-between p-4 mb-4 text-sm text-green-800 rounded-xl bg-green-50 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800/50" role="alert">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined">check_circle</span>
                                        <span class="font-semibold">{{ session('success') }}</span>
                                    </div>
                                </div>
                            @endif
                            @if(session('warning'))
                                <div class="flex items-center justify-between p-4 mb-4 text-sm text-yellow-800 rounded-xl bg-yellow-50 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800/50" role="alert">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined">warning</span>
                                        <span class="font-semibold">{{ session('warning') }}</span>
                                    </div>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="flex items-center justify-between p-4 mb-4 text-sm text-red-800 rounded-xl bg-red-50 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800/50" role="alert">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined">error</span>
                                        <span class="font-semibold">{{ session('error') }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Hero Section -->
                    <section class="relative w-full h-[540px] flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-cover bg-center z-0" data-alt="Modern airplane flying through blue sky and clouds" style='background-image: linear-gradient(rgba(16, 25, 34, 0.6) 0%, rgba(16, 25, 34, 0.3) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuCCqPFtu2z1DqRpS03OEXgdzAgkOv4f-URWEZg1guAjFfnrx6GX0A8DuuMhMN6P_5vKkzfS9AFJkdVEqDjfjyKMwHQMtpw9aPgWcM446pjOwhBzBBaZSfBoUmTogx8_hmdm1DLIQOQXFUS2d2RkudPCLjx1IXswFmrgQ8xoxvci5qcwVOg5CDKp47VyszXS6Gg_FDHfBHvkjCG5eg3aLA6jv-mUYTw0KqmMeYMgjILvHobaJyFJm0PteaqXibJiikSVX2jxoOo-khg");'>
                        </div>
                        <div class="relative z-10 w-full max-w-[1100px] px-6 text-center">
                            <h1 class="text-white text-5xl font-black leading-tight tracking-[-0.033em] mb-4">
                                Travelling with Airtix
                            </h1>
                            <p class="text-white/90 text-lg font-medium mb-10 max-w-2xl mx-auto">
                                Discover the world with our premium flight services. Book your next adventure today with the best prices.
                            </p>
                            <!-- Advanced Search Bar -->
                            <div class="bg-white dark:bg-[#1a2530] p-6 rounded-xl shadow-2xl flex flex-col gap-4 text-left border border-white/10">
                                <div class="flex gap-4">
                                    <button class="trip-type-btn px-4 py-2 bg-primary/10 text-primary rounded-lg text-sm font-bold flex items-center gap-2" data-type="roundtrip">
                                        <span class="material-symbols-outlined text-lg">
                                            sync_alt
                                        </span>
                                        Round Trip
                                    </button>
                                    <button class="trip-type-btn px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-lg text-sm font-bold" data-type="oneway">
                                        One Way
                                    </button>
                                    <button class="trip-type-btn px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-lg text-sm font-bold" data-type="multicity">
                                        Multi-city
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                                    <div class="flex flex-col gap-1.5 relative">
                                        <span class="text-xs font-bold text-gray-500 uppercase px-1">
                                            From
                                        </span>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                                flight_takeoff
                                            </span>
                                            <input id="origin-input" class="origin-input w-full pl-10 pr-4 py-3 bg-[#f0f2f4] dark:bg-[#2d3a4a] border-none rounded-lg text-sm focus:ring-2 focus:ring-primary text-[#111418] dark:text-white" placeholder="Origin City" type="text" autocomplete="off"/>
                                            <ul id="origin-suggestions" class="origin-suggestions hidden absolute top-full left-0 right-0 bg-white dark:bg-[#2d3a4a] border border-gray-200 dark:border-gray-700 rounded-lg mt-1 max-h-48 overflow-y-auto z-50 shadow-lg"></ul>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1.5 relative">
                                        <span class="text-xs font-bold text-gray-500 uppercase px-1">
                                            To
                                        </span>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                                flight_land
                                            </span>
                                            <input id="destination-input" class="destination-input w-full pl-10 pr-4 py-3 bg-[#f0f2f4] dark:bg-[#2d3a4a] border-none rounded-lg text-sm focus:ring-2 focus:ring-primary text-[#111418] dark:text-white" placeholder="Destination City" type="text" autocomplete="off"/>
                                            <ul id="destination-suggestions" class="destination-suggestions hidden absolute top-full left-0 right-0 bg-white dark:bg-[#2d3a4a] border border-gray-200 dark:border-gray-700 rounded-lg mt-1 max-h-48 overflow-y-auto z-50 shadow-lg"></ul>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <span class="text-xs font-bold text-gray-500 uppercase px-1">
                                            Departure
                                        </span>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                                calendar_today
                                            </span>
                                            <input id="departure-date" class="w-full pl-10 pr-4 py-3 bg-[#f0f2f4] dark:bg-[#2d3a4a] border-none rounded-lg text-sm focus:ring-2 focus:ring-primary text-[#111418] dark:text-white" placeholder="Select Date" type="date"/>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1.5 return-date-container">
                                        <span class="text-xs font-bold text-gray-500 uppercase px-1">
                                            Return
                                        </span>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                                calendar_today
                                            </span>
                                            <input id="return-date" class="w-full pl-10 pr-4 py-3 bg-[#f0f2f4] dark:bg-[#2d3a4a] border-none rounded-lg text-sm focus:ring-2 focus:ring-primary text-[#111418] dark:text-white" placeholder="Select Date" type="date"/>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <span class="text-xs font-bold text-gray-500 uppercase px-1">
                                            Passengers
                                        </span>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                                person
                                            </span>
                                            <input id="passengers" class="w-full pl-10 pr-4 py-3 bg-[#f0f2f4] dark:bg-[#2d3a4a] border-none rounded-lg text-sm focus:ring-2 focus:ring-primary text-[#111418] dark:text-white" type="text" value="1 Adult" placeholder="Passengers"/>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1.5 justify-end">
                                        <button id="search-btn" class="w-full py-3 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold text-sm transition-all shadow-lg flex items-center justify-center gap-2">
                                            <span class="material-symbols-outlined text-lg">
                                                search
                                            </span>
                                            Search
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Flight Results Container -->
                                <div id="results-container" class="hidden mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <h3 class="text-lg font-bold mb-4">Available Flights</h3>
                                    <div id="flights-list" class="space-y-3"></div>
                                </div>
                            </div>
                            
                            <script>
                                let originData = null;
                                let destinationData = null;
                                let activeType = 'roundtrip';
                                
                                // Trip Type Toggle
                                document.querySelectorAll('.trip-type-btn').forEach(btn => {
                                    btn.addEventListener('click', function() {
                                        document.querySelectorAll('.trip-type-btn').forEach(b => {
                                            b.classList.remove('bg-primary/10', 'text-primary');
                                            b.classList.add('hover:bg-gray-100', 'dark:hover:bg-gray-800', 'text-gray-600', 'dark:text-gray-300');
                                        });
                                        this.classList.add('bg-primary/10', 'text-primary');
                                        this.classList.remove('hover:bg-gray-100', 'dark:hover:bg-gray-800', 'text-gray-600', 'dark:text-gray-300');
                                        activeType = this.dataset.type;
                                        
                                        if (activeType === 'oneway') {
                                            document.querySelector('.return-date-container').classList.add('hidden');
                                        } else {
                                            document.querySelector('.return-date-container').classList.remove('hidden');
                                        }
                                    });
                                });
                                
                                // Airport Autocomplete
                                async function fetchAirports(query, suggestionsElementId) {
                                    if (query.length < 2) {
                                        document.getElementById(suggestionsElementId).classList.add('hidden');
                                        return;
                                    }
                                    
                                    try {
                                        const response = await fetch(`{{ route('api.airports') }}?q=${encodeURIComponent(query)}`);
                                        const airports = await response.json();
                                        
                                        const suggestionsEl = document.getElementById(suggestionsElementId);
                                        suggestionsEl.innerHTML = '';
                                        
                                        if (airports.length === 0) {
                                            suggestionsEl.innerHTML = '<li class="px-4 py-2 text-gray-500">No airports found</li>';
                                        } else {
                                            airports.forEach(airport => {
                                                const li = document.createElement('li');
                                                li.className = 'px-4 py-2 hover:bg-primary/10 cursor-pointer text-sm text-[#111418] dark:text-white';
                                                li.innerHTML = `<strong>${airport.label}</strong><br><small class="text-gray-500">${airport.name}</small>`;
                                                li.addEventListener('click', () => selectAirport(suggestionsElementId === 'origin-suggestions' ? 'origin' : 'destination', airport));
                                                suggestionsEl.appendChild(li);
                                            });
                                        }
                                        
                                        suggestionsEl.classList.remove('hidden');
                                    } catch (error) {
                                        console.error('Error fetching airports:', error);
                                    }
                                }
                                
                                function selectAirport(type, airport) {
                                    if (type === 'origin') {
                                        document.getElementById('origin-input').value = airport.label;
                                        originData = airport;
                                        document.getElementById('origin-suggestions').classList.add('hidden');
                                    } else {
                                        document.getElementById('destination-input').value = airport.label;
                                        destinationData = airport;
                                        document.getElementById('destination-suggestions').classList.add('hidden');
                                        // Trigger search automatically when destination is selected
                                        performSearch();
                                    }
                                }
                                
                                // Input listeners
                                document.getElementById('origin-input').addEventListener('input', function(e) {
                                    fetchAirports(e.target.value, 'origin-suggestions');
                                });
                                
                                document.getElementById('destination-input').addEventListener('input', function(e) {
                                    fetchAirports(e.target.value, 'destination-suggestions');
                                });
                                
                                // Search button
                                document.getElementById('search-btn').addEventListener('click', performSearch);
                                
                                async function performSearch() {
                                    const origin = originData?.code || document.getElementById('origin-input').value;
                                    const destination = destinationData?.code || document.getElementById('destination-input').value;
                                    const departureDate = document.getElementById('departure-date').value;
                                    
                                    if (!origin || !destination) {
                                        alert('Please select both origin and destination');
                                        return;
                                    }
                                    
                                    try {
                                        const searchUrl = `{{ route('flights.search') }}?origin=${encodeURIComponent(origin)}&destination=${encodeURIComponent(destination)}${departureDate ? '&departure_date=' + departureDate : ''}`;
                                        
                                        const response = await fetch(searchUrl, {
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest'
                                            }
                                        });
                                        
                                        const data = await response.json();
                                        
                                        if (data.success) {
                                            displayFlights(data.schedules);
                                        } else {
                                            alert('Error fetching flights');
                                        }
                                    } catch (error) {
                                        console.error('Error searching flights:', error);
                                    }
                                }
                                
                                function displayFlights(schedules) {
                                    const resultContainer = document.getElementById('results-container');
                                    const flightsList = document.getElementById('flights-list');
                                    
                                    flightsList.innerHTML = '';
                                    
                                    if (schedules.length === 0) {
                                        flightsList.innerHTML = '<p class="text-gray-500">No flights found</p>';
                                    } else {
                                        schedules.forEach(schedule => {
                                            const departure = new Date(schedule.departure_time);
                                            const arrival = new Date(schedule.arrival_time);
                                            
                                            const flightEl = document.createElement('div');
                                            flightEl.className = 'flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow';
                                            flightEl.innerHTML = `
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-4">
                                                        <div class="text-center">
                                                            <p class="text-xs text-gray-500">From</p>
                                                            <p class="font-bold text-lg">${schedule.origin_airport.data_airport_code}</p>
                                                            <p class="text-xs text-gray-500">${departure.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}</p>
                                                        </div>
                                                        <div class="flex-1 text-center">
                                                            <p class="text-xs text-gray-500">Duration</p>
                                                            <div class="flex items-center justify-center gap-2">
                                                                <div class="h-px flex-1 bg-gray-300"></div>
                                                                <span class="material-symbols-outlined text-lg">flight_takeoff</span>
                                                                <div class="h-px flex-1 bg-gray-300"></div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <p class="text-xs text-gray-500">To</p>
                                                            <p class="font-bold text-lg">${schedule.destination_airport.data_airport_code}</p>
                                                            <p class="text-xs text-gray-500">${arrival.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="ml-4 px-6 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold text-sm transition-colors">
                                                    Select
                                                </button>
                                            `;
                                            flightsList.appendChild(flightEl);
                                        });
                                    }
                                    
                                    resultContainer.classList.remove('hidden');
                                }
                                
                                // Close suggestions when clicking outside
                                document.addEventListener('click', function(e) {
                                    if (!e.target.closest('.relative')) {
                                        document.getElementById('origin-suggestions').classList.add('hidden');
                                        document.getElementById('destination-suggestions').classList.add('hidden');
                                    }
                                });
                            </script>
                        </div>
                    </section>
                    <!-- Popular Destinations Section -->
                    <section class="max-w-[1100px] mx-auto w-full px-6 mt-16">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h2 class="text-2xl font-bold text-[#111418] dark:text-white">
                                    Popular Destinations
                                </h2>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">
                                    Most loved places by our travelers
                                </p>
                            </div>
                            <button class="text-primary font-bold text-sm flex items-center gap-1 hover:underline">
                                View All
                                <span class="material-symbols-outlined text-sm">
                                    arrow_forward
                                </span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Destination Card 1 -->
                            <div class="group cursor-pointer">
                                <div class="relative h-64 w-full rounded-xl overflow-hidden mb-3">
                                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110" data-alt="Beautiful sunset over Tokyo cityscape" data-location="Tokyo, Japan" style='background-image: url("https://howliday.id/wp-content/uploads/2025/01/Tokyo-scaled.jpg");'>
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent">
                                    </div>
                                    <div class="absolute bottom-4 left-4 text-white">
                                        <p class="text-xs font-bold uppercase tracking-wider opacity-80">
                                            Japan
                                        </p>
                                        <h3 class="text-xl font-bold">
                                            Tokyo
                                        </h3>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center px-1">
                                    <span class="text-sm font-medium text-gray-500">
                                        Starts from
                                    </span>
                                    <span class="text-primary font-bold">
                                        $499
                                    </span>
                                </div>
                            </div>
                            <!-- Destination Card 2 -->
                            <div class="group cursor-pointer">
                                <div class="relative h-64 w-full rounded-xl overflow-hidden mb-3">
                                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110" data-alt="Stunning view of the Eiffel Tower in Paris" data-location="Paris, France" style='background-image: url("https://gotripzi.com/_astro/paris-fr-best-time-hero.FUkHM1Ln.webp");'>
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent">
                                    </div>
                                    <div class="absolute bottom-4 left-4 text-white">
                                        <p class="text-xs font-bold uppercase tracking-wider opacity-80">
                                            France
                                        </p>
                                        <h3 class="text-xl font-bold">
                                            Paris
                                        </h3>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center px-1">
                                    <span class="text-sm font-medium text-gray-500">
                                        Starts from
                                    </span>
                                    <span class="text-primary font-bold">
                                        $620
                                    </span>
                                </div>
                            </div>
                            <!-- Destination Card 3 -->
                            <div class="group cursor-pointer">
                                <div class="relative h-64 w-full rounded-xl overflow-hidden mb-3">
                                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110" data-alt="Tropical beach with turquoise water in Bali" data-location="Bali, Indonesia" style='background-image: url("https://tribratanews.polri.go.id/web/image/blog.post/61595/image");'>
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent">
                                    </div>
                                    <div class="absolute bottom-4 left-4 text-white">
                                        <p class="text-xs font-bold uppercase tracking-wider opacity-80">
                                            Indonesia
                                        </p>
                                        <h3 class="text-xl font-bold">
                                            Banda Neira
                                        </h3>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center px-1">
                                    <span class="text-sm font-medium text-gray-500">
                                        Starts from
                                    </span>
                                    <span class="text-primary font-bold">
                                        $350
                                    </span>
                                </div>
                            </div>
                            <!-- Destination Card 4 -->
                            <div class="group cursor-pointer">
                                <div class="relative h-64 w-full rounded-xl overflow-hidden mb-3">
                                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110" data-alt="Iconic Taj Mahal in India" data-location="India" style='background-image: url("https://i.natgeofe.com/k/42e832f5-fd48-43ff-b338-091bdf4048ca/india-tajmahal_16x9.jpg?w=1200");'>
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent">
                                    </div>
                                    <div class="absolute bottom-4 left-4 text-white">
                                        <p class="text-xs font-bold uppercase tracking-wider opacity-80">
                                            India
                                        </p>
                                        <h3 class="text-xl font-bold">
                                            Taj Mahal
                                        </h3>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center px-1">
                                    <span class="text-sm font-medium text-gray-500">
                                        Starts from
                                    </span>
                                    <span class="text-primary font-bold">
                                        $780
                                    </span>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Latest Promos Section -->
                    <section class="max-w-[1100px] mx-auto w-full px-6 mt-20">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h2 class="text-2xl font-bold text-[#111418] dark:text-white">
                                    Latest Promos
                                </h2>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">
                                    Don't miss out on these exclusive deals
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Promo 1 -->
                            <div class="flex bg-primary/10 dark:bg-primary/20 rounded-xl overflow-hidden border border-primary/20">
                                <div class="w-1/3 min-h-[160px] bg-cover bg-center" data-alt="Promo banner with airplane silhouette and cloud patterns" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCeFeSpZdSoI3IJ7HufzUFhOt6am1icGzUF6mFc7OyZFKkum172cE0C52dPb1sje2LnRhyt4Y1zVOQw32UyX9tnH4eCzpB_nTlX9Z8steSw753tj5Lkoq2pNvx6H0AWm7WqdDJ9x1VWUQ0QLkRBAWpIXaIOC9IhY2ebH79vbfCTJbtNj6fW8_g3fVjd4V3K22sHUj3zYKku1pPK5jjWyQXMyEhL1IMSStBVEEuWrG1nMYWPhlXj8pStPwMKXfSa985zIVQGcd8wkkw");'>
                                </div>
                                <div class="w-2/3 p-6 flex flex-col justify-center">
                                    <span class="bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded-full w-fit mb-2">
                                        LIMITED TIME
                                    </span>
                                    <h3 class="text-xl font-bold text-primary mb-1">
                                        Early Bird 30% Off
                                    </h3>
                                    <p class="text-sm text-[#111418] dark:text-gray-300 mb-4">
                                        Book 2 months in advance and get a massive discount on international flights.
                                    </p>
                                    <div class="flex items-center gap-2">
                                        <code class="bg-white dark:bg-gray-800 px-3 py-1 rounded border border-primary/30 text-primary font-mono font-bold text-xs uppercase tracking-widest">
                                            SKYBIRD30
                                        </code>
                                        <button class="text-primary text-xs font-bold hover:underline">
                                            Copy Code
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Promo 2 -->
                            <div class="flex bg-orange-500/10 dark:bg-orange-500/20 rounded-xl overflow-hidden border border-orange-500/20">
                                <div class="w-1/3 min-h-[160px] bg-cover bg-center" data-alt="Family travelers promo showing silhouettes of parents and children" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuA4mCBbD1PwfU2Giysoa-oJADfyiUrG5e3iKHhHm4CZOUnCWD5k5R0R0uZg6OEiWUgZS-p9uqhriqe4icArwa_oKoJ6U_WBYUWfir8tGxZ5J8dsQTZn5dwR4akKAFzy6WHhbMZW2Wb7u4fa2FtvwdzdFYy8PAO8SfS1q_YuKjQzgJIPnuv8VimLsGJUbHMIHtP6xXyA3w8vcCRICylQUZcrLt2qfmr3VtyuGCC-7rZcf3v2wbceZ_bSVvn0Jonj-CXKnvROqstlnl0");'>
                                </div>
                                <div class="w-2/3 p-6 flex flex-col justify-center">
                                    <span class="bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full w-fit mb-2">
                                        FAMILY DEAL
                                    </span>
                                    <h3 class="text-xl font-bold text-orange-600 mb-1">
                                        Family Adventure Pack
                                    </h3>
                                    <p class="text-sm text-[#111418] dark:text-gray-300 mb-4">
                                        Traveling with kids? Get free extra baggage and priority boarding for the whole family.
                                    </p>
                                    <div class="flex items-center gap-2">
                                        <code class="bg-white dark:bg-gray-800 px-3 py-1 rounded border border-orange-500/30 text-orange-600 font-mono font-bold text-xs uppercase tracking-widest">
                                            FAMILYFUN
                                        </code>
                                        <button class="text-orange-600 text-xs font-bold hover:underline">
                                            Copy Code
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
                <!-- Footer -->
                <footer class="bg-white dark:bg-[#1a2530] border-t border-[#dbe0e6] dark:border-[#2d3a4a] py-12">
                    <div class="max-w-[1100px] mx-auto px-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                            <div class="col-span-1 md:col-span-1">
                                <div class="flex items-center gap-2 text-primary mb-4">
                                    <span class="material-symbols-outlined text-3xl">
                                        flight_takeoff
                                    </span>
                                    <h2 class="text-[#111418] dark:text-white text-xl font-extrabold">
                                        Airtix
                                    </h2>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Making the world more accessible one flight at a time. Book your dream vacation with us today.
                                </p>
                            </div>
                            <div>
                                <h4 class="font-bold mb-4">
                                    Services
                                </h4>
                                <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                                    <li>
                                        <a class="hover:text-primary" href="#">
                                            Flight Search
                                        </a>
                                    </li>
                                    <li>
                                        <a class="hover:text-primary" href="#">
                                            Hotel Booking
                                        </a>
                                    </li>
                                    <li>
                                        <a class="hover:text-primary" href="#">
                                            Car Rentals
                                        </a>
                                    </li>
                                    <li>
                                        <a class="hover:text-primary" href="#">
                                            Travel Insurance
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-bold mb-4">
                                    Support
                                </h4>
                                <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                                    <li>
                                        <a class="hover:text-primary" href="#">
                                            Help Center
                                        </a>
                                    </li>
                                    <li>
                                        <a class="hover:text-primary" href="#">
                                            Contact Us
                                        </a>
                                    </li>
                                    <li>
                                        <a class="hover:text-primary" href="#">
                                            Refund Policy
                                        </a>
                                    </li>
                                    <li>
                                        <a class="hover:text-primary" href="#">
                                            Privacy Policy
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-bold mb-4">
                                    Follow Us
                                </h4>
                                <div class="flex gap-4">
                                    <a class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-primary hover:text-white transition-all" href="#">
                                        <span class="material-symbols-outlined">
                                            share
                                        </span>
                                    </a>
                                    <a class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-primary hover:text-white transition-all" href="#">
                                        <span class="material-symbols-outlined">
                                            public
                                        </span>
                                    </a>
                                    <a class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-primary hover:text-white transition-all" href="#">
                                        <span class="material-symbols-outlined">
                                            mail
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="mt-12 pt-8 border-t border-gray-100 dark:border-gray-800 text-center">
                            <p class="text-xs text-gray-400">
                                © 2023 SkyHigh Aviation Group. All rights reserved.
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>