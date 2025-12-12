@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-6xl bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">

        {{-- LEFT SIDE --}}
        <div class="md:w-1/2 p-10 bg-gradient-to-br from-indigo-500 to-blue-500 text-white flex flex-col justify-between">

            {{-- LOGO --}}
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow">
                    <img src="https://cdn-icons-png.flaticon.com/512/1828/1828884.png" class="w-6 opacity-80">
                </div>
                <span class="text-xl font-semibold">Grafisatu</span>
            </div>

            {{-- QUOTE CARD --}}
            <div class="bg-white/20 backdrop-blur-lg p-6 rounded-xl shadow-lg">
                <h4 class="font-semibold mb-2">“Create without limits.”</h4>
                <p class="opacity-90 text-sm">
                    Make your brand stand out with designs crafted by top creative talent.
                </p>
            </div>

            <div class="mt-10">
                <h2 class="text-3xl md:text-4xl font-bold leading-tight mb-3">
                    Join our creative<br>community now.
                </h2>

                <p class="opacity-90">
                    Start your journey with professional designers everywhere.
                </p>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="md:w-1/2 p-10">

            <h2 class="text-3xl font-semibold text-gray-900 mb-3">Create your account 🚀</h2>
            <p class="text-gray-500 mb-8">Fill in the information below to get started.</p>

            {{-- FORM --}}
            <form class="space-y-5" action="#" method="POST">
                @csrf

                {{-- NAME --}}
                <div>
                    <label class="text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text"
                           class="w-full px-4 py-3 rounded-lg border outline-none focus:ring-2 focus:ring-indigo-500 mt-1"
                           placeholder="Your full name">
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email"
                           class="w-full px-4 py-3 rounded-lg border outline-none focus:ring-2 focus:ring-indigo-500 mt-1"
                           placeholder="name@example.com">
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label class="text-sm font-medium text-gray-700">Password</label>
                    <input type="password"
                           class="w-full px-4 py-3 rounded-lg border outline-none focus:ring-2 focus:ring-indigo-500 mt-1"
                           placeholder="••••••••">
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div>
                    <label class="text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password"
                           class="w-full px-4 py-3 rounded-lg border outline-none focus:ring-2 focus:ring-indigo-500 mt-1"
                           placeholder="Repeat password">
                </div>

                <button
                    class="w-full py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-lg shadow-md hover:opacity-90 transition">
                    Create Account
                </button>
            </form>

            <p class="text-sm text-gray-500 text-center mt-6">
                Already have an account?
                <a href="/login" class="text-indigo-600 font-semibold hover:underline">Sign in</a>
            </p>

        </div>
    </div>
</div>

<p class="text-center text-gray-400 text-sm mt-6">
    © 2023 Grafisatu Inc. All rights reserved.
</p>

@endsection
