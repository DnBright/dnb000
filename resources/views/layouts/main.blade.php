<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Dark And Bright' }}</title>

    {{-- Vite Load --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-all duration-300">

    <!-- OVERLAY -->
    <div id="overlay"
         class="fixed inset-0 bg-black/40 hidden z-30"
         onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed top-0 left-0 w-72 h-full bg-white dark:bg-gray-800 shadow-lg z-40
               -translate-x-80 transition-transform duration-300">

        <div class="p-5 font-bold text-xl border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <span>Dark And Bright</span>

            <button onclick="toggleSidebar()" class="text-2xl md:hidden">
                ✕
            </button>
        </div>

        <nav class="p-4 space-y-2 text-gray-700 dark:text-gray-200">

            <a href="/"
               class="block px-4 py-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700
               {{ request()->is('/') ? 'bg-blue-600 text-white' : '' }}">
               Beranda
            </a>

            <a href="/portfolio"
               class="block px-4 py-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700
               {{ request()->is('portfolio') ? 'bg-blue-600 text-white' : '' }}">
               Portofolio
            </a>

            <a href="/paket"
               class="block px-4 py-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700
               {{ request()->is('paket') ? 'bg-blue-600 text-white' : '' }}">
               Paket
            </a>

            <a href="/contact"
               class="block px-4 py-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700
               {{ request()->is('contact') ? 'bg-blue-600 text-white' : '' }}">
               Contact
            </a>
        </nav>
    </aside>

    <!-- CONTENT -->
    <div id="content" class="transition-all duration-300 min-h-screen">

        <!-- HEADER -->
        <header class="bg-white dark:bg-gray-800 shadow p-4 flex justify-between items-center 
                       fixed top-0 left-0 w-full z-20">

            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="text-3xl">☰</button>
                <span class="font-semibold">Dark And Bright</span>
            </div>

            <div class="flex items-center gap-3">
                <button id="darkToggle"
                    class="px-3 py-1 rounded-lg bg-gray-200 dark:bg-gray-700">
                    🌙
                </button>

                <a href="{{ route('login') }}"

                  class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                  Login
                </a>

                <a href="/register"
                  class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg">
                  Daftar
                </a>
            </div>
        </header>

        <main class="pt-24 p-6">
            @yield('content')
        </main>
    </div>

    <!-- SCRIPT -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const content = document.getElementById('content');

            const closed = sidebar.classList.contains('-translate-x-80');

            if (closed) {
                sidebar.classList.remove('-translate-x-80');
                overlay.classList.remove('hidden');
                content.classList.add('ml-72');
            } else {
                sidebar.classList.add('-translate-x-80');
                overlay.classList.add('hidden');
                content.classList.remove('ml-72');
            }
        }

        // DARK MODE
        const html = document.documentElement;
        const toggle = document.getElementById('darkToggle');

        toggle.addEventListener('click', () => {
            html.classList.toggle('dark');
        });
    </script>

</body>
</html>
