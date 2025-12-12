@extends('layouts.main')

@section('content')
<div class="w-full min-h-screen bg-gradient-to-br from-blue-600 to-indigo-700 py-12">

    <!-- Step Progress -->
    <div class="max-w-4xl mx-auto mb-12">
        <div class="flex justify-between text-white text-sm font-medium">
            <div class="text-blue-200">1. Pilih Paket</div>
            <div class="text-white font-bold">2. Isi Brief</div>
            <div class="text-blue-200">3. Review</div>
            <div class="text-blue-200">4. Pembayaran</div>
        </div>

        <div class="w-full bg-white/20 h-1 rounded mt-3">
            <div class="h-1 bg-white rounded w-1/2"></div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="max-w-4xl mx-auto bg-white p-10 rounded-2xl shadow-xl">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Logo Design Brief</h1>

        <form action="/review" method="POST">
            @csrf

            <!-- Profil Perusahaan -->
            <div class="mb-10">
                <h2 class="section-title">Profil Perusahaan</h2>

                <div class="grid grid-cols-2 gap-6 mt-4">
                    <x-form.input label="Nama" name="nama" required />
                    <x-form.input label="Email" name="email" type="email" required />
                    <x-form.input label="Whatsapp" name="whatsapp" required />
                    <x-form.input label="Nama Brand/Logo" name="brand" required />

                    <div class="col-span-2">
                        <x-form.input label="Target Audience" name="audience" />
                    </div>
                </div>
            </div>

            <!-- Brief Logo -->
            <div class="mb-10">
                <h2 class="section-title">Brief Logo</h2>

                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div class="col-span-2">
                        <x-form.input label="Tagline (opsional)" name="tagline" />
                    </div>

                    <div class="col-span-2">
                        <x-form.input label="Jenis Usaha" name="jenis_usaha" required />
                    </div>

                    <div class="col-span-2">
                        <x-form.textarea label="Keterangan / Arahan Desain" name="keterangan" rows="4" />
                    </div>

                    <div class="col-span-2">
                        <x-form.input label="Referensi (link gambar/logo)" name="referensi" />
                    </div>

                    <div class="col-span-2">
                        <x-form.input label="Warna Dominan" name="warna" />
                    </div>
                </div>
            </div>

            <!-- Tipe Logo -->
            <div class="mb-10">
                <h2 class="section-title">Tipe Logo</h2>

                <div class="grid grid-cols-3 gap-4 mt-4">
                    @foreach (['Elegant','Fun','Classic','Vintage','Minimalist','Feminime','Modern','Complex','Serious'] as $type)
                        <label class="flex items-center gap-2 bg-gray-50 px-4 py-3 rounded-xl border hover:border-indigo-400 transition">
                            <input type="checkbox" name="tipe_logo[]" value="{{ $type }}" class="text-indigo-600">
                            <span class="text-gray-700">{{ $type }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Button -->
            <div class="flex gap-4 mt-6">
                <a href="/paket"
                   class="flex-1 bg-gray-500 hover:bg-gray-600 text-white text-center font-semibold py-4 rounded-xl shadow-lg transition">
                   ← Kembali ke Paket
                </a>
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-4 rounded-xl shadow-lg transition">
                    Lanjut ke Review →
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.section-title {
    @apply text-xl font-semibold text-gray-700;
}

.input-form {
    @apply w-full px-4 py-3 border rounded-xl bg-gray-50 focus:ring-2 focus:ring-indigo-400 focus:outline-none;
}
</style>
@endpush
