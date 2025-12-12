@extends('layouts.main')

@section('content')
<div class="w-full min-h-screen bg-gradient-to-br from-blue-600 to-indigo-700 py-16 px-4">

    <div class="max-w-4xl mx-auto bg-white p-10 rounded-2xl shadow-xl">

        {{-- Judul --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Hubungi Kami</h1>
        <p class="text-gray-500 mb-10">
            Kami siap membantu kebutuhan desain Anda. Silakan isi formulir di bawah ini.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            {{-- FORM KONTAK --}}
            <form action="#" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text"
                        class="w-full px-4 py-3 border rounded-xl bg-gray-50 focus:ring-2 focus:ring-indigo-500 outline-none"
                        placeholder="Masukkan nama Anda" required>
                </div>

                <div>
                    <label class="font-medium text-gray-700">Email</label>
                    <input type="email"
                        class="w-full px-4 py-3 border rounded-xl bg-gray-50 focus:ring-2 focus:ring-indigo-500 outline-none"
                        placeholder="example@mail.com" required>
                </div>

                <div>
                    <label class="font-medium text-gray-700">Whatsapp</label>
                    <input type="text"
                        class="w-full px-4 py-3 border rounded-xl bg-gray-50 focus:ring-2 focus:ring-indigo-500 outline-none"
                        placeholder="08xxxxxxxxxx" required>
                </div>

                <div>
                    <label class="font-medium text-gray-700">Pesan</label>
                    <textarea rows="4"
                        class="w-full px-4 py-3 border rounded-xl bg-gray-50 focus:ring-2 focus:ring-indigo-500 outline-none"
                        placeholder="Tulis pesan Anda di sini..." required></textarea>
                </div>

                <button
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition shadow-lg">
                    Kirim Pesan
                </button>
            </form>

            {{-- INFO KONTAK --}}
            <div class="space-y-6">
                <div class="bg-gray-50 p-6 rounded-xl border">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Email</h3>
                    <p class="text-gray-600">kontak@grafisatu.com</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">WhatsApp</h3>
                    <p class="text-gray-600">+62 812 3456 7890</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Jam Operasional</h3>
                    <p class="text-gray-600">Senin–Jumat : 09.00 – 17.00</p>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
