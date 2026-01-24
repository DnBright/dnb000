@extends('layouts.main')

@section('content')

@php
    $homePage = \App\Models\Page::where('key','home')->first();
    $c = $homePage ? ($homePage->content ?? []) : [];
@endphp

<main class="relative overflow-hidden">
    
    <!-- Immersive Background Elements -->
    <div class="fixed inset-0 -z-20 bg-[#0b0f14]"></div>
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-brand-cyan/20 blur-[120px] rounded-full animate-blob-float"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-brand-violet/20 blur-[120px] rounded-full animate-blob-float" style="animation-delay: -5s;"></div>
        <div class="absolute top-[30%] right-[10%] w-[30%] h-[30%] bg-brand-accent/10 blur-[100px] rounded-full animate-blob-float" style="animation-delay: -10s;"></div>
    </div>

    <!-- HERO SECTION -->
    <section class="relative min-h-[90vh] flex items-center pt-20 pb-12 overflow-hidden">
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="reveal">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-brand-cyan text-xs font-bold tracking-widest uppercase mb-6 shadow-xl">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-cyan opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-cyan"></span>
                        </span>
                        {{ __('Premium Design Studio') }}
                    </div>
                    
                    <h1 class="text-5xl md:text-7xl font-extrabold leading-[1.1] mb-8 text-white">
                        {{ $c['hero_title'] ?? __('The Future of Digital') }}
                        <span class="block animate-text-shimmer">{{ __('Aesthetics') }}.</span>
                    </h1>
                    
                    <p class="text-xl text-slate-400 leading-relaxed mb-10 max-w-xl">
                        {{ $c['hero_subtitle'] ?? __('We craft premium digital experiences using deep dark canvases and selective bright accents for high-impact visual storytelling.') }}
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-5">
                        <a href="{{ $c['cta1_link'] ?? '#' }}" class="btn-primary text-center">
                            {{ $c['cta1_label'] ?? __('Start Project') }}
                        </a>
                        <a href="{{ $c['cta2_link'] ?? '#' }}" class="btn-secondary text-center">
                            {{ $c['cta2_label'] ?? __('View Templates') }}
                        </a>
                    </div>
                    
                    <div class="mt-12 flex items-center gap-8 grayscale opacity-50">
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold text-white">{{ $c['projects_count'] ?? '250+' }}</span>
                            <span class="text-xs text-slate-500 uppercase tracking-tighter">{{ __('Done Projects') }}</span>
                        </div>
                        <div class="w-px h-10 bg-white/10"></div>
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold text-white">{{ $c['designers_count'] ?? '10+' }}</span>
                            <span class="text-xs text-slate-500 uppercase tracking-tighter">{{ __('Top Talent') }}</span>
                        </div>
                        <div class="w-px h-10 bg-white/10"></div>
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold text-white">{{ $c['satisfaction_percent'] ?? '99%' }}</span>
                            <span class="text-xs text-slate-500 uppercase tracking-tighter">{{ __('Satisfaction') }}</span>
                        </div>
                    </div>
                </div>

                <div class="relative reveal" style="transition-delay: 200ms;">
                    <!-- Floating Design Elements -->
                    <div class="absolute -top-10 -left-10 w-32 h-32 bg-brand-cyan/30 blur-2xl rounded-full"></div>
                    <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-brand-violet/30 blur-2xl rounded-full"></div>
                    
                    <div class="glass-card p-2 relative z-20 overflow-hidden transform hover:scale-[1.02] transition-transform duration-500 shadow-2xl group">
                        <img src="{{ $c['hero_image'] ?? 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80' }}" 
                             alt="Showcase" 
                             class="rounded-2xl w-full h-[500px] object-cover transition-transform duration-700 group-hover:scale-105">
                        
                        <div class="absolute inset-x-8 bottom-8 p-6 glass-card border-white/20 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                             <div class="flex justify-between items-end">
                                 <div>
                                     <p class="text-xs text-brand-cyan font-bold uppercase tracking-wider mb-1">{{ __('Featured Project') }}</p>
                                     <h3 class="text-lg font-bold text-white uppercase">Vanguard Brand System</h3>
                                 </div>
                                 <div class="text-white">
                                     <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                     </svg>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES SECTION -->
    <section id="services" class="py-24 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20 reveal">
                <p class="text-brand-cyan font-bold uppercase tracking-widest text-sm mb-3">{{ __('Expertise') }}</p>
                <h2 class="text-4xl md:text-5xl font-extrabold text-white">{{ __('Our Signature Services') }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $services = $c['services'] ?? [
                        ['title'=>'Creative Identity','subtitle'=>'Bold logos and cohesive brand systems.','image'=>'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&w=800&q=80'],
                        ['title'=>'Digital Product','subtitle'=>'High-fidelity UI components and UX patterns.','image'=>'https://images.unsplash.com/photo-1581291518655-9503cc262f99?auto=format&fit=crop&w=800&q=80'],
                        ['title'=>'Visual Story','subtitle'=>'Art direction and multi-platform visuals.','image'=>'https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&w=800&q=80'],
                    ];
                @endphp

                @foreach($services as $index => $svc)
                    <article class="reveal group h-full" style="transition-delay: {{ $index * 150 }}ms;">
                        <div class="glass-card p-4 h-full flex flex-col hover:border-brand-cyan/30 transition-colors duration-500">
                            <div class="relative rounded-2xl overflow-hidden mb-6 aspect-video">
                                <img src="{{ $svc['image'] ?? 'https://dummyimage.com/800x500/081222/00e5ff&text=Service' }}" 
                                     alt="{{ $svc['title'] ?? '' }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-brand-charcoal to-transparent opacity-60"></div>
                            </div>
                            
                            <div class="px-2 pb-2 flex-grow flex flex-col">
                                <h3 class="text-xl font-bold text-white mb-3 group-hover:text-brand-cyan transition-colors">{{ $svc['title'] ?? '' }}</h3>
                                <p class="text-slate-400 text-sm leading-relaxed mb-6 flex-grow">{{ $svc['subtitle'] ?? '' }}</p>
                                
                                <div class="flex items-center justify-between mt-auto">
                                    <button type="button" 
                                            class="text-xs font-bold uppercase tracking-widest text-slate-300 hover:text-brand-cyan transition-colors learn-more"
                                            data-title="{{ e($svc['title'] ?? '') }}" 
                                            data-desc="{{ e($svc['description'] ?? $svc['subtitle'] ?? 'No description available.') }}">
                                        {{ __('Read Deeply') }}
                                    </button>
                                    <div class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center text-white group-hover:bg-brand-cyan group-hover:text-black group-hover:border-brand-cyan transition-all duration-300">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- TEMPLATES SECTION -->
    <section id="templates" class="py-24 bg-white/[0.02]">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6 reveal">
                <div>
                    <p class="text-brand-violet font-bold uppercase tracking-widest text-sm mb-3">{{ __('Marketplace') }}</p>
                    <h2 class="text-4xl font-extrabold text-white">{{ __('Elite Templates') }}</h2>
                </div>
                <a href="#" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 font-semibold">
                    {{ __('Explore Marketplace') }}
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @php 
                    $templates = $c['templates'] ?? [
                        ['name'=>'Eclipse Portfolio','price'=>'Rp 125K','image'=>'https://images.unsplash.com/photo-1541462608141-67574a6c45ad?auto=format&fit=crop&w=600&q=80'],
                        ['name'=>'Void UI Kit','price'=>'Free','image'=>'https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&w=600&q=80'],
                        ['name'=>'Prism Keynote','price'=>'Rp 95K','image'=>'https://images.unsplash.com/photo-1505330622279-bf7d7fc918f4?auto=format&fit=crop&w=600&q=80'],
                        ['name'=>'Aura Branding','price'=>'Rp 150K','image'=>'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=600&q=80'],
                    ]; 
                @endphp

                @foreach ($templates as $index => $t)
                    <div class="reveal reveal-card" style="transition-delay: {{ $index * 100 }}ms;">
                        <div class="glass-card overflow-hidden group">
                            <div class="relative h-56 overflow-hidden">
                                <img src="{{ $t['image'] }}" alt="{{ $t['name'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute top-4 right-4 px-3 py-1 glass-card border-white/20 text-xs font-bold text-white">
                                    {{ $t['price'] }}
                                </div>
                            </div>
                            <div class="p-6">
                                <h4 class="font-bold text-white text-lg mb-4">{{ $t['name'] }}</h4>
                                <a href="{{ $t['link'] ?? '#' }}" class="w-full block py-3 rounded-xl border border-white/10 text-center text-sm font-bold uppercase tracking-widest text-white hover:bg-brand-violet hover:border-brand-violet transition-all duration-300">
                                    {{ __('Get Access') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- DESIGNERS SECTION -->
    <section class="py-24">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20 reveal">
                <p class="text-brand-cyan font-bold uppercase tracking-widest text-sm mb-3">{{ __('Talent Pool') }}</p>
                <h2 class="text-4xl font-extrabold text-white">{{ __('Elite Visionaries') }}</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                @php
                    $designers = $c['top_designers'] ?? [
                        ['name'=>'Xavier Thorne','role'=>'Brand Architect','image'=>'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80','rating'=>5.0],
                        ['name'=>'Luna Sterling','role'=>'UX Envisionist','image'=>'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=400&q=80','rating'=>4.9],
                        ['name'=>'Aiden VANCE','role'=>'Motion Sorcerer','image'=>'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80','rating'=>4.9],
                        ['name'=>'Sienna Night','role'=>'Visual Strategist','image'=>'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=400&q=80','rating'=>4.8],
                    ];
                @endphp

                @foreach($designers as $index => $d)
                    <div class="reveal text-center group" style="transition-delay: {{ $index * 150 }}ms;">
                        <div class="relative inline-block mb-6">
                            <div class="absolute inset-0 bg-gradient-to-br from-brand-cyan to-brand-violet rounded-full blur-xl opacity-0 group-hover:opacity-40 transition-opacity duration-500"></div>
                            <img src="{{ $d['image'] ?? 'https://randomuser.me/api/portraits/lego/1.jpg' }}" 
                                 class="relative w-32 h-32 rounded-full object-cover border-2 border-white/10 group-hover:border-brand-cyan transition-colors duration-500">
                        </div>
                        <h3 class="text-xl font-bold text-white mb-1">{{ $d['name'] ?? '' }}</h3>
                        <p class="text-brand-cyan/80 text-sm font-medium mb-4 uppercase tracking-tighter">{{ $d['role'] ?? '' }}</p>
                        
                        <div class="flex items-center justify-center gap-1 text-yellow-500 mb-6">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endfor
                        </div>
                        
                        <button type="button"
                            class="px-6 py-2 rounded-full border border-white/10 text-xs font-bold uppercase tracking-widest text-slate-300 hover:bg-white/5 hover:text-white transition-all designer-profile-btn"
                            data-name="{{ e($d['name'] ?? '') }}"
                            data-role="{{ e($d['role'] ?? '') }}"
                            data-desc="{{ e($d['description'] ?? 'An expert in creating immersive digital experiences with over 8 years of industry leadership.') }}"
                            data-img="{{ e($d['image'] ?? '') }}"
                            data-link="{{ e($d['link'] ?? '#') }}"
                        >{{ __('View Journey') }}</button>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS SECTION -->
    <section class="py-24 bg-brand-violet/5 relative overflow-hidden">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-extrabold text-white text-center mb-16 reveal">{{ __('Voices of Impact') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $reviews = $c['reviews'] ?? [
                        ['message'=>'The level of craftsmanship and attention to detail is simply unparalleled in the current market.','author'=>'Regina Falangi','company'=>'CEO, Techflow'],
                        ['message'=>'Dark & Bright revitalized our entire product ecosystem. The design language is consistent and powerful.','author'=>'Marco Verratti','company'=>'Product Lead, Nexus'],
                        ['message'=>'Clean, bold, and effective. They don\'t just design, they solve complex visual problems.','author'=>'Elena Gilbert','company'=>'Founder, Mystic Design'],
                    ];
                @endphp

                @foreach ($reviews as $index => $testi)
                    <div class="reveal glass-card p-8 flex flex-col justify-between" style="transition-delay: {{ $index * 200 }}ms;">
                        <div class="mb-8">
                            <svg class="w-10 h-10 text-brand-cyan/20 mb-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017V14H17.017C15.3601 14 14.017 12.6569 14.017 11V8H20.017V14H22.017V21H14.017ZM2.01697 21L2.01697 18C2.01697 16.8954 2.9124 16 4.01697 16H7.01697V14H5.01697C3.36012 14 2.01697 12.6569 2.01697 11V8H8.01697V14H10.017V21H2.01697Z"/>
                            </svg>
                            <p class="text-slate-300 italic leading-relaxed">{{ $testi['message'] }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-cyan to-brand-violet flex items-center justify-center text-black font-bold text-xs">
                                {{ substr($testi['author'], 0, 2) }}
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-sm">{{ $testi['author'] }}</h4>
                                <p class="text-slate-500 text-xs uppercase tracking-wider">{{ $testi['company'] ?? 'Director' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FINAL CTA SECTION -->
    <section id="contact" class="py-32 relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
        <div class="container mx-auto px-6 text-center relative z-10 reveal">
            <h2 class="text-5xl md:text-7xl font-extrabold text-white mb-8">{{ __('Ready to Transcend?') }}</h2>
            <p class="text-xl text-slate-400 mt-3 max-w-2xl mx-auto mb-12">
                {{ __('Join the league of industry leaders who prioritize clarity, contrast, and premium digital presence.') }}
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="#" class="btn-primary">{{ __('Ignite Project') }}</a>
                <a href="#" class="btn-secondary">{{ __('Talk to Design Lead') }}</a>
            </div>
        </div>
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-4xl aspect-square bg-brand-cyan/10 blur-[150px] rounded-full -z-10 animate-pulse"></div>
    </section>

</main>

<!-- SERVICE MODAL -->
<div id="svc-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6">
    <div data-modal-backdrop class="absolute inset-0 bg-black/80 backdrop-blur-md"></div>
    <div role="dialog" aria-modal="true" class="relative max-w-2xl w-full glass-card p-10 ring-1 ring-white/20">
        <button type="button" data-modal-close class="absolute right-6 top-6 text-slate-400 hover:text-white transition-colors">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div class="mb-4">
            <span class="text-brand-cyan font-bold uppercase tracking-[0.2em] text-xs">{{ __('Innovation Deep Dive') }}</span>
        </div>
        <h3 id="svc-modal-title" class="text-3xl font-extrabold text-white mb-6"></h3>
        <p id="svc-modal-desc" class="text-lg text-slate-400 leading-relaxed"></p>
        <div class="mt-10">
            <button data-modal-close class="btn-primary w-full sm:w-auto">{{ __('Acknowledge') }}</button>
        </div>
    </div>
</div>

<!-- DESIGNER MODAL -->
<div id="designer-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6">
    <div data-modal-backdrop class="absolute inset-0 bg-black/80 backdrop-blur-md"></div>
    <div role="dialog" aria-modal="true" class="relative max-w-3xl w-full glass-card overflow-hidden ring-1 ring-white/20">
        <button type="button" data-designer-modal-close class="absolute right-6 top-6 text-slate-400 hover:text-white z-20">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div class="flex flex-col md:flex-row h-full">
            <div class="md:w-2/5 relative h-64 md:h-auto">
                <img id="designer-modal-img" src="" alt="" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-brand-charcoal md:bg-gradient-to-l via-transparent to-transparent"></div>
            </div>
            <div class="md:w-3/5 p-10 relative">
                <div class="mb-2">
                    <span id="designer-modal-role" class="text-brand-violet font-bold uppercase tracking-widest text-xs"></span>
                </div>
                <h3 id="designer-modal-title" class="text-4xl font-extrabold text-white mb-6"></h3>
                <p id="designer-modal-desc" class="text-lg text-slate-400 leading-relaxed mb-10"></p>
                <div class="flex flex-wrap gap-4">
                    <a id="designer-modal-link" href="#" class="btn-primary flex-grow text-center">{{ __('Contact Designer') }}</a>
                    <button data-designer-modal-close class="btn-secondary px-6">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Scroll Reveal Intersection Observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                // Optional: stop observing once it's revealed
                // observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // Modal Logic
    const initModal = (modalId, closeAttr, openSelector, mapFn) => {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        const backdrop = modal.querySelector('[data-modal-backdrop]');
        const closeBtns = modal.querySelectorAll(`[${closeAttr}]`);
        
        const open = (data) => {
            mapFn(data, modal);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            setTimeout(() => modal.querySelector('div[role="dialog"]').classList.add('active'), 10);
        };

        const close = () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        };

        document.querySelectorAll(openSelector).forEach(btn => {
            btn.addEventListener('click', (e) => open(e.currentTarget));
        });

        backdrop?.addEventListener('click', close);
        closeBtns.forEach(b => b.addEventListener('click', close));
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });
    };

    // Initialize Service Modal
    initModal('svc-modal', 'data-modal-close', '.learn-more', (btn, modal) => {
        modal.querySelector('#svc-modal-title').textContent = btn.getAttribute('data-title');
        modal.querySelector('#svc-modal-desc').textContent = btn.getAttribute('data-desc');
    });

    // Initialize Designer Modal
    initModal('designer-modal', 'data-designer-modal-close', '.designer-profile-btn', (btn, modal) => {
        modal.querySelector('#designer-modal-title').textContent = btn.getAttribute('data-name');
        modal.querySelector('#designer-modal-role').textContent = btn.getAttribute('data-role');
        modal.querySelector('#designer-modal-desc').textContent = btn.getAttribute('data-desc');
        modal.querySelector('#designer-modal-img').src = btn.getAttribute('data-img');
        const link = modal.querySelector('#designer-modal-link');
        link.href = btn.getAttribute('data-link');
    });
});
</script>

@endsection
