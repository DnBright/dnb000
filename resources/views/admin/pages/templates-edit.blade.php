@extends('admin.layout')

@section('content')
<div class="reveal active space-y-10">
    {{-- TOP NAVIGATION --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight uppercase leading-none">Dashboard <span class="animate-text-shimmer">Templates</span></h2>
            <div class="flex items-center gap-3 mt-4">
                <span class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em]">Protocol: Configuration Module 06 (Ready Assets)</span>
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
            Transaction Complete: Template Matrix successfully synchronized.
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-[10px] font-black text-red-400 uppercase tracking-widest space-y-2 animate-fade-in-up">
            @foreach ($errors->all() as $error)
                <div class="flex items-center gap-2"><span>✕</span> <span>{{ $error }}</span></div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pages.templates.update') }}" enctype="multipart/form-data" class="space-y-10">
        @csrf
        @method('PUT')

        <div class="flex items-center justify-between border-b border-white/5 pb-6">
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.2em]">Deployment: 04 Available Template Nodes</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @php $defaults = [
                ['name'=>'Business Card Templates','price'=>'Rp 25K','image'=>'https://dummyimage.com/600x350/ddd/000&text=Business+Card','link'=>'#'],
                ['name'=>'Instagram Story Pack','price'=>'Gratis','image'=>'https://dummyimage.com/600x350/eee/000&text=Story','link'=>'#'],
                ['name'=>'Presentation Template','price'=>'Rp 75K','image'=>'https://dummyimage.com/600x350/ddd/000&text=Presentation','link'=>'#'],
                ['name'=>'Brochure Template','price'=>'Rp 35K','image'=>'https://dummyimage.com/600x350/ccc/000&text=Brochure','link'=>'#']
            ]; @endphp

            @for($i=0;$i<4;$i++)
                @php $t = $content['templates'][$i] ?? []; @endphp
                <div class="glass-card p-8 space-y-6 relative group overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-brand-cyan/5 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-all"></div>
                    
                    <div class="flex items-center justify-between border-b border-white/5 pb-4">
                        <span class="text-[9px] font-black text-brand-cyan uppercase tracking-[0.4em]">Node #{{ $i + 1 }}</span>
                        <span class="text-[9px] text-slate-700 font-black uppercase tracking-widest">Available Resource</span>
                    </div>

                    <div class="space-y-4">
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Asset Designation</label>
                            <input name="template_names[]" value="{{ old('template_names.'.$i, $t['name'] ?? $defaults[$i]['name']) }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-5 text-xs text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-bold">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Acquisition Tier (Price)</label>
                                <input name="template_prices[]" value="{{ old('template_prices.'.$i, $t['price'] ?? $defaults[$i]['price']) }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-5 text-xs text-brand-cyan focus:outline-none focus:border-brand-cyan/50 transition-all font-black">
                            </div>
                            <div class="group">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Access Protocol (Link)</label>
                                <input name="template_links[]" value="{{ old('template_links.'.$i, $t['link'] ?? $defaults[$i]['link']) }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-5 text-[10px] text-slate-500 focus:text-white focus:outline-none transition-all font-mono">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 pt-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] block ml-1">Visual Signature mapping</label>
                        
                        @if(!empty($t['image']))
                            <div class="relative w-full h-32 rounded-xl overflow-hidden border border-white/10 group-hover:border-brand-cyan/30 transition-all">
                                <img src="{{ $t['image'] }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-2 left-3 text-[8px] text-white/60 font-mono truncate max-w-[90%]">{{ basename($t['image']) }}</div>
                            </div>
                        @else
                            <div class="w-full h-20 rounded-xl bg-white/5 border border-dashed border-white/10 flex items-center justify-center">
                                <span class="text-[8px] text-slate-600 font-black uppercase tracking-widest">No Visual Asset</span>
                            </div>
                        @endif

                        <div class="flex items-center gap-4">
                            <div class="relative flex-1">
                                <input type="file" name="template_images[]" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" data-index="{{ $i }}">
                                <div class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-[9px] font-black text-slate-600 uppercase tracking-widest flex items-center justify-center gap-2 hover:border-brand-cyan/30 transition-all">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                    <span>Inject New Asset</span>
                                </div>
                            </div>
                            <label class="flex items-center gap-3 cursor-pointer group px-4 py-2 bg-white/5 rounded-xl border border-white/5 hover:border-red-500/30 transition-all">
                                <input type="checkbox" name="remove_template_{{ $i }}" value="1" class="hidden peer">
                                <div class="w-8 h-4 bg-white/5 rounded-full border border-white/10 peer-checked:bg-red-500 transition-all relative">
                                    <div class="absolute top-0.5 left-0.5 w-2.5 h-2.5 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
                                </div>
                                <span class="text-[8px] font-black text-slate-600 uppercase tracking-widest">Wipe</span>
                            </label>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        {{-- GLOBAL ACTIONS --}}
        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-8 border-t border-white/5">
            <a href="/" target="_blank" class="btn-secondary py-4 px-10 text-[10px] uppercase tracking-[0.2em] font-black w-full sm:w-auto text-center">System Preview</a>
            <button type="submit" class="btn-primary py-4 px-10 text-[10px] uppercase tracking-[0.2em] font-black w-full sm:w-auto shadow-lg shadow-brand-cyan/20">Commit Template Matrix</button>
        </div>
    </form>
</div>

<script>
    (function(){
        document.querySelectorAll('input[name="template_images[]"]').forEach(function(inp){
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
                const removeCb = document.querySelector(`input[name="remove_template_${idx}"]`);
                if (removeCb) removeCb.checked = false;
            });
        });
    })();
</script>
@endsection
