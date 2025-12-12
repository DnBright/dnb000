<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

<div class="w-full max-w-md bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">Admin Login</h2>

    @if(session('error'))
        <div class="bg-red-200 text-red-700 p-2 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <label>Email</label>
        <input type="email" name="email" class="w-full border p-2 rounded mb-4" required>

        <label>Password</label>
        <input type="password" name="password" class="w-full border p-2 rounded mb-4" required>

        <button class="w-full bg-indigo-600 text-white py-2 rounded">Login</button>
    </form>
</div>

</body>
</html>
