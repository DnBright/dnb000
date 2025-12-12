<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Darkandbright' }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <!-- Sidebar -->
    <div class="flex">

        <aside class="w-64 bg-gray-900 text-white h-screen fixed">
            <div class="p-5 font-bold text-xl border-b border-gray-700">
                Darkandbright
            </div>

            <nav class="mt-5 space-y-2">
                <a href="/dashboard" class="block py-2 px-4 hover:bg-gray-700 rounded">Dashboard</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Projects</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Clients</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Settings</a>
            </nav>
        </aside>

        <!-- Content -->
        <main class="ml-64 w-full min-h-screen">

            <!-- Top Bar -->
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold">{{ $title ?? 'Dashboard' }}</h1>
                <div class="text-gray-600">Welcome, Admin</div>
            </header>

            <div class="p-6">
                @yield('content')
            </div>

        </main>

    </div>

</body>
</html>
