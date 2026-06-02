<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 text-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Perpustakaan Kita') - CRUD Buku</title>
    
    <!-- Google Fonts / Fonts through Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-full font-sans antialiased">
    <!-- Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo / Title -->
                <div class="flex items-center">
                    <a href="{{ route('books.index') }}" class="flex items-center space-x-3 group">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 text-white shadow-md shadow-indigo-200 transition-all duration-300 group-hover:scale-105">
                            <!-- Book Icon SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="font-extrabold text-xl tracking-tight bg-gradient-to-r from-slate-900 to-indigo-950 bg-clip-text text-transparent">
                            BookShelf
                        </span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('books.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">
                        Katalog Buku
                    </a>
                    <a href="{{ route('books.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white shadow-md shadow-indigo-100 hover:shadow-lg hover:shadow-indigo-200 transition-all duration-200">
                        Tambah Buku
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button type="button" id="mobile-menu-btn" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-slate-50 focus:outline-none transition-colors" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Buka menu utama</span>
                        <svg class="block h-6 w-6" id="menu-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" id="close-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Drawer) -->
        <div class="hidden md:hidden border-b border-slate-100 bg-white" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('books.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:text-indigo-600 hover:bg-slate-50 transition-all">
                    Katalog Buku
                </a>
                <a href="{{ route('books.create') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-all">
                    Tambah Buku
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- System Alerts / Flash Messages -->
        @if(session('success'))
            <div id="alert-toast" class="mb-6 flex items-center p-4 border-l-4 border-emerald-500 bg-emerald-50 text-emerald-800 rounded-r-xl shadow-sm transition-all duration-300 animate-slide-in">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3 font-medium text-sm">
                    {{ session('success') }}
                </div>
                <button type="button" class="ml-auto text-emerald-500 hover:text-emerald-800 transition-colors" onclick="document.getElementById('alert-toast').remove()">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800 py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-2">
                <span class="font-extrabold text-white text-lg tracking-tight">BookShelf</span>
                <span class="text-sm">| CRUD Perpustakaan Buku</span>
            </div>
            <p class="text-sm text-center md:text-right">
                &copy; {{ date('Y') }} Perpustakaan. Dibuat dengan Laravel, Tailwind CSS, & Vite.
            </p>
        </div>
    </footer>

    <!-- Interactive script to handle mobile drawer -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');

            if (btn && menu) {
                btn.addEventListener('click', () => {
                    const expanded = btn.getAttribute('aria-expanded') === 'true';
                    btn.setAttribute('aria-expanded', !expanded);
                    menu.classList.toggle('hidden');
                    menuIcon.classList.toggle('hidden');
                    closeIcon.classList.toggle('hidden');
                });
            }

            // Auto-hide alert toasts after 5 seconds
            const alertToast = document.getElementById('alert-toast');
            if (alertToast) {
                setTimeout(() => {
                    alertToast.style.opacity = '0';
                    setTimeout(() => alertToast.remove(), 300);
                }, 5000);
            }
        });
    </script>
</body>
</html>
