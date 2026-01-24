@extends('layouts.main')

@section('content')

<main class="relative min-h-screen overflow-hidden">
    <!-- Immersive Background Elements -->
    <div class="fixed inset-0 -z-20 bg-[#0b0f14]"></div>
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute top-[-20%] left-[-10%] w-[60%] h-[60%] bg-brand-cyan/20 blur-[150px] rounded-full animate-blob-float"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[60%] h-[60%] bg-brand-violet/20 blur-[150px] rounded-full animate-blob-float" style="animation-delay: -5s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-32">
        <!-- ORDERING GUIDE -->
        <x-ordering-guide activeStep="1" class="mb-16" />
        @php
            $page = \App\Models\Page::where('key','layanan')->first();
            $content = $page->content ?? [];
            $heroTitle = $content['hero_title'] ?? 'Layanan Desain Profesional';
            $heroSubtitle = $content['hero_subtitle'] ?? 'Kami membantu brand Anda tampil menonjol — dari kemasan, konten feed, hingga desain custom. Pilih layanan, konsultasi, dan terima hasil yang siap pakai.';
            $cta1Label = $content['cta1_label'] ?? 'Lihat Layanan';
            $cta1Link = $content['cta1_link'] ?? '#services';
            $cta2Label = $content['cta2_label'] ?? 'Konsultasi';
            $cta2Link = $content['cta2_link'] ?? 'https://wa.me/6281234567890?text=Halo%20saya%20ingin%20konsultasi';
            $heroImage = $content['hero_image'] ?? null;
            $services = $content['services'] ?? null;
        @endphp

        {{-- HERO SECTION --}}
        <section class="reveal mb-24">
            <div class="glass-card relative overflow-hidden p-12 lg:p-20 shadow-2xl ring-1 ring-white/10">
                <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-brand-cyan/10 to-transparent pointer-events-none"></div>
                
                <div class="flex flex-col md:flex-row items-center justify-between gap-16 relative z-10">
                    <div class="md:w-7/12">
                        <div class="inline-flex px-4 py-1.5 rounded-full bg-brand-cyan/10 border border-brand-cyan/20 text-brand-cyan text-[10px] font-bold uppercase tracking-[0.3em] mb-8">
                            {{ __('Premium Protocol') }}
                        </div>
                        <h1 class="text-5xl md:text-6xl font-black text-white leading-tight mb-8">
                            {{ $heroTitle }} <br>
                            <span class="animate-text-shimmer">{{ __('Optimized.') }}</span>
                        </h1>
                        <p class="text-slate-400 text-lg leading-relaxed max-w-xl mb-12">
                            {{ $heroSubtitle }}
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ $cta1Link }}" class="btn-primary text-center px-10">{{ $cta1Label }}</a>
                            <a target="_blank" rel="noopener" href="{{ $cta2Link }}" class="btn-secondary text-center px-10">{{ $cta2Label }}</a>
                        </div>
                    </div>
                    
                    <div class="md:w-5/12">
                        <div class="relative group">
                            <div class="absolute inset-0 bg-brand-cyan/20 blur-3xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                            @if($heroImage)
                                <img src="{{ $heroImage }}" alt="hero" class="relative z-10 rounded-3xl shadow-2xl ring-1 ring-white/10 grayscale-[0.2] group-hover:grayscale-0 transition-all duration-500 w-full h-[400px] object-cover">
                            @else
                                <div class="relative z-10 w-full h-[400px] rounded-3xl bg-white/5 border border-white/10 flex items-center justify-center overflow-hidden">
                                     <div class="absolute inset-0 bg-gradient-to-br from-brand-charcoal via-brand-navy to-brand-charcoal opacity-50"></div>
                                     <span class="relative text-6xl opacity-20">💎</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @php
            $defaults = [
                ['title'=>'Logo Design','subtitle'=>'Membuat logo profesional sesuai brand Anda','image'=>'https://images.unsplash.com/photo-1572044162444-ad60f128bde2?q=80&w=800','paket'=>'logo-design'],
                ['title'=>'Desain Stationery','subtitle'=>'Kartu nama, kop surat, amplop dan kebutuhan kantor lainnya','image'=>'https://images.unsplash.com/photo-1586717791821-3f44a563eb4c?q=80&w=800','paket'=>'desain-stationery'],
                ['title'=>'Website Design','subtitle'=>'Desain UI/UX untuk website responsif dan modern','image'=>'https://images.unsplash.com/photo-1581291518137-903383a699a8?q=80&w=800','paket'=>'website-design'],
                ['title'=>'Kemasan Design','subtitle'=>'Desain kemasan produk yang menarik dan fungsional','image'=>'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?q=80&w=800','paket'=>'kemasan-design'],
                ['title'=>'Feed Design','subtitle'=>'Desain konten feed Instagram dan sosial media','image'=>'https://images.unsplash.com/photo-1611162617474-5b21e879e113?q=80&w=800','paket'=>'feed-design'],
                ['title'=>'Design Lainnya','subtitle'=>'Konsultasi dan desain custom — sebutkan kebutuhan Anda','image'=>'https://images.unsplash.com/photo-1542744094-3a56cf9e46a2?q=80&w=800','paket'=>'design-lainnya'],
            ];
            $services = $content['services'] ?? $defaults;
        @endphp

        {{-- PRICING GRID --}}
        <section id="services" class="space-y-12">
            <div class="text-center reveal">
                <h2 class="text-4xl font-black text-white mb-4">{{ __('Elite Packages') }}</h2>
                <p class="text-slate-500 text-lg uppercase tracking-widest font-bold">{{ __('Scalable Creative Solutions') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach(($services ?? $defaults) as $svc)
                    @php
                        $paket = !empty($svc['paket']) ? $svc['paket'] : \Illuminate\Support\Str::slug($svc['title'] ?? 'standard');
                        $prices = config('midtrans.paket_prices', []);
                        $price = null;
                        if (!empty($svc['paket']) && isset($prices[$svc['paket']])) $price = $prices[$svc['paket']];
                        if (is_null($price)) {
                            $slug = \Illuminate\Support\Str::slug($svc['title'] ?? $paket);
                            if (isset($prices[$slug])) $price = $prices[$slug];
                        }
                        if (is_null($price) && isset($prices[$paket])) $price = $prices[$paket];
                        if (is_null($price)) {
                            $title = strtolower($svc['title'] ?? '');
                            if (str_contains($title, 'kemasan') || str_contains($paket, 'kemasan')) $price = 2500000;
                            elseif (str_contains($title, 'feed') || str_contains($paket, 'feed')) $price = 500000;
                            elseif (str_contains($title, 'website') || str_contains($paket, 'website')) $price = 8000000;
                            elseif (str_contains($title, 'logo')) $price = 4000000;
                            else $price = 750000;
                        }
                    @endphp

                    <article class="reveal group h-full glass-card p-8 hover:bg-white/[0.05] transition-all duration-500 shadow-xl flex flex-col">
                        <div class="relative overflow-hidden rounded-2xl mb-8 aspect-video">
                            <img src="{{ $svc['image'] ?? '' }}" alt="{{ $svc['title'] ?? '' }}" class="w-full h-full object-cover grayscale-[0.3] group-hover:grayscale-0 group-hover:scale-110 transition-all duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            
                            @if($price)
                                <div class="absolute bottom-4 right-4">
                                    <div class="bg-brand-cyan/90 backdrop-blur-md text-[#0b0f14] px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest shadow-lg">
                                        Rp {{ number_format($price,0,',','.') }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="flex-grow">
                            <h3 class="text-2xl font-black text-white mb-3">{{ $svc['title'] ?? '' }}</h3>
                            <p class="text-slate-400 text-sm leading-relaxed mb-6">{{ $svc['subtitle'] ?? '' }}</p>
                            
                            <ul class="space-y-3 mb-10">
                                <li class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">
                                    <span class="text-brand-cyan">✓</span> {{ __('Unlimited Revisions') }}
                                </li>
                                <li class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">
                                    <span class="text-brand-cyan">✓</span> {{ __('Source Protocol Files') }}
                                </li>
                                <li class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">
                                    <span class="text-brand-cyan">✓</span> {{ __('Priority Response') }}
                                </li>
                            </ul>
                        </div>

                        <div class="mt-auto space-y-4">
                            <a href="{{ route('brief.show', ['paket' => $paket]) }}" onclick="return chooseService(event)" class="btn-primary w-full text-center">{{ __('Select Protocol') }}</a>
                            <a href="#" class="block text-center text-[10px] font-bold uppercase tracking-[0.3em] text-slate-600 hover:text-brand-cyan transition-colors">{{ __('Manifest Detail') }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        {{-- PROCESS SECTION --}}
        <section class="mt-32">
            <div class="glass-card p-12 lg:p-20 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-cyan via-brand-violet to-brand-cyan"></div>
                
                <h2 class="text-4xl font-black text-white mb-16 text-center reveal">{{ __('Order Workflow —') }} <span class="text-brand-cyan">{{ __('Synchronized') }}</span></h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                    <div class="reveal relative text-center group" style="transition-delay: 0.1s;">
                        <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-2xl font-black text-brand-cyan mx-auto mb-8 group-hover:bg-brand-cyan/10 group-hover:border-brand-cyan/30 transition-all">1</div>
                        <h4 class="text-xl font-bold text-white mb-2">{{ __('Pilih Paket') }}</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">{{ __('Pilih layanan sesuai kebutuhan strategis Anda.') }}</p>
                    </div>
                    
                    <div class="reveal relative text-center group" style="transition-delay: 0.2s;">
                        <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-2xl font-black text-brand-cyan mx-auto mb-8 group-hover:bg-brand-cyan/10 group-hover:border-brand-cyan/30 transition-all">2</div>
                        <h4 class="text-xl font-bold text-white mb-2">{{ __('Isi Brief') }}</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">{{ __('Kirimkan koordinat dan referensi kreatif Anda.') }}</p>
                    </div>

                    <div class="reveal relative text-center group" style="transition-delay: 0.3s;">
                        <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-2xl font-black text-brand-cyan mx-auto mb-8 group-hover:bg-brand-cyan/10 group-hover:border-brand-cyan/30 transition-all">3</div>
                        <h4 class="text-xl font-bold text-white mb-2">{{ __('Proses & Revisi') }}</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">{{ __('Iterasi berkelanjutan hingga harmoni tercapai.') }}</p>
                    </div>

                    <div class="reveal relative text-center group" style="transition-delay: 0.4s;">
                        <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-2xl font-black text-brand-cyan mx-auto mb-8 group-hover:bg-brand-cyan/10 group-hover:border-brand-cyan/30 transition-all">4</div>
                        <h4 class="text-xl font-bold text-white mb-2">{{ __('Terima File') }}</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">{{ __('File final dikirim melalui enkripsi digital.') }}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Reveal Observer
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });
    reveals.forEach(r => observer.observe(r));
});
</script>

@endsection
