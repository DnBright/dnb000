@extends('admin.layout')

@section('content')
<div class="reveal active space-y-10">
    {{-- TOP NAVIGATION --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight uppercase leading-none">Dashboard <span class="animate-text-shimmer">Inquiry</span></h2>
            <div class="flex items-center gap-3 mt-4">
                <span class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em]">Protocol: Configuration Module 09-S (Search Discovery)</span>
                @if(isset($page) && $page->updated_at)
                    <span class="w-1 h-1 bg-slate-700 rounded-full"></span>
                    <span class="text-[10px] text-brand-cyan font-bold uppercase tracking-[0.3em]">Last Sync: {{ $page->updated_at->format('Y.m.d H:i') }}</span>
                @endif
            </div>
        </div>
        <a href="/search" target="_blank" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-brand-cyan hover:border-brand-cyan transition-all group shadow-lg">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-[10px] font-black text-emerald-400 uppercase tracking-widest animate-fade-in-up">
            Transaction Complete: Discovery Matrix successfully synchronized.
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-[10px] font-black text-red-400 uppercase tracking-widest space-y-2 animate-fade-in-up">
            @foreach ($errors->all() as $error)
                <div class="flex items-center gap-2"><span>✕</span> <span>{{ $error }}</span></div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pages.search.update') }}" enctype="multipart/form-data" class="space-y-10">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="glass-card p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-white/5 pb-4">
                    <span class="text-[10px] font-black text-brand-cyan uppercase tracking-[0.3em]">Core Directives</span>
                    <span class="text-[9px] text-slate-700 font-black uppercase tracking-widest">Primary Matrix</span>
                </div>

                <div class="space-y-6">
                    <div class="group">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Inquiry Placeholder</label>
                        <input name="search_placeholder" value="{{ old('search_placeholder', $content['search_placeholder'] ?? 'Cari jasa desain...') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-5 text-xs text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-bold">
                    </div>

                    <div class="group">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Featured Categories (CSV)</label>
                        <input name="featured_categories" value="{{ old('featured_categories', $content['featured_categories'] ?? 'Logo,Poster,UI Kit') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-5 text-xs text-slate-400 focus:text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-mono">
                        <p class="text-[8px] text-slate-600 font-bold mt-2 uppercase tracking-wide">Protocol: Comma-separated list for tactical tagging.</p>
                    </div>

                    <div class="group">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Intro Narrative</label>
                        <textarea name="intro_text" rows="3" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-6 text-xs text-slate-400 focus:text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-medium h-24 resize-none">{{ old('intro_text', $content['intro_text'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="glass-card p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-white/5 pb-4">
                    <span class="text-[10px] font-black text-brand-cyan uppercase tracking-[0.3em]">Background Vector</span>
                    <span class="text-[9px] text-slate-700 font-black uppercase tracking-widest">Environmental Shroud</span>
                </div>

                <div class="space-y-4">
                    <div class="relative group aspect-video rounded-2xl overflow-hidden border border-white/5 shadow-2xl">
                        <img src="{{ $content['hero_image'] ?? 'https://dummyimage.com/600x400/0b0f14/slate-100&text=Asset+Null' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" id="hero-preview">
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-nearBlack via-transparent to-transparent opacity-60"></div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="relative flex-1">
                            <input type="file" name="hero_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" id="hero-input">
                            <div class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-4 text-[9px] font-black text-slate-600 uppercase tracking-widest flex items-center justify-center gap-3 hover:border-brand-cyan/30 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span>Re-Inject Hero Shroud</span>
                            </div>
                        </div>
                        <label class="flex items-center gap-3 cursor-pointer group px-5 py-4 bg-white/5 rounded-xl border border-white/5 hover:border-red-500/30 transition-all">
                            <input type="checkbox" name="remove_hero_image" value="1" class="hidden peer">
                            <div class="w-10 h-5 bg-white/5 rounded-full border border-white/10 peer-checked:bg-red-500 transition-all relative">
                                <div class="absolute top-0.5 left-0.5 w-3.5 h-3.5 bg-white rounded-full transition-transform peer-checked:translate-x-5"></div>
                            </div>
                            <span class="text-[8px] font-black text-slate-600 uppercase tracking-widest">Purge</span>
                        </label>
                    </div>
                    <div class="text-[8px] text-slate-700 font-mono truncate px-2 text-right">{{ basename($content['hero_image'] ?? 'Alpha-Null') }}</div>
                </div>
            </div>
        </div>

        <div class="glass-card p-8 space-y-8">
            <div class="flex items-center justify-between border-b border-white/5 pb-4">
                <span class="text-[10px] font-black text-brand-cyan uppercase tracking-[0.3em]">Featured Strategic Assets</span>
                <button type="button" id="addFeatured" class="px-4 py-2 rounded-lg bg-brand-cyan/10 border border-brand-cyan/20 text-[8px] font-black text-brand-cyan uppercase tracking-widest hover:bg-brand-cyan hover:text-white transition-all">
                    Initiate Node Addition
                </button>
            </div>

            <div id="featuredList" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($content['featured_items'] ?? [] as $i => $it)
                    <div class="p-6 bg-white/[0.02] border border-white/5 rounded-2xl group relative overflow-hidden" data-index="{{ $i }}">
                        <div class="absolute -right-4 -top-4 w-16 h-16 bg-brand-cyan/5 rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-all"></div>
                        <div class="flex items-start gap-6">
                            <div class="w-24 h-24 flex-shrink-0 rounded-xl overflow-hidden border border-white/10 group-hover:border-brand-cyan/40 transition-all">
                                @if(!empty($it['image']))
                                    <img src="{{ $it['image'] }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-white/5 flex items-center justify-center">
                                        <span class="text-[7px] text-slate-700 font-bold uppercase">No Asset</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 space-y-4">
                                <div class="group">
                                    <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 block">Node Identity</label>
                                    <input type="text" name="featured_titles[]" value="{{ $it['title'] }}" placeholder="Title" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-4 text-[11px] text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-bold">
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="relative flex-1">
                                        <input type="file" name="featured_images[]" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="w-full bg-white/5 border border-white/10 rounded-lg py-2 px-3 text-[8px] font-black text-slate-600 uppercase tracking-widest flex items-center justify-center gap-2 hover:border-brand-cyan/30 transition-all">
                                            <span>Inject</span>
                                        </div>
                                    </div>
                                    <label class="flex items-center gap-2 cursor-pointer group px-3 py-2 bg-white/5 rounded-lg border border-white/5 hover:border-red-500/30 transition-all">
                                        <input type="checkbox" name="remove_featured_{{ $i }}" value="1" class="hidden peer">
                                        <div class="w-6 h-3 bg-white/5 rounded-full border border-white/10 peer-checked:bg-red-500 transition-all relative">
                                            <div class="absolute top-0.5 left-0.5 w-1.5 h-1.5 bg-white rounded-full transition-transform peer-checked:translate-x-3"></div>
                                        </div>
                                        <span class="text-[7px] font-black text-slate-600 uppercase tracking-widest">Wipe</span>
                                    </label>
                                </div>
                                @if(!empty($it['image']))
                                    <div class="text-[7px] text-slate-700 font-mono truncate">{{ basename($it['image']) }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- GLOBAL ACTIONS --}}
        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-10 border-t border-white/5">
            <a href="/search" target="_blank" class="btn-secondary py-4 px-10 text-[10px] uppercase tracking-[0.2em] font-black w-full sm:w-auto text-center">System Preview</a>
            <button type="submit" class="btn-primary py-4 px-10 text-[10px] uppercase tracking-[0.2em] font-black w-full sm:w-auto shadow-lg shadow-brand-cyan/20">Commit Inquiry Matrix</button>
        </div>
    </form>
</div>

<script>
    (function(){
        // Hero preview enhancement
        const hi = document.getElementById('hero-input');
        const hp = document.getElementById('hero-preview');
        if (hi && hp) {
            hi.addEventListener('change', function(e){
                const f = e.target.files && e.target.files[0];
                if (f) {
                    const reader = new FileReader();
                    reader.onload = function(re) { hp.src = re.target.result; };
                    reader.readAsDataURL(f);
                }
            });
        }

        // Add featured node logic
        document.getElementById('addFeatured')?.addEventListener('click', function(){
            const list = document.getElementById('featuredList');
            const idx = list.children.length;
            const el = document.createElement('div');
            el.className = 'p-6 bg-white/[0.04] border border-brand-cyan/20 rounded-2xl flex items-start gap-4 animate-fade-in-up';
            el.innerHTML = `
                <div class="flex-1 space-y-4">
                   <div class="group">
                        <label class="text-[9px] font-black text-brand-cyan uppercase tracking-[0.2em] mb-2 block">New Node Identity</label>
                        <input type="text" name="featured_titles[]" placeholder="Title" class="w-full bg-white/5 border border-brand-cyan/20 rounded-xl py-2 px-4 text-[11px] text-white focus:outline-none transition-all font-bold">
                    </div>
                </div>
                <div class="w-36 space-y-3">
                    <div class="relative">
                        <input type="file" name="featured_images[]" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="w-full bg-brand-cyan/10 border border-brand-cyan/20 rounded-lg py-2 px-3 text-[8px] font-black text-brand-cyan uppercase tracking-widest flex items-center justify-center gap-2">
                            <span>Upload Asset</span>
                        </div>
                    </div>
                    <div class="text-[7px] text-slate-600 font-mono text-center">Protocol: Ready for Injection</div>
                </div>
            `;
            list.appendChild(el);
        });
    })();
</script>
@endsection
