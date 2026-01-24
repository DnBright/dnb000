@extends('layouts.main')

@section('content')

<main class="relative min-h-screen py-20 overflow-hidden">
    <!-- Immersive Background Elements -->
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute top-[10%] left-[-5%] w-[40%] h-[40%] bg-brand-cyan/5 blur-[120px] rounded-full animate-blob-float"></div>
        <div class="absolute bottom-[20%] right-[-5%] w-[40%] h-[40%] bg-brand-violet/5 blur-[120px] rounded-full animate-blob-float" style="animation-delay: -7s;"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <!-- ORDERING GUIDE -->
        <x-ordering-guide activeStep="2" class="mb-16" />

        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-12 gap-12 items-start">
                
                {{-- MAIN FORM --}}
                <div class="lg:col-span-8 reveal" style="transition-delay: 100ms;">
                    <div class="glass-card p-8 md:p-12 relative overflow-hidden">
                        <header class="mb-12">
                            <div class="flex items-center gap-6 mb-4">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-cyan to-brand-violet flex items-center justify-center text-black text-3xl font-black shadow-2xl">
                                    {{ strtoupper(substr($paket,0,1)) }}
                                </div>
                                <div>
                                    <h1 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tight">
                                        {{ ucwords(str_replace('-', ' ', $paket)) }} <span class="animate-text-shimmer">{{ __('Manifest.') }}</span>
                                    </h1>
                                    <p class="text-slate-500 text-xs font-bold uppercase tracking-[0.2em] mt-1">{{ __('Design Intelligence Acquisition Phase') }}</p>
                                </div>
                            </div>
                        </header>

                        <form action="{{ route('brief.review') }}" method="POST" class="space-y-12">
                            @csrf
                            <input type="hidden" name="paket" value="{{ $paket ?? 'standard' }}">

                            <!-- Section: Entity Profile -->
                            <section class="space-y-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-[2px] bg-brand-cyan shadow-[0_0_10px_rgba(6,246,255,0.5)]"></div>
                                    <h2 class="text-[11px] font-black text-white uppercase tracking-[0.4em]">{{ __('Section 01 / Profile') }}</h2>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                                    {{-- Group --}}
                                    <div class="flex flex-col gap-2.5">
                                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                            <span class="w-1 h-1 bg-brand-cyan rounded-full"></span>
                                            {{ __('Liaison Name') }} <span class="text-brand-cyan/50">*</span>
                                        </label>
                                        <input name="nama" type="text" required class="form-input-premium" placeholder="{{ __('Protocol Officer Name') }}">
                                    </div>

                                    <div class="flex flex-col gap-2.5">
                                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                            <span class="w-1 h-1 bg-brand-cyan rounded-full"></span>
                                            {{ __('Comms Email') }} <span class="text-brand-cyan/50">*</span>
                                        </label>
                                        <input name="email" type="email" required class="form-input-premium" placeholder="secure@link.com">
                                    </div>

                                    <div class="flex flex-col gap-2.5">
                                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                            <span class="w-1 h-1 bg-brand-cyan rounded-full"></span>
                                            {{ __('Secure Mobile') }} <span class="text-brand-cyan/50">*</span>
                                        </label>
                                        <input name="whatsapp" type="text" required class="form-input-premium" placeholder="+62 812...">
                                    </div>

                                    <div class="flex flex-col gap-2.5">
                                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                            <span class="w-1 h-1 bg-brand-cyan rounded-full"></span>
                                            {{ __('Brand Designation') }} <span class="text-brand-cyan/50">*</span>
                                        </label>
                                        <input name="brand" type="text" required class="form-input-premium" placeholder="{{ __('Core Identity Name') }}">
                                    </div>

                                    <div class="md:col-span-2 flex flex-col gap-2.5">
                                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                            <span class="w-1 h-1 bg-brand-cyan rounded-full"></span>
                                            {{ __('Target Demographic') }}
                                        </label>
                                        <input name="audience" type="text" class="form-input-premium" placeholder="{{ __('Identify the target audience projected to interact with the brand') }}">
                                    </div>
                                </div>
                            </section>

                            <!-- Section: Project Intelligence -->
                            <section class="space-y-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-[2px] bg-brand-violet shadow-[0_0_10px_rgba(139,92,246,0.5)]"></div>
                                    <h2 class="text-[11px] font-black text-white uppercase tracking-[0.4em]">{{ __('Section 02 / Directives') }}</h2>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                                    <div class="md:col-span-2 flex flex-col gap-2.5">
                                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                            <span class="w-1 h-1 bg-brand-violet rounded-full"></span>
                                            {{ __('Brand Tagline') }}
                                        </label>
                                        <input name="tagline" type="text" class="form-input-premium" placeholder="{{ __('Core Narrative (Optional)') }}">
                                    </div>
                                    <div class="md:col-span-2 flex flex-col gap-2.5">
                                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                            <span class="w-1 h-1 bg-brand-violet rounded-full"></span>
                                            {{ __('Sector / Industry') }} <span class="text-brand-violet/50">*</span>
                                        </label>
                                        <input name="jenis_usaha" type="text" required class="form-input-premium" placeholder="{{ __('Primary Operational Sector') }}">
                                    </div>
                                    <div class="md:col-span-2 flex flex-col gap-2.5">
                                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                            <span class="w-1 h-1 bg-brand-violet rounded-full"></span>
                                            {{ __('Design Directive') }} <span class="text-brand-violet/50">*</span>
                                        </label>
                                        <textarea name="keterangan" rows="6" required class="form-input-premium min-h-[160px] leading-relaxed resize-none" placeholder="{{ __('Provide detailed aesthetic requirements, color preferences, or specific layout instructions...') }}"></textarea>
                                    </div>
                                    <div class="flex flex-col gap-2.5">
                                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                            <span class="w-1 h-1 bg-brand-violet rounded-full"></span>
                                            {{ __('Visual References') }}
                                        </label>
                                        <input name="referensi" type="text" class="form-input-premium" placeholder="{{ __('Link to moodboards or inspiration') }}">
                                    </div>
                                    <div class="flex flex-col gap-2.5">
                                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                            <span class="w-1 h-1 bg-brand-violet rounded-full"></span>
                                            {{ __('Chromatic Palette') }}
                                        </label>
                                        <input name="warna" type="text" class="form-input-premium" placeholder="{{ __('Primary colors or tone preferences') }}">
                                    </div>
                                </div>
                            </section>

                            <!-- Section: Aesthetic DNA -->
                            <section class="space-y-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-[2px] bg-brand-accent shadow-[0_0_10px_rgba(255,61,0,0.5)]"></div>
                                    <h2 class="text-[11px] font-black text-white uppercase tracking-[0.4em]">{{ __('Section 03 / Aesthetic DNA') }}</h2>
                                </div>

                                <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach (['Elegant','Fun','Classic','Vintage','Minimalist','Feminime','Modern','Complex','Serious'] as $type)
                                        <label class="dna-chip group relative flex items-center justify-center p-3.5 rounded-xl border border-white/5 bg-white/[0.02] hover:bg-white/5 transition-all cursor-pointer">
                                            <input type="checkbox" name="tipe_logo[]" value="{{ $type }}" class="sr-only">
                                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-brand-cyan transition-colors">{{ __($type) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </section>

                            <!-- Actions -->
                            <div class="flex flex-col sm:flex-row gap-6 pt-6 border-t border-white/5">
                                <a href="{{ route('layanan.show', $paket) }}" class="btn-secondary !py-4 flex-1 text-center text-xs tracking-[0.2em] font-black uppercase">
                                    {{ __('Abort Process') }}
                                </a>
                                <button type="submit" class="btn-primary !py-4 flex-1 text-xs tracking-[0.2em] font-black uppercase shadow-brand-cyan/20">
                                    {{ __('Sync Manifest') }} →
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- SUMMARY SIDE --}}
                <div class="lg:col-span-4 space-y-8 reveal" style="transition-delay: 300ms;">
                    <div class="glass-card p-8 sticky top-32 overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-cyan/5 blur-3xl rounded-full -mr-16 -mt-16"></div>
                        
                        <h3 class="text-sm font-black text-white uppercase tracking-[0.2em] mb-8 border-b border-white/5 pb-4">{{ __('Protocol Summary') }}</h3>
                        
                        <div class="space-y-6">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1">{{ __('Active Payload') }}</span>
                                <span class="text-white font-black tracking-tight text-lg">{{ ucwords(str_replace('-', ' ', $paket)) }}</span>
                            </div>

                            <div class="flex flex-col">
                                <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1">{{ __('Estimated Processing') }}</span>
                                <span class="text-brand-cyan font-black tracking-tight flex items-center gap-2 text-lg">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    3–7 {{ __('CYCLES') }}
                                </span>
                            </div>

                            <div class="p-6 rounded-2xl bg-white/5 border border-white/5 space-y-3">
                                <div class="flex justify-between items-center text-[10px] font-black">
                                    <span class="text-slate-500 uppercase tracking-widest">{{ __('Base Rate') }}</span>
                                    <span class="text-white">{{ __('CALCULATED') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-[10px] font-black">
                                    <span class="text-slate-500 uppercase tracking-widest">{{ __('Tax / Fees') }}</span>
                                    <span class="text-slate-500">{{ __('SECURE') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-white/5 text-[10px] text-slate-500 font-bold uppercase tracking-widest text-center">
                            {{ __('Awaiting data injection...') }}
                        </div>
                    </div>

                    <div class="glass-card p-6 border-brand-violet/20 bg-brand-violet/5 opacity-80">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-xl bg-brand-violet/10 flex items-center justify-center text-brand-violet">ℹ</div>
                            <div class="text-[10px] font-bold text-slate-400 leading-relaxed uppercase tracking-widest">
                                {{ __('Ensure all fields are calibrated. Information provided will dictate the initial design synchronization.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('styles')
<style>
    .form-input-premium {
        width: 100%;
        display: block;
        padding: 1rem 1.5rem;
        border-radius: 1rem;
        background-color: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #ffffff;
        outline: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 14px;
    }
    
    .form-input-premium:focus {
        border-color: #06f6ff;
        background-color: rgba(255, 255, 255, 0.05);
        box-shadow: 0 0 15px rgba(6, 246, 255, 0.15);
    }

    .form-input-premium::placeholder {
        color: #475569; /* slate-600 */
    }

    .dna-chip.selected {
        background-color: rgba(6, 246, 255, 0.1) !important;
        border-color: rgba(6, 246, 255, 0.5) !important;
    }
    
    .dna-chip.selected span {
        color: #06f6ff !important;
        text-shadow: 0 0 10px rgba(6, 246, 255, 0.4);
    }

    /* Force Verticality & Fix Colors */
    .form-group-vertical {
        display: flex !important;
        flex-direction: column !important;
        gap: 0.6rem !important;
    }
    
    /* Ensure inputs are dark even if overridden */
    input.form-input-premium, textarea.form-input-premium {
        background-color: rgba(15, 20, 25, 0.8) !important;
        color: white !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    input.form-input-premium:focus, textarea.form-input-premium:focus {
        border-color: #06f6ff !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    if (!form) return;

    // Toggle DNA chips logic
    const chips = document.querySelectorAll('.dna-chip');
    chips.forEach(chip => {
        const input = chip.querySelector('input');
        
        // Sync initial state (if any)
        if (input.checked) chip.classList.add('selected');

        chip.addEventListener('click', function(e) {
            // Prevent multiple triggers if clicking span/label
            // Small delay to let browser toggle input.checked
            setTimeout(() => {
                if (input.checked) {
                    chip.classList.add('selected');
                } else {
                    chip.classList.remove('selected');
                }
            }, 20);
        });
    });

    // Intersection Observer for reveals
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.1 });
    reveals.forEach(r => observer.observe(r));
    
    // Auto-scroll to top on validation error
    form.addEventListener('invalid', (function(){
        return function(e) {
            e.preventDefault();
            const firstInvalid = form.querySelector(':invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
        };
    })(), true);
});
</script>
@endpush

@endsection
