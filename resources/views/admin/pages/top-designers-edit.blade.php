@extends('admin.layout')

@section('content')
<div class="reveal active space-y-10">
    {{-- TOP NAVIGATION --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight uppercase leading-none">Dashboard <span class="animate-text-shimmer">Personnel</span></h2>
            <div class="flex items-center gap-3 mt-4">
                <span class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em]">Protocol: Configuration Module 04 (Specialists)</span>
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
            Transaction Complete: Elite Unit roster successfully synchronized.
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-[10px] font-black text-red-400 uppercase tracking-widest space-y-2 animate-fade-in-up">
            @foreach ($errors->all() as $error)
                <div class="flex items-center gap-2"><span>✕</span> <span>{{ $error }}</span></div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pages.top_designers.update') }}" enctype="multipart/form-data" class="space-y-10">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @php $defaults = [
                ['name'=>'Sarah Putri','role'=>'Logo & Brand Identity','image'=>'https://randomuser.me/api/portraits/women/44.jpg'],
                ['name'=>'Andi Rahman','role'=>'UI/UX Designer','image'=>'https://randomuser.me/api/portraits/men/32.jpg'],
                ['name'=>'Maya Sari','role'=>'Social Media Design','image'=>'https://randomuser.me/api/portraits/women/65.jpg'],
                ['name'=>'Budi Santoso','role'=>'Print Design','image'=>'https://randomuser.me/api/portraits/men/12.jpg']
            ]; @endphp

            @for($i=0;$i<4;$i++)
                @php $d = $content['top_designers'][$i] ?? []; @endphp
                <div class="glass-card p-8 space-y-6 relative group overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-brand-cyan/5 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-all"></div>
                    
                    <div class="flex items-center justify-between border-b border-white/5 pb-4">
                        <span class="text-[9px] font-black text-brand-cyan uppercase tracking-[0.4em]">Operative #{{ $i + 1 }}</span>
                        <span class="text-[9px] text-slate-700 font-black uppercase tracking-widest">Active Status</span>
                    </div>

                    <div class="space-y-4">
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Personnel Alias</label>
                            <input name="designer_names[]" value="{{ old('designer_names.'.$i, $d['name'] ?? $defaults[$i]['name']) }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-5 text-xs text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-bold">
                        </div>

                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Tactical Role</label>
                            <input name="designer_roles[]" value="{{ old('designer_roles.'.$i, $d['role'] ?? $defaults[$i]['role']) }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-5 text-xs text-slate-400 focus:text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-medium">
                        </div>

                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Network link</label>
                            <input name="designer_links[]" value="{{ old('designer_links.'.$i, $d['link'] ?? '') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-5 text-[10px] text-slate-500 focus:text-white focus:outline-none transition-all font-mono">
                        </div>

                        <div class="group">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 block ml-1">Mission Dossier</label>
                            <textarea name="designer_descriptions[]" rows="3" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 px-6 text-xs text-slate-400 focus:text-white focus:outline-none focus:border-brand-cyan/50 transition-all font-medium h-24 resize-none">{{ old('designer_descriptions.'.$i, $d['description'] ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="space-y-4 pt-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] block ml-1">Visual Signature</label>
                        
                        @if(!empty($d['image']))
                            <div class="relative w-20 h-20 rounded-2xl overflow-hidden border-2 border-brand-cyan/20 shadow-lg group-hover:border-brand-cyan transition-all">
                                <img src="{{ $d['image'] }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-brand-cyan/10"></div>
                            </div>
                        @else
                            <div class="w-20 h-20 rounded-2xl bg-white/5 border border-dashed border-white/10 flex items-center justify-center">
                                <span class="text-[8px] text-slate-600 font-black text-center px-2">No Signature</span>
                            </div>
                        @endif

                        <div class="flex items-center gap-4">
                            <div class="relative flex-1">
                                <input type="file" name="designer_images[]" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" data-index="{{ $i }}">
                                <div class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-[9px] font-black text-slate-600 uppercase tracking-widest flex items-center justify-center gap-2 hover:border-brand-cyan/30 transition-all">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                    <span>Inject New</span>
                                </div>
                            </div>
                            <label class="flex items-center gap-3 cursor-pointer group px-4 py-2 bg-white/5 rounded-xl border border-white/5 hover:border-red-500/30 transition-all">
                                <input type="checkbox" name="remove_designer_{{ $i }}" value="1" class="hidden peer">
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
            <button type="submit" class="btn-primary py-4 px-10 text-[10px] uppercase tracking-[0.2em] font-black w-full sm:w-auto shadow-lg shadow-brand-cyan/20">Commit Personnel Matrix</button>
        </div>
    </form>
</div>

<script>
    (function(){
        document.querySelectorAll('input[name="designer_images[]"]').forEach(function(inp){
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
                const removeCb = document.querySelector(`input[name="remove_designer_${idx}"]`);
                if (removeCb) removeCb.checked = false;
            });
        });
    })();
</script>
@endsection
