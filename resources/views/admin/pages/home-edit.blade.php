@extends('admin.layout')

@section('content')
<div class="reveal active space-y-10">
    {{-- TOP NAVIGATION --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight uppercase leading-none">Dashboard <span class="animate-text-shimmer">Control Center</span></h2>
            <div class="flex items-center gap-3 mt-4">
                <span class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em]">Protocol: Configuration Module 01 (Home)</span>
                @if(isset($page) && $page->updated_at)
                    <span class="w-1 h-1 bg-slate-700 rounded-full"></span>
                    <span class="text-[10px] text-brand-cyan font-bold uppercase tracking-[0.3em]">Last Sync: {{ $page->updated_at->format('Y.m.d H:i') }}</span>
                @endif
            </div>
        </div>
        <a href="/" target="_blank" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-brand-cyan hover:border-brand-cyan transition-all group shadow-lg">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-[10px] font-black text-emerald-400 uppercase tracking-widest animate-fade-in-up">
            Transaction Complete: Record successfully synchronized.
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-[10px] font-black text-red-400 uppercase tracking-widest space-y-2 animate-fade-in-up">
            <div class="flex items-center gap-2">
                <span>✕</span> <span>Verification Failed:</span>
            </div>
            <ul class="list-disc pl-5 mt-2 transition-all">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pages.home.update') }}" enctype="multipart/form-data" class="grid grid-cols-12 gap-8">
        @csrf
        @method('PUT')

        {{-- LEFT COLUMN: CONTENT DATA --}}
        <div class="col-span-12 lg:col-span-8 space-y-8">
            <div class="glass-card p-8 space-y-8">
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 border-b border-white/5 pb-4">Hero Infrastructure</h3>
                
                <div class="group">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Hero Prime Title</label>
                    <input name="hero_title" value="{{ old('hero_title', $content['hero_title'] ?? '') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all font-medium" required>
                </div>

                <div class="group">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Hero Sub-Directive</label>
                    <textarea name="hero_subtitle" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all font-medium h-32 resize-none">{{ old('hero_subtitle', $content['hero_subtitle'] ?? '') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">CTA Alpha Label</label>
                            <input name="cta1_label" value="{{ old('cta1_label', $content['cta1_label'] ?? '') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 transition-all">
                        </div>
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">CTA Alpha Target</label>
                            <input name="cta1_link" value="{{ old('cta1_link', $content['cta1_link'] ?? '') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-6 text-sm text-slate-400 focus:text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-mono">
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">CTA Beta Label</label>
                            <input name="cta2_label" value="{{ old('cta2_label', $content['cta2_label'] ?? '') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 transition-all">
                        </div>
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">CTA Beta Target</label>
                            <input name="cta2_link" value="{{ old('cta2_link', $content['cta2_link'] ?? '') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-6 text-sm text-slate-400 focus:text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-mono">
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card p-8">
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-8 border-b border-white/5 pb-4">Performance Metrics</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="group text-center">
                        <label class="text-[9px] font-black text-slate-600 uppercase tracking-[0.3em] mb-3 block">Total Ventures</label>
                        <input name="projects_count" value="{{ old('projects_count', $content['projects_count'] ?? '50K+') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-4 text-center text-lg font-black text-brand-cyan focus:outline-none focus:border-brand-cyan/50 transition-all">
                    </div>
                    <div class="group text-center">
                        <label class="text-[9px] font-black text-slate-600 uppercase tracking-[0.3em] mb-3 block">Tactical Unit</label>
                        <input name="designers_count" value="{{ old('designers_count', $content['designers_count'] ?? '1K+') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-4 text-center text-lg font-black text-brand-violet focus:outline-none focus:border-brand-violet/50 transition-all">
                    </div>
                    <div class="group text-center">
                        <label class="text-[9px] font-black text-slate-600 uppercase tracking-[0.3em] mb-3 block">Loyalty Index</label>
                        <input name="satisfaction_percent" value="{{ old('satisfaction_percent', $content['satisfaction_percent'] ?? '98%') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-4 text-center text-lg font-black text-white focus:outline-none focus:border-brand-cyan/50 transition-all">
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: ASSETS & CONTROL --}}
        <div class="col-span-12 lg:col-span-4 space-y-8">
            <div class="glass-card p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-brand-cyan/5 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
                
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6">Dashboard Thumbnail</h3>
                
                <div class="space-y-6">
                    <div class="relative group aspect-video rounded-2xl overflow-hidden border border-white/10 shadow-2xl">
                        <img id="heroPreview" src="{{ $content['hero_image'] ?? 'https://dummyimage.com/600x400/eeeeee/000000&text=Asset+Missing' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-charcoal to-transparent opacity-60"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="text-[8px] text-white/40 font-bold uppercase tracking-widest truncate">Asset Source: {{ basename($content['hero_image'] ?? 'Alpha-Zero') }}</div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="relative">
                            <input type="file" name="hero_image" id="hero_image_input" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-6 text-[10px] font-black text-slate-500 uppercase tracking-widest flex items-center justify-center gap-3 group-hover:border-brand-cyan/50 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Inject New Thumbnail</span>
                            </div>
                        </div>

                        <div id="fileInfo" class="hidden px-4 py-2 rounded-lg bg-white/5 text-[9px] text-brand-cyan font-bold uppercase tracking-widest text-center animate-pulse"></div>

                        <div class="flex items-center justify-between pt-4 border-t border-white/5">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="remove_hero_image" id="remove_hero_image_checkbox" value="1" class="hidden peer">
                                <div class="w-10 h-6 bg-white/5 rounded-full border border-white/10 peer-checked:bg-red-500 transition-all relative">
                                    <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
                                </div>
                                <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest group-hover:text-white transition-colors">Purge Current</span>
                            </label>
                            <button type="button" id="removeImageBtn" class="text-[9px] font-black text-slate-600 hover:text-red-400 uppercase tracking-widest transition-colors">Trigger Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card p-8 space-y-4">
                <button type="submit" class="btn-primary w-full py-4 text-[10px] uppercase tracking-[0.2em] font-black shadow-lg shadow-brand-cyan/20">Commit Changes</button>
                <a href="/" target="_blank" class="btn-secondary w-full py-4 text-[10px] uppercase tracking-[0.2em] font-black text-center">Live Preview</a>
            </div>
        </div>
    </form>
</div>

<script>
    (function(){
        const input = document.getElementById('hero_image_input');
        const fileInfo = document.getElementById('fileInfo');
        const preview = document.getElementById('heroPreview');
        const removeCb = document.getElementById('remove_hero_image_checkbox');
        const removeBtn = document.getElementById('removeImageBtn');

        input && input.addEventListener('change', function(e){
            const file = e.target.files && e.target.files[0];
            if (!file) return;
            
            if (removeCb) removeCb.checked = false;
            
            const reader = new FileReader();
            reader.onload = (ev) => { if (preview) preview.src = ev.target.result; };
            reader.readAsDataURL(file);
            
            if (fileInfo) {
                fileInfo.textContent = `Queued: ${file.name} [${Math.round(file.size/1024)}KB]`;
                fileInfo.classList.remove('hidden');
            }
        });

        removeBtn && removeBtn.addEventListener('click', function(){
            if (!confirm('Purge hero architecture asset? Applied on commit.')) return;
            if (removeCb) removeCb.checked = true;
            if (preview) preview.src = 'https://dummyimage.com/600x400/0b0f14/ffffff&text=PENDING+PURGE';
            if (fileInfo) fileInfo.classList.add('hidden');
        });
    })();
</script>
@endsection
