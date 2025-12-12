@extends('layouts.main')

@section('content')

<!-- HEADER SECTION -->
<div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white pt-24 pb-12">
    <div class="max-w-5xl mx-auto px-6">
        <div class="flex items-center gap-3 mb-4">
            <span class="bg-white/20 px-4 py-2 rounded-lg text-sm font-semibold">STEP 3</span>
            <span class="text-white/70">Review Your Brief</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-3">Verifikasi Brief Anda</h1>
        <p class="text-blue-100 text-lg">Pastikan semua informasi sudah benar sebelum melanjutkan ke pembayaran</p>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="bg-gray-50 py-12">
    <div class="max-w-5xl mx-auto px-6">
        
        <!-- PROGRESS BAR -->
        <div class="mb-12">
            <div class="flex justify-between text-sm font-medium mb-3">
                <span class="text-gray-600">1. Pilih Paket</span>
                <span class="text-gray-600">2. Isi Brief</span>
                <span class="text-blue-600 font-bold">3. Review</span>
                <span class="text-gray-600">4. Pembayaran</span>
            </div>
            <div class="w-full bg-gray-300 h-2 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-blue-600 to-indigo-700 rounded-full" style="width: 75%"></div>
            </div>
        </div>

        <!-- SUMMARY CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card 1: Status -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-600">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-gray-600 font-medium">Status</h3>
                    <span class="text-green-500 text-2xl">✓</span>
                </div>
                <p class="text-2xl font-bold text-gray-900">Siap Diproses</p>
            </div>

            <!-- Card 2: Total Data -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-indigo-600">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-gray-600 font-medium">Data Terisi</h3>
                    <span class="text-indigo-600 text-2xl">📋</span>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ count($data ?? []) }} Field</p>
            </div>

            <!-- Card 3: Paket -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-600">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-gray-600 font-medium">Paket Dipilih</h3>
                    <span class="text-purple-600 text-2xl">🎁</span>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ ucfirst($data['paket'] ?? 'Standard') }}</p>
            </div>
        </div>

        <!-- DETAIL DATA -->
        <div class="bg-white rounded-xl shadow-md p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <span class="text-blue-600">📝</span> Detail Brief Anda
            </h2>

            <div class="space-y-6">
                <!-- Profil Perusahaan Section -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 text-blue-600">Profil Perusahaan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if(isset($data['nama']))
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 font-medium">Nama Pemilik</p>
                            <p class="text-lg text-gray-900 font-semibold">{{ $data['nama'] }}</p>
                        </div>
                        @endif

                        @if(isset($data['email']))
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 font-medium">Email</p>
                            <p class="text-lg text-gray-900 font-semibold">{{ $data['email'] }}</p>
                        </div>
                        @endif

                        @if(isset($data['whatsapp']))
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 font-medium">WhatsApp</p>
                            <p class="text-lg text-gray-900 font-semibold">{{ $data['whatsapp'] }}</p>
                        </div>
                        @endif

                        @if(isset($data['brand']))
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 font-medium">Brand/Logo</p>
                            <p class="text-lg text-gray-900 font-semibold">{{ $data['brand'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Brief Logo Section -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 text-indigo-600">Detail Brief</h3>
                    <div class="space-y-4">
                        @if(isset($data['jenis_usaha']))
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 font-medium">Jenis Usaha</p>
                            <p class="text-base text-gray-900">{{ $data['jenis_usaha'] }}</p>
                        </div>
                        @endif

                        @if(isset($data['keterangan']))
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 font-medium">Keterangan/Arahan Desain</p>
                            <p class="text-base text-gray-900 whitespace-pre-wrap">{{ $data['keterangan'] }}</p>
                        </div>
                        @endif

                        @if(isset($data['warna']))
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 font-medium">Warna Dominan</p>
                            <p class="text-base text-gray-900">{{ $data['warna'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Raw Data Fallback -->
                @if(empty($data) || count($data) == 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-yellow-800">Data brief tidak tersedia. Silakan kembali ke halaman brief.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="flex flex-col sm:flex-row gap-4 mb-8">
            <a href="{{ route('brief.show', $paket ?? 'standard') }}"
               class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-4 px-6 rounded-xl shadow-md transition transform hover:scale-105 flex items-center justify-center gap-2">
               ← Kembali ke Brief
            </a>
            <a href="/payment"
               class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-semibold py-4 px-6 rounded-xl shadow-md transition transform hover:scale-105 flex items-center justify-center gap-2">
               Lanjut ke Pembayaran →
            </a>
        </div>

        <!-- INFO SECTION -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex gap-4">
                <span class="text-blue-600 text-2xl">ℹ️</span>
                <div>
                    <h4 class="font-semibold text-blue-900 mb-1">Perhatian Penting</h4>
                    <p class="text-blue-800 text-sm">Pastikan semua data sudah benar sebelum melanjutkan. Anda akan menerima invoice dan detail proyek melalui email setelah pembayaran dikonfirmasi.</p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
