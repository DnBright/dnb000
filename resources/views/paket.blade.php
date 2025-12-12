@extends('layouts.main')

@section('content')

<div class="max-w-5xl mx-auto mt-6">

    <h2 class="text-3xl font-bold mb-6">Pilih Paket yang Sesuai</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- BASIC -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-2">Basic</h3>
            <p class="text-2xl font-bold text-blue-600">Rp 299.000</p>

            <ul class="mt-4 space-y-2 text-gray-600">
                <li>✔ 1 Konsep Desain</li>
                <li>✔ 2x Revisi</li>
                <li>✔ File PNG & JPG</li>
            </ul>

            <a href="/brief/basic"
                class="block mt-6 text-center bg-blue-600 text-white py-2 rounded-lg hover:opacity-90">
                Pilih Paket
            </a>
        </div>

        <!-- STANDARD -->
        <div class="bg-white p-6 rounded-xl shadow border-2 border-blue-500 relative">
            <span class="absolute -top-3 right-3 bg-blue-600 text-white text-xs px-3 py-1 rounded-full">POPULER</span>
            <h3 class="text-xl font-semibold mb-2">Standard</h3>
            <p class="text-2xl font-bold text-blue-600">Rp 599.000</p>

            <ul class="mt-4 space-y-2 text-gray-600">
                <li>✔ 3 Konsep Desain</li>
                <li>✔ 4x Revisi</li>
                <li>✔ File PNG, JPG, PDF</li>
            </ul>

            <a href="/brief/standard"
                class="block mt-6 text-center bg-blue-600 text-white py-2 rounded-lg hover:opacity-90">
                Pilih Paket
            </a>
        </div>

        <!-- PREMIUM -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-2">Premium</h3>
            <p class="text-2xl font-bold text-blue-600">Rp 999.000</p>

            <ul class="mt-4 space-y-2 text-gray-600">
                <li>✔ 5 Konsep Desain</li>
                <li>✔ Unlimited Revisi</li>
                <li>✔ Semua Format File</li>
                <li>✔ Dedicated Designer</li>
            </ul>

            <a href="/brief/premium"
                class="block mt-6 text-center bg-blue-600 text-white py-2 rounded-lg hover:opacity-90">
                Pilih Paket
            </a>
        </div>

    </div>
</div>

@endsection
