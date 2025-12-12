@extends('layouts.main')

@section('content')



{{-- HERO SECTION --}}
<section class="bg-gradient-to-br from-blue-600 to-indigo-700 pt-24 pb-20">
    <div class="container mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

        {{-- LEFT TEXT --}}
        <div class="text-white">
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">
                Layanan Desain Grafis & <br> Terlengkap
            </h1>

            <p class="opacity-90 text-lg mb-8">
                Temukan desainer terbaik untuk proyek Anda atau download template siap pakai dengan kualitas premium.
            </p>

            <div class="flex gap-4">
                <a href="#" class="bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold shadow hover:bg-gray-100 transition">
                    Mulai Proyek
                </a>
                <a href="#" class="border border-white px-6 py-3 rounded-lg font-semibold text-white hover:bg-white hover:text-blue-700 transition">
                    Jelajahi Template
                </a>
            </div>

            {{-- Stats Under Buttons --}}
            <div class="grid grid-cols-3 gap-4 mt-10">
                <div class="text-center">
                    <p class="text-3xl font-bold">50K+</p>
                    <p class="opacity-90 text-sm">Proyek Selesai</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold">1K+</p>
                    <p class="opacity-90 text-sm">Desainer Aktif</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold">98%</p>
                    <p class="opacity-90 text-sm">Kepuasan Klien</p>
                </div>
            </div>
        </div>

        {{-- RIGHT IMAGE --}}
        <div class="relative">
            <div class="absolute inset-0 rounded-3xl bg-white/20 blur-2xl"></div>

            <img src="https://dummyimage.com/600x400/eeeeee/000000&text=Gambar+Desain"
                 class="relative rounded-3xl shadow-xl border-4 border-white/40" alt="">
        </div>

    </div>
</section>

{{-- WHAT DO YOU NEED --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-6">Apa yang Anda Butuhkan?</h2>

        {{-- Search Bar --}}
        <div class="flex justify-center mb-10">
            <input type="text"
                   placeholder="Cari jasa desain, template, atau desainer..."
                   class="w-full md:w-2/3 lg:w-1/2 border rounded-full px-6 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        {{-- Categories --}}
        <div class="grid grid-cols-3 md:grid-cols-6 gap-5">

            @foreach (['Logo','Poster','Feed IG','Thumbnail','UI Kit','Packaging'] as $cat)
                <div class="flex flex-col items-center bg-gray-50 p-4 rounded-xl shadow-sm hover:shadow-lg transition cursor-pointer">
                    <div class="text-3xl">🎨</div>
                    <p class="mt-2 font-semibold">{{ $cat }}</p>
                </div>
            @endforeach

        </div>
    </div>
</section>

{{-- JASA TERPOPULER --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-4">Jasa Desain Terpopuler</h2>
        <p class="text-center text-gray-600 mb-10">
            Dapatkan desain berkualitas tinggi dari desainer profesional
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Card 1 --}}
            <div class="rounded-2xl overflow-hidden shadow-lg bg-black text-white">
                <img src="https://dummyimage.com/600x350/000/fff&text=Desain+Logo" alt="">
                <div class="p-6">
                    <h3 class="text-xl font-bold">Desain Logo Profesional</h3>
                    <p class="opacity-80 mt-1">Logo unik dan berkesan untuk brand Anda</p>
                    <p class="text-blue-400 text-2xl font-bold mt-4">Rp 150K</p>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="rounded-2xl overflow-hidden shadow-lg bg-green-100">
                <img src="https://dummyimage.com/600x350/f1fbe4/000&text=Feed+IG" alt="">
                <div class="p-6">
                    <h3 class="text-xl font-bold">Feed Instagram</h3>
                    <p class="text-gray-700 mt-1">Konten visual menarik untuk media sosial</p>
                    <p class="text-blue-700 text-2xl font-bold mt-4">Rp 75K</p>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="rounded-2xl overflow-hidden shadow-lg bg-gradient-to-br from-purple-700 to-red-500 text-white">
                <img src="https://dummyimage.com/600x350/ff0080/fff&text=Thumbnail" alt="">
                <div class="p-6">
                    <h3 class="text-xl font-bold">Thumbnail YouTube</h3>
                    <p class="opacity-90 mt-1">Thumbnail menarik untuk meningkatkan CTR</p>
                    <p class="text-blue-200 text-2xl font-bold mt-4">Rp 50K</p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- DESAINER TERBAIK --}}
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-4">Desainer Terbaik</h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mt-10">

            @foreach ([
                ['name'=>'Sarah Putri','role'=>'Logo & Brand Identity'],
                ['name'=>'Andi Rahman','role'=>'UI/UX Designer'],
                ['name'=>'Maya Sari','role'=>'Social Media Design'],
                ['name'=>'Budi Santoso','role'=>'Print Design']
            ] as $d)

            <div class="flex flex-col items-center">
                <img src="https://randomuser.me/api/portraits/women/44.jpg"
                     class="w-24 h-24 rounded-full shadow">
                <h3 class="mt-3 font-bold text-lg">{{ $d['name'] }}</h3>
                <p class="text-gray-600 text-sm">{{ $d['role'] }}</p>

                <p class="mt-2 text-yellow-500 font-bold">★ 4.9</p>

                <button class="mt-3 px-5 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold">
                    Lihat Profil
                </button>
            </div>

            @endforeach

        </div>
    </div>
</section>

{{-- TEMPLATE SIAP PAKAI --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-4">Template Siap Pakai</h2>
        <p class="text-center text-gray-600 mb-10">
            Download langsung, edit sesuai kebutuhan
        </p>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            @foreach ([
                ['name'=>'Business Card Templates','price'=>'Rp 25K'],
                ['name'=>'Instagram Story Pack','price'=>'Gratis'],
                ['name'=>'Presentation Template','price'=>'Rp 75K'],
                ['name'=>'Brochure Template','price'=>'Rp 35K']
            ] as $t)

            <div class="rounded-xl overflow-hidden shadow-lg bg-white">
                <img src="https://dummyimage.com/600x350/ddd/000&text=Template" alt="">
                <div class="p-4">
                    <h3 class="font-bold">{{ $t['name'] }}</h3>
                    <p class="text-blue-700 font-bold mt-2">{{ $t['price'] }}</p>
                    <button class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">
                        Download
                    </button>
                </div>
            </div>

            @endforeach
        </div>
    </div>
</section>

{{-- TESTIMONI --}}
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-8">Apa Kata Klien Kami</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            @foreach ([
                ['msg'=>'Pelayanan sangat memuaskan! Desainer sangat memahami brief.'],
                ['msg'=>'Template yang tersedia sangat berkualitas dan mudah diedit.'],
                ['msg'=>'Proses pemesanan mudah, komunikasi lancar.']
            ] as $testi)

            <div class="p-6 shadow rounded-xl">
                <p class="text-yellow-500 text-xl">★★★★★</p>
                <p class="mt-3 text-gray-700">{{ $testi['msg'] }}</p>
                <p class="mt-4 font-semibold text-gray-900">Klien</p>
            </div>

            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 bg-gradient-to-r from-blue-700 to-indigo-700 text-center text-white">
    <h2 class="text-3xl font-bold">Siap Memulai Proyek Desain Anda?</h2>
    <p class="mt-2 opacity-90">Bergabung dengan ribuan klien yang puas dengan layanan kami</p>

    <div class="mt-6 flex justify-center gap-4">
        <button class="bg-white text-blue-700 px-8 py-3 rounded-lg font-semibold">
            Mulai Sekarang
        </button>
        <button class="bg-white/10 border border-white px-8 py-3 rounded-lg font-semibold">
            Jelajahi Template
        </button>
    </div>
</section>

@endsection
