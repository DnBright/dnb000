<!doctype html>
<html lang="en" class="antialiased">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $title ?? 'Grafisatu Admin' }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/app.css','resources/js/app.js'])
  @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800">

  {{-- TOP HEADER (full width) --}}
  <header class="flex items-center justify-between px-4 md:px-8 py-4 bg-white border-b w-full">
    <div>
      <h2 class="text-2xl font-semibold">Dashboard Overview</h2>
      <p class="text-sm text-gray-500">Welcome back, here's what's happening today.</p>
    </div>
    <div class="flex items-center gap-4">
      <button class="lg:hidden px-3 py-2 rounded-md bg-gray-100" onclick="toggleSidebar()">☰</button>
      <div class="relative">
        <input type="search" placeholder="Search orders, services..." class="w-80 px-4 py-2 rounded-full border bg-gray-50">
      </div>
      <button class="px-4 py-2 bg-indigo-600 text-white rounded-full">+ New Service</button>
    </div>
  </header>

  <div class="min-h-screen flex">
    {{-- SIDEBAR --}}
    <aside id="adminSidebar" class="hidden lg:block w-72 bg-white border-r shadow-sm">
      <div class="px-6 py-6 border-b">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-blue-500 flex items-center justify-center text-white font-bold">G</div>
          <div>
            <div class="text-lg font-semibold">BOWOK</div>
            <div class="text-xs text-gray-500">Pro Seller</div>
          </div>
        </div>
      </div>

      <nav class="p-4 space-y-2 text-gray-700 dark:text-gray-200">

        <!-- DASHBOARD -->
        <a href="/admin/dashboard" class="block px-4 py-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">Dashboard</a>

        <!-- ORDERS -->
        <a href="{{ route('admin.orders') }}" class="flex items-center justify-between px-4 py-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
          <span>Orders</span>
          <span class="bg-red-200 text-red-700 text-sm px-2 py-0.5 rounded">3</span>
        </a>

        <!-- MY SERVICES -->
        <a href="/orders" class="flex items-center justify-between px-4 py-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
          <span>My Services</span>
          <span class="bg-red-200 text-red-700 text-sm px-2 py-0.5 rounded">3</span>
        </a>

        <!-- Digital Assets (expandable) -->
        <div>
          <button onclick="toggleMenu('menuDigital')" class="w-full flex justify-between items-center px-4 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
            <span>Digital Assets</span>
            <span>▼</span>
          </button>
          <div id="menuDigital" class="ml-4 mt-2 space-y-2 hidden">
            <a href="/" class="block px-4 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">Jasa Design</a>
            <a href="/review" class="block px-4 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">Review Client</a>
            <a href="/" class="block px-4 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">Paket Logo</a>
          </div>
        </div>

        <!-- CUSTOMERS -->
        <a href="{{ route('admin.customers') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">Customers</a>

      </nav>
    </aside>

    {{-- MAIN --}}
    <div class="flex-1">
      <main class="p-4 md:p-8">
        @yield('content')
      </main>
    </div>
  </div>

  <script>
    function toggleMenu(menuId) {
      const menu = document.getElementById(menuId);
      if (menu) menu.classList.toggle('hidden');
    }
    function toggleSidebar() {
      const sb = document.getElementById('adminSidebar');
      if (!sb) return;
      sb.classList.toggle('hidden');
    }
  </script>
  @stack('scripts')
</html>
