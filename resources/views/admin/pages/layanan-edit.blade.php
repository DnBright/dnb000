@extends('admin.layout')

@section('content')
<div class="reveal active space-y-10">
    {{-- TOP NAVIGATION --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight uppercase leading-none">Services <span class="animate-text-shimmer">Matrix</span></h2>
            <div class="flex items-center gap-3 mt-4">
                <span class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em]">Protocol: Configuration Module 02</span>
                <span class="w-1 h-1 bg-slate-700 rounded-full"></span>
                <span class="text-[10px] text-brand-cyan font-bold uppercase tracking-[0.3em]">Layanan Registry</span>
            </div>
        </div>
        <a href="/" target="_blank" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-brand-cyan hover:border-brand-cyan transition-all group shadow-lg">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-[10px] font-black text-emerald-400 uppercase tracking-widest animate-fade-in-up">
            Transaction Complete: Services Matrix successfully synchronized.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pages.layanan.update') }}" enctype="multipart/form-data" class="space-y-10">
        @csrf
        @method('PUT')

        {{-- HERO INFRASTRUCTURE --}}
        <div class="glass-card p-8 space-y-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-brand-cyan/5 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
            <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 border-b border-white/5 pb-4">Hero Infrastructure</h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="group">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Hero Prime Title</label>
                        <input name="hero_title" value="{{ old('hero_title', $content['hero']['title'] ?? $content['hero_title'] ?? '') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all font-medium">
                    </div>
                    <div class="group">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Hero Sub-Directive</label>
                        <input name="hero_subtitle" value="{{ old('hero_subtitle', $content['hero']['subtitle'] ?? $content['hero_subtitle'] ?? '') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-6 text-sm text-slate-400 focus:text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-medium">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">CTA Alpha Label</label>
                            <input name="cta1_label" value="{{ old('cta1_label', $content['cta1_label'] ?? 'Lihat Layanan') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 transition-all">
                        </div>
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">CTA Alpha Target</label>
                            <input name="cta1_link" value="{{ old('cta1_link', $content['cta1_link'] ?? '#services') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-6 text-sm text-slate-400 focus:text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-mono">
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">CTA Beta Label</label>
                            <input name="cta2_label" value="{{ old('cta2_label', $content['cta2_label'] ?? 'Konsultasi') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 transition-all">
                        </div>
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">CTA Beta Target</label>
                            <input name="cta2_link" value="{{ old('cta2_link', $content['cta2_link'] ?? 'https://wa.me/6281234567890') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-6 text-sm text-slate-400 focus:text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-mono">
                        </div>
                    </div>
                </div>
            </div>

            <div class="group pt-4">
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4 block ml-1">Visual Core Override (Optional)</label>
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <div class="relative w-full sm:w-auto flex-1">
                        <input type="file" name="hero_image" id="hero_image_input" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-6 text-[10px] font-black text-slate-500 uppercase tracking-widest flex items-center justify-center gap-3 hover:border-brand-cyan/50 transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Inject New Asset</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-6 px-6 border-l border-white/5 h-14">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="remove_hero_image" value="1" class="hidden peer">
                            <div class="w-10 h-6 bg-white/5 rounded-full border border-white/10 peer-checked:bg-red-500 transition-all relative">
                                <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
                            </div>
                            <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest group-hover:text-white transition-colors">Purge Current</span>
                        </label>
                        <span class="text-[9px] text-slate-500 font-mono hidden sm:inline">{{ basename($content['hero_image'] ?? 'None') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- SERVICE NODES --}}
        <div>
            <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.5em] mb-8 ml-1">Service Node Registry [06]</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @php $defaults = ['Desain Logo','Design Stationery','Website Design','Kemasan Design','Feeds Design','Design Lainnya']; @endphp
                @for($i=0;$i<6;$i++)
                    @php $svc = $content['services'][$i] ?? []; @endphp
                    <div class="glass-card p-8 space-y-6 relative group overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-brand-cyan/5 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-all"></div>
                        <div class="flex items-center justify-between border-b border-white/5 pb-4">
                            <span class="text-[9px] font-black text-brand-cyan uppercase tracking-[0.4em]">Node #{{ $i + 1 }}</span>
                            <span class="text-[9px] text-slate-700 font-black uppercase tracking-widest">{{ Str::slug($defaults[$i]) }}</span>
                        </div>

                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Core Designation</label>
                            <input name="layanan_titles[]" value="{{ old('layanan_titles.'.$i, $svc['title'] ?? $defaults[$i]) }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-5 text-xs text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-bold">
                            <input type="hidden" name="layanan_pakets[]" value="{{ old('layanan_pakets.'.$i, $svc['paket'] ?? Str::slug($defaults[$i])) }}">
                        </div>

                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Operational Summary</label>
                            <input name="layanan_subtitles[]" value="{{ old('layanan_subtitles.'.$i, $svc['subtitle'] ?? '') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-5 text-xs text-slate-400 focus:text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-medium">
                        </div>

                        <div class="space-y-4 pt-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] block ml-1">Node Asset</label>
                            <div class="flex items-center gap-4">
                                <div class="relative flex-1">
                                    <input type="file" name="layanan_images[]" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" data-index="{{ $i }}">
                                    <div class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-[9px] font-black text-slate-600 uppercase tracking-widest flex items-center justify-center gap-2 hover:border-brand-cyan/30 transition-all">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                        <span>Map Asset</span>
                                    </div>
                                </div>
                                <label class="flex items-center gap-3 cursor-pointer group px-4 py-2 bg-white/5 rounded-xl border border-white/5 hover:border-red-500/30 transition-all">
                                    <input type="checkbox" name="remove_layanan_{{ $i }}" value="1" class="hidden peer">
                                    <div class="w-8 h-4 bg-white/5 rounded-full border border-white/10 peer-checked:bg-red-500 transition-all relative">
                                        <div class="absolute top-0.5 left-0.5 w-2.5 h-2.5 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
                                    </div>
                                    <span class="text-[8px] font-black text-slate-600 uppercase tracking-widest">Wipe</span>
                                </label>
                            </div>
                            <div class="text-[8px] text-slate-700 font-mono truncate px-1">{{ $svc['image'] ?? 'No mapping protocol assigned.' }}</div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        {{-- GLOBAL ACTIONS --}}
        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-8 border-t border-white/5">
            <a href="/" target="_blank" class="btn-secondary py-4 px-10 text-[10px] uppercase tracking-[0.2em] font-black w-full sm:w-auto text-center">Protocol Preview</a>
            <button type="submit" class="btn-primary py-4 px-10 text-[10px] uppercase tracking-[0.2em] font-black w-full sm:w-auto shadow-lg shadow-brand-cyan/20">Commit Services Matrix</button>
        </div>
    </form>
</div>

<script>
    (function(){
        document.querySelectorAll('input[name="layanan_images[]"]').forEach(function(inp){
            inp.addEventListener('change', function(e){
                const f = e.target.files && e.target.files[0];
                let el = e.target.nextElementSibling;
                if (!el || !el.classList) {
                    el = document.createElement('div');
                    el.className = 'text-[9px] text-brand-cyan font-bold uppercase tracking-widest mt-3 animate-pulse';
                    e.target.parentNode.insertBefore(el, e.target.nextSibling);
                }
                if (!f) { el.textContent = ''; return; }
                el.textContent = `Queued: ${f.name} [${Math.round(f.size/1024)}KB]`;
                const idx = e.target.getAttribute('data-index');
                const removeCb = document.querySelector(`input[name="remove_layanan_${idx}"]`);
                if (removeCb) removeCb.checked = false;
            });
        });
    })();
</script>
@endsection
