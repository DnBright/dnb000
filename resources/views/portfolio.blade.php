@extends('layouts.main')
@section('content')

<main class="relative min-h-screen overflow-hidden">
    <!-- Immersive Background Elements -->
    <div class="fixed inset-0 -z-20 bg-[#0b0f14]"></div>
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-brand-cyan/15 blur-[120px] rounded-full animate-blob-float"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-brand-violet/15 blur-[120px] rounded-full animate-blob-float" style="animation-delay: -7s;"></div>
    </div>

    {{-- HERO --}}
    <section class="relative pt-32 pb-20 px-6">
        <div class="container mx-auto px-6 relative z-10">
            <!-- ORDERING GUIDE -->
            <x-ordering-guide activeStep="1" class="mb-16" />

            <div class="max-w-4xl mx-auto text-center reveal">
            <div class="inline-flex px-4 py-1.5 rounded-full bg-brand-cyan/10 border border-brand-cyan/20 text-brand-cyan text-[10px] font-bold uppercase tracking-[0.3em] mb-8">
                {{ __('Visual Showcase') }}
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-white leading-tight mb-8">
                {{ __('The Creative') }} <br>
                <span class="animate-text-shimmer">{{ __('Gallery Archive.') }}</span>
            </h1>
            <p class="text-slate-400 text-lg md:text-xl leading-relaxed max-w-2xl mx-auto mb-12">
                {{ __('Explore our curated collection of digital excellence. Each project is a fusion of innovation, clarity, and premium craftsmanship.') }}
            </p>

            {{-- FILTER --}}
            <div id="portfolioFilters" class="flex justify-center gap-3 mt-8 flex-wrap">
                <button data-filter="all" class="filter-btn px-6 py-2.5 rounded-xl bg-brand-cyan text-[#0b0f14] font-bold shadow-lg shadow-brand-cyan/20 transition-all">{{ __('All Objects') }}</button>
                <button data-filter="logo" class="filter-btn px-6 py-2.5 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-bold hover:bg-white/10 transition-all">{{ __('Logo') }}</button>
                <button data-filter="stationery" class="filter-btn px-6 py-2.5 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-bold hover:bg-white/10 transition-all">{{ __('Stationery') }}</button>
                <button data-filter="website" class="filter-btn px-6 py-2.5 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-bold hover:bg-white/10 transition-all">{{ __('Web Ops') }}</button>
                <button data-filter="kemasan" class="filter-btn px-6 py-2.5 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-bold hover:bg-white/10 transition-all">{{ __('Packaging') }}</button>
                <button data-filter="feeds" class="filter-btn px-6 py-2.5 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-bold hover:bg-white/10 transition-all">{{ __('Social Social') }}</button>
                <button data-filter="lainnya" class="filter-btn px-6 py-2.5 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-bold hover:bg-white/10 transition-all">{{ __('Other Bits') }}</button>
            </div>
        </div>
    </section>

    @php
        $portfolioPage = \App\Models\Page::where('key','portfolio')->first();
        $content = $portfolioPage->content ?? [];
        $logos = $content['logo'] ?? [];
        $stationery = $content['stationery'] ?? [];
        $websites = $content['website'] ?? [];
        $pack = $content['packaging'] ?? [];
        $feeds = $content['feeds'] ?? [];
        $others = $content['other'] ?? [];
        $items = [];
        foreach ($logos as $i) { $i['__category']='logo'; $items[]=$i; }
        foreach ($stationery as $i) { $i['__category']='stationery'; $items[]=$i; }
        foreach ($websites as $i) { $i['__category']='website'; $items[]=$i; }
        foreach ($pack as $i) { $i['__category']='kemasan'; $items[]=$i; }
        foreach ($feeds as $i) { $i['__category']='feeds'; $items[]=$i; }
        foreach ($others as $i) { $i['__category']='lainnya'; $items[]=$i; }
    @endphp

    <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div id="portfolioGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($items as $it)
                    @php
                        $img = $it['image'] ?? null;
                        $title = $it['title'] ?? ($it['name'] ?? 'Untitled');
                        $caption = $it['caption'] ?? '';
                        $desc = $it['description'] ?? '';
                        $link = $it['link'] ?? '';
                        $cat = $it['__category'] ?? 'lainnya';
                    @endphp
                    <article class="reveal group relative flex flex-col h-full ring-1 ring-white/10 bg-white/[0.02] backdrop-blur-md rounded-[2.5rem] overflow-hidden hover:ring-brand-cyan/50 hover:bg-white/[0.04] transition-all duration-500 shadow-2xl">
                        
                        {{-- Image Container --}}
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="{{ $img ?? 'https://dummyimage.com/900x600/ddd/000&text=Project' }}" 
                                alt="{{ $title }}" 
                                class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            {{-- Category Badge --}}
                            <div class="absolute left-6 top-6">
                                <span class="px-3 py-1 rounded-full bg-[#0b0f14]/80 backdrop-blur-md border border-white/10 text-[10px] text-white font-bold uppercase tracking-widest">{{ __($cat) }}</span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-8 flex flex-col flex-grow">
                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                <p class="text-slate-400 text-sm line-clamp-2 leading-relaxed">{{ $caption }}</p>
                            </div>
                            
                            <div class="mt-auto flex items-center justify-between">
                                <button class="view-project-btn group/btn flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-brand-cyan hover:text-white transition-colors" 
                                    data-title="{{ $title }}" data-caption="{{ $caption }}" data-desc="{{ $desc }}" data-image="{{ $img }}" data-link="{{ $link }}">
                                    <span>{{ __('Detailed View') }}</span>
                                    <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </button>
                                <span class="text-[10px] font-bold text-slate-600 tracking-widest">{{ $it['year'] ?? '' }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- FOOTER CTA --}}
            <div class="mt-32 reveal">
                <div class="glass-card p-12 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-12 group">
                    <div class="absolute inset-0 bg-gradient-to-r from-brand-cyan/20 to-brand-violet/20 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    
                    <div class="relative z-10 text-center md:text-left max-w-xl">
                        <h3 class="text-3xl font-black text-white mb-4">{{ __('Forge Your Legacy?') }}</h3>
                        <p class="text-slate-400 text-lg leading-relaxed">
                            {{ __('Every masterpiece begins with a single bold vision. Connect with us and let\'s craft something that defies the ordinary.') }}
                        </p>
                    </div>
                    
                    <div class="relative z-10 flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                        <a href="/paket" class="btn-primary text-center">{{ __('Protocol Packages') }}</a>
                        <a href="https://wa.me/6281234567890" target="_blank" class="btn-secondary text-center">{{ __('Secure Channel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MODAL --}}
    <div id="project-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6 transition-all duration-300 opacity-0">
        <div class="absolute inset-0 bg-[#0b0f14]/90 backdrop-blur-xl"></div>
        
        <div class="relative glass-card max-w-6xl w-full max-h-[90vh] overflow-y-auto shadow-[0_0_50px_rgba(0,0,0,0.5)] transform scale-95 transition-all duration-500">
            <div class="sticky top-0 z-20 flex items-center justify-between p-8 bg-white/[0.02] backdrop-blur-xl border-b border-white/5">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-brand-cyan/10 flex items-center justify-center text-brand-cyan">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 id="project-modal-title" class="text-2xl font-black text-white"></h3>
                        <p id="project-modal-caption" class="text-xs font-bold text-brand-cyan uppercase tracking-[0.2em] mt-1"></p>
                    </div>
                </div>
                <button id="project-modal-close" class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 text-white flex items-center justify-center hover:bg-red-500/20 hover:border-red-500/30 hover:text-red-400 transition-all">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="p-8 lg:p-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                    <div class="lg:col-span-7">
                        <div class="relative rounded-[2rem] overflow-hidden border border-white/10 shadow-2xl group">
                            <img id="project-modal-img" src="" class="w-full h-auto object-cover" alt="">
                            <div class="absolute inset-0 ring-1 ring-inset ring-white/10 pointer-events-none"></div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 flex flex-col space-y-10">
                        <div class="space-y-6">
                            <div class="inline-flex px-3 py-1 rounded-full bg-white/5 border border-white/10 text-[10px] text-slate-500 font-bold uppercase tracking-widest">{{ __('Project brief') }}</div>
                            <div id="project-modal-desc" class="text-slate-300 text-lg leading-relaxed font-light space-y-4"></div>
                        </div>

                        <div id="project-modal-link-wrap" class="pt-10 border-t border-white/5">
                            <a id="project-modal-link" href="#" target="_blank" class="btn-primary w-full flex items-center justify-center gap-3">
                                <span>{{ __('External Protocol') }}</span>
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
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

    // Filters
    const filterBtns = document.querySelectorAll('#portfolioFilters .filter-btn');
    const cards = document.querySelectorAll('#portfolioGrid article');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;

            // Reset buttons
            filterBtns.forEach(b => {
                b.classList.remove('bg-brand-cyan', 'text-[#0b0f14]', 'shadow-brand-cyan/20');
                b.classList.add('bg-white/5', 'border-white/10', 'text-slate-300');
            });

            // Activate button
            this.classList.add('bg-brand-cyan', 'text-[#0b0f14]', 'shadow-brand-cyan/20');
            this.classList.remove('bg-white/5', 'border-white/10', 'text-slate-300');

            // Filter cards
            cards.forEach(card => {
                const category = card.querySelector('span').textContent.toLowerCase();
                if (filter === 'all' || category.includes(filter)) {
                    card.style.display = 'flex';
                    setTimeout(() => card.style.opacity = '1', 10);
                } else {
                    card.style.opacity = '0';
                    setTimeout(() => card.style.display = 'none', 300);
                }
            });
        });
    });

    // Modal Logic
    const modal = document.getElementById('project-modal');
    const modalContent = modal.querySelector('.glass-card');
    const closeBtn = document.getElementById('project-modal-close');
    const titleEl = document.getElementById('project-modal-title');
    const imgEl = document.getElementById('project-modal-img');
    const captionEl = document.getElementById('project-modal-caption');
    const descEl = document.getElementById('project-modal-desc');
    const linkWrap = document.getElementById('project-modal-link-wrap');
    const linkEl = document.getElementById('project-modal-link');

    function openModal(data) {
        titleEl.textContent = data.title || 'Project';
        captionEl.textContent = data.caption || '';
        descEl.innerHTML = data.desc || '<p>{{ __('No description provided for this protocol.') }}</p>';
        imgEl.src = data.image || 'https://dummyimage.com/1200x800/ddd/000&text=Project';
        
        if (data.link && data.link !== '') {
            linkWrap.style.display = 'block';
            linkEl.href = data.link;
        } else {
            linkWrap.style.display = 'none';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
            document.body.style.overflow = 'hidden';
        }, 10);
    }

    function closeModal() {
        modal.classList.remove('opacity-100');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }

    document.querySelectorAll('.view-project-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            openModal({
                title: this.dataset.title,
                caption: this.dataset.caption,
                desc: this.dataset.desc,
                image: this.dataset.image,
                link: this.dataset.link
            });
        });
    });

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
});
</script>
@endpush

@endsection
