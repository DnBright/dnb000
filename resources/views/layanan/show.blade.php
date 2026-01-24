@extends('layouts.main')

@section('content')

<div class="max-w-4xl mx-auto mt-12">
    <div class="bg-white p-8 rounded-xl shadow">
        <div class="flex flex-col md:flex-row gap-6 items-center">
            <img src="https://source.unsplash.com/800x500/?{{ urlencode($info['title']) }}" alt="{{ $info['title'] }}" class="w-full md:w-1/2 h-56 object-cover rounded-lg">

            <div class="flex-1">
                <h1 class="text-2xl font-bold mb-2">{{ $info['title'] }}</h1>
                <p class="text-gray-600 mb-6">{{ $info['description'] }}</p>

                <div class="flex gap-3">
                    <a href="{{ route('brief.show', ['paket' => $paket]) }}" class="px-4 py-2 bg-indigo-600 text-white rounded shadow">Mulai Brief</a>
                    <a href="{{ route('paket') }}" class="px-4 py-2 bg-gray-200 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
