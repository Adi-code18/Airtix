<!DOCTYPE html>
<html class="light" lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&display=swap" rel="stylesheet"/>
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
        <title>Login - Airtix Flight Reservation</title>
    </head>
    <body class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white transition-colors duration-200">
        <div class="relative flex min-h-screen w-full flex-col justify-center items-center overflow-x-hidden py-12 px-4 sm:px-6 lg:px-8">
            
            <!-- Background Accent -->
            <div class="absolute inset-0 bg-cover bg-center z-0 filter blur-sm opacity-10" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCCqPFtu2z1DqRpS03OEXgdzAgkOv4f-URWEZg1guAjFfnrx6GX0A8DuuMhMN6P_5vKkzfS9AFJkdVEqDjfjyKMwHQMtpw9aPgWcM446pjOwhBzBBaZSfBoUmTogx8_hmdm1DLIQOQXFUS2d2RkudPCLjx1IXswFmrgQ8xoxvci5qcwVOg5CDKp47VyszXS6Gg_FDHfBHvkjCG5eg3aLA6jv-mUYTw0KqmMeYMgjILvHobaJyFJm0PteaqXibJiikSVX2jxoOo-khg");'></div>

            <!-- Back to Home -->
            <a href="{{ route('homepage') }}" class="absolute top-6 left-6 flex items-center gap-2 text-gray-500 hover:text-primary transition-colors font-semibold text-sm z-10">
                <span class="material-symbols-outlined">arrow_back</span>
                Kembali ke Beranda
            </a>

            <!-- Main Auth Container -->
            <div class="relative z-10 w-full max-w-md">
                
                <!-- Logo & Brand Header -->
                <div class="flex flex-col items-center mb-8">
                    <div class="flex items-center gap-2 text-primary mb-2">
                        <span class="material-symbols-outlined text-4xl">flight_takeoff</span>
                        <h2 class="text-3xl font-extrabold leading-tight tracking-tight">Airtix</h2>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Masuk untuk memesan tiket penerbangan impian Anda</p>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="flex items-center gap-2 p-4 mb-4 text-sm text-green-800 rounded-xl bg-green-50 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800/50" role="alert">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="flex items-start gap-2 p-4 mb-4 text-sm text-yellow-800 rounded-xl bg-yellow-50 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800/50" role="alert">
                        <span class="material-symbols-outlined text-lg mt-0.5">warning</span>
                        <span class="font-medium">{{ session('warning') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="flex items-center gap-2 p-4 mb-4 text-sm text-red-800 rounded-xl bg-red-50 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800/50" role="alert">
                        <span class="material-symbols-outlined text-lg">error</span>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Card Form -->
                <div class="bg-white dark:bg-[#1a2530] px-8 py-10 rounded-2xl shadow-2xl border border-gray-100 dark:border-white/5 transition-all">
                    
                    <!-- Login Title -->
                    <h3 class="text-xl font-bold mb-6 text-[#111418] dark:text-white">Silakan Masuk</h3>

                    <form action="{{ route('login') }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <!-- Email Input -->
                        <div class="flex flex-col gap-1.5">
                            <label for="email" class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-1">Alamat Email</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">mail</span>
                                <input id="email" name="email" type="email" required value="{{ old('email') }}"
                                    class="w-full pl-10 pr-4 py-3 bg-[#f0f2f4] dark:bg-[#2d3a4a] border-none rounded-xl text-sm focus:ring-2 focus:ring-primary text-[#111418] dark:text-white placeholder-gray-400"
                                    placeholder="nama@email.com"/>
                            </div>
                            @error('email')
                                <span class="text-xs text-red-500 font-semibold px-1 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="flex flex-col gap-1.5">
                            <div class="flex justify-between items-center px-1">
                                <label for="password" class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Kata Sandi</label>
                                <a href="#" class="text-xs font-bold text-primary hover:underline">Lupa Sandi?</a>
                            </div>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">lock</span>
                                <input id="password" name="password" type="password" required
                                    class="w-full pl-10 pr-4 py-3 bg-[#f0f2f4] dark:bg-[#2d3a4a] border-none rounded-xl text-sm focus:ring-2 focus:ring-primary text-[#111418] dark:text-white placeholder-gray-400"
                                    placeholder="••••••••"/>
                            </div>
                            @error('password')
                                <span class="text-xs text-red-500 font-semibold px-1 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between px-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input name="remember" type="checkbox" class="w-4 h-4 text-primary rounded border-gray-300 dark:border-gray-600 focus:ring-primary dark:bg-gray-700"/>
                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">Ingat Saya</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full py-3 bg-primary hover:bg-primary/95 text-white font-bold rounded-xl text-sm transition-all shadow-lg hover:shadow-primary/30 flex items-center justify-center gap-2">
                            Masuk
                            <span class="material-symbols-outlined text-sm">login</span>
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200 dark:border-gray-800"></div>
                        </div>
                        <div class="relative flex justify-center text-xs font-bold uppercase">
                            <span class="bg-white dark:bg-[#1a2530] px-3 text-gray-400 dark:text-gray-500">Atau masuk dengan</span>
                        </div>
                    </div>

                    <!-- Google Sign In Button -->
                    <a href="{{ route('auth.google') }}" class="w-full py-3 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-[#111418] dark:text-white font-semibold rounded-xl text-sm border border-gray-200 dark:border-gray-700 transition-all flex items-center justify-center gap-3 shadow-sm">
                        <!-- Custom Google Icon SVG -->
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.56-2.77c-.98.66-2.23 1.06-3.72 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l3.66-2.85z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Masuk dengan Google
                    </a>

                    <!-- Register Link -->
                    <p class="mt-8 text-center text-xs text-gray-500 dark:text-gray-400 font-semibold">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-primary hover:underline font-bold ml-1">Daftar Sekarang</a>
                    </p>

                </div>

            </div>
        </div>
    </body>
</html>
