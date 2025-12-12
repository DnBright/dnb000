@extends('layouts.main')
@section('content')


{{-- HERO --}}
<section class="bg-gradient-to-br from-purple-100 to-indigo-100 py-16 rounded-2xl">
    <div class="text-center max-w-3xl mx-auto">

        <h2 class="text-3xl font-bold text-gray-900 mb-4">
            Portfolio
        </h2>

        <p class="text-gray-600 text-lg">
            Explore my latest projects and creative works. Each piece represents a unique
            challenge solved with innovative design and development.
        </p>

        {{-- FILTER --}}
        <div class="flex justify-center gap-3 mt-8 flex-wrap">
            <button class="px-5 py-2 rounded-full bg-blue-600 text-white shadow">
                All Projects
            </button>

            <button class="px-5 py-2 rounded-full bg-white shadow hover:bg-gray-100">
                Web Design
            </button>

            <button class="px-5 py-2 rounded-full bg-white shadow hover:bg-gray-100">
                Mobile Apps
            </button>

            <button class="px-5 py-2 rounded-full bg-white shadow hover:bg-gray-100">
                Branding
            </button>

            <button class="px-5 py-2 rounded-full bg-white shadow hover:bg-gray-100">
                UI/UX
            </button>
        </div>

    </div>
</section>


{{-- PORTFOLIO GRID --}}
<section class="py-16">
    <div class="grid md:grid-cols-3 gap-10">

        {{-- CARD 1 --}}
        <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">
            <img src="https://dummyimage.com/600x350/3b0aff/ffffff&text=E-Commerce+Platform" class="w-full" />
            <div class="p-6">
                <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-full">Web Design</span>

                <h3 class="text-xl font-bold mt-3">E-Commerce Platform</h3>

                <p class="text-gray-600 mt-2">
                    Modern online shopping experience with intuitive navigation and seamless checkout process.
                </p>

                <div class="flex gap-2 mt-4 text-sm">
                    <span class="px-2 py-1 bg-gray-100 rounded">React</span>
                    <span class="px-2 py-1 bg-gray-100 rounded">NodeJS</span>
                    <span class="px-2 py-1 bg-gray-100 rounded">MongoDB</span>
                </div>
            </div>
        </div>

        {{-- CARD 2 --}}
        <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">
            <img src="https://dummyimage.com/600x350/f1fae4/000&text=FitTracker+Mobile" class="w-full" />
            <div class="p-6">
                <span class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full">Mobile App</span>

                <h3 class="text-xl font-bold mt-3">FitTracker Mobile</h3>

                <p class="text-gray-600 mt-2">
                    Comprehensive fitness tracking app with workout plans and progress monitoring.
                </p>

                <div class="flex gap-2 mt-4 text-sm">
                    <span class="px-2 py-1 bg-gray-100 rounded">React Native</span>
                    <span class="px-2 py-1 bg-gray-100 rounded">Firebase</span>
                    <span class="px-2 py-1 bg-gray-100 rounded">Redux</span>
                </div>
            </div>
        </div>

        {{-- CARD 3 --}}
        <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">
            <img src="https://dummyimage.com/600x350/d9d3c9/000&text=TechFlow+Branding" class="w-full" />
            <div class="p-6">
                <span class="text-sm bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">Branding</span>

                <h3 class="text-xl font-bold mt-3">TechFlow Branding</h3>

                <p class="text-gray-600 mt-2">
                    Complete brand identity for a technology startup including logo, colors, and guidelines.
                </p>

                <div class="flex gap-2 mt-4 text-sm">
                    <span class="px-2 py-1 bg-gray-100 rounded">Illustrator</span>
                    <span class="px-2 py-1 bg-gray-100 rounded">Photoshop</span>
                    <span class="px-2 py-1 bg-gray-100 rounded">Figma</span>
                </div>
            </div>
        </div>

        {{-- CARD 4 --}}
        <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">
            <img src="https://dummyimage.com/600x350/1f2b4d/fff&text=Analytics+Dashboard" class="w-full" />
            <div class="p-6">
                <span class="text-sm bg-purple-100 text-purple-700 px-3 py-1 rounded-full">UI/UX</span>

                <h3 class="text-xl font-bold mt-3">Analytics Dashboard</h3>

                <p class="text-gray-600 mt-2">
                    Comprehensive analytics dashboard with real-time data visualization and insights.
                </p>

                <div class="flex gap-2 mt-4 text-sm">
                    <span class="px-2 py-1 bg-gray-100 rounded">Figma</span>
                    <span class="px-2 py-1 bg-gray-100 rounded">Sketch</span>
                    <span class="px-2 py-1 bg-gray-100 rounded">Principle</span>
                </div>
            </div>
        </div>

        {{-- CARD 5 --}}
        <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">
            <img src="https://dummyimage.com/600x350/f9ebdb/000&text=Restaurant+Web" class="w-full" />
            <div class="p-6">
                <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-full">Web Design</span>

                <h3 class="text-xl font-bold mt-3">Restaurant Website</h3>

                <p class="text-gray-600 mt-2">
                    Elegant restaurant website with menu showcase and online reservation features.
                </p>

                <div class="flex gap-2 mt-4 text-sm">
                    <span class="px-2 py-1 bg-gray-100 rounded">VueJS</span>
                    <span class="px-2 py-1 bg-gray-100 rounded">Nuxt</span>
                    <span class="px-2 py-1 bg-gray-100 rounded">Strapi</span>
                </div>
            </div>
        </div>

        {{-- CARD 6 --}}
        <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">
            <img src="https://dummyimage.com/600x350/cfe9ff/000&text=Social+Connect" class="w-full" />
            <div class="p-6">
                <span class="text-sm bg-orange-100 text-orange-700 px-3 py-1 rounded-full">Mobile App</span>

                <h3 class="text-xl font-bold mt-3">Social Connect</h3>

                <p class="text-gray-600 mt-2">
                    Social networking app with real-time messaging and content sharing features.
                </p>

                <div class="flex gap-2 mt-4 text-sm">
                    <span class="px-2 py-1 bg-gray-100 rounded">Flutter</span>
                    <span class="px-2 py-1 bg-gray-100 rounded">Dart</span>
                    <span class="px-2 py-1 bg-gray-100 rounded">Socket.io</span>
                </div>
            </div>
        </div>

    </div>
</section>


{{-- CTA --}}
<section class="bg-gray-900 py-20 text-center text-white rounded-2xl">
    <h2 class="text-3xl font-bold">Ready to Start Your Project?</h2>
    <p class="mt-3 text-gray-300">
        Let's collaborate and bring your ideas to life with innovative design and development solutions.
    </p>

    <div class="mt-8 flex justify-center gap-4">
        <button class="flex items-center gap-2 bg-blue-600 px-6 py-3 rounded-lg font-semibold">
            ✉️ Get In Touch
        </button>

        <button class="flex items-center gap-2 border border-gray-400 px-6 py-3 rounded-lg font-semibold">
            ⬇️ Download CV
        </button>
    </div>
</section>

@endsection
