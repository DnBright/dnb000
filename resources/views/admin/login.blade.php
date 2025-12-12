<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="w-full max-w-md bg-white p-6 shadow rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Admin Login</h2>

    @if($errors->any())
        <p class="text-red-500 mb-3">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <label>Email</label>
        <input type="email" name="email" class="w-full border p-2 rounded mb-3">

        <label>Password</label>
        <input type="password" name="password" class="w-full border p-2 rounded mb-3">

        <button class="w-full bg-indigo-600 text-white py-2 rounded">Login</button>
    </form>
</div>

</body>
</html>
