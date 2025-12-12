@extends('layouts.main')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold">{{ $title ?? 'Dashboard' }}</h1>
        <p class="mt-2 text-gray-600">
            Selamat datang di dashboard Darkandbright.
        </p>
    </div>
@endsection
