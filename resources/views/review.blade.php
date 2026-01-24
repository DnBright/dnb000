@extends('layouts.main')

@section('content')

<main class="relative min-h-[80vh] py-20 overflow-hidden">
    <!-- Immersive Background Elements -->
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute top-[20%] right-[-10%] w-[50%] h-[50%] bg-brand-cyan/10 blur-[120px] rounded-full animate-blob-float"></div>
        <div class="absolute bottom-[10%] left-[-10%] w-[50%] h-[50%] bg-brand-violet/10 blur-[120px] rounded-full animate-blob-float" style="animation-delay: -8s;"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <!-- ORDERING GUIDE -->
        <x-ordering-guide activeStep="2" class="mb-16" />

        <!-- HEADER -->
        <div class="max-w-4xl mx-auto mb-16 reveal">
            <div class="inline-flex px-4 py-1.5 rounded-full bg-brand-cyan/10 border border-brand-cyan/20 text-brand-cyan text-[10px] font-bold uppercase tracking-[0.3em] mb-8">
                {{ __('Validation Protocol [Step 03]') }}
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white leading-tight uppercase tracking-tight">
                {{ __('Review Your') }} <span class="animate-text-shimmer">{{ __('Manifest.') }}</span>
            </h1>
            <p class="text-slate-500 mt-4 font-bold uppercase text-xs tracking-widest">{{ __('Verify the integrity of your design directives before final synchronization.') }}</p>
        </div>

        <!-- PROGRESS BAR -->
        <div class="max-w-4xl mx-auto mb-16 reveal" style="transition-delay: 100ms;">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 relative">
                <div class="hidden md:block absolute top-[1.25rem] left-0 w-full h-px bg-white/10 -z-10"></div>
                <div class="hidden md:block absolute top-[1.25rem] left-0 w-3/4 h-px bg-gradient-to-r from-brand-cyan to-brand-violet -z-10 shadow-[0_0_10px_rgba(6,246,255,0.5)]"></div>

                @php
                    $steps = [
                        ['id' => 1, 'label' => __('Selection'), 'done' => true],
                        ['id' => 2, 'label' => __('Briefing'), 'done' => true],
                        ['id' => 3, 'label' => __('Validation'), 'active' => true],
                        ['id' => 4, 'label' => __('Commitment')]
                    ];
                @endphp

                @foreach($steps as $step)
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xs font-black transition-all duration-500 {{ isset($step['active']) ? 'bg-brand-cyan text-black shadow-[0_0_20px_rgba(6,246,255,0.4)]' : (isset($step['done']) ? 'bg-brand-violet/20 text-brand-violet border border-brand-violet/30' : 'bg-white/5 text-slate-600') }}">
                            @if(isset($step['done']) && !isset($step['active']))
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            @else
                                {{ $step['id'] }}
                            @endif
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] {{ isset($step['active']) ? 'text-white' : 'text-slate-500' }}">{{ $step['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- SUMMARY CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 reveal" style="transition-delay: 200ms;">
            <div class="glass-card p-8 border-l-2 border-brand-cyan shadow-brand-cyan/5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ __('Operational Status') }}</h3>
                    <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center text-green-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-black text-white uppercase tracking-tight">{{ __('READY') }}</p>
                <p class="text-[10px] text-slate-500 font-bold mt-1 uppercase tracking-widest">{{ __('Protocol Sync Nominal') }}</p>
            </div>

            <div class="glass-card p-8 border-l-2 border-brand-violet shadow-brand-violet/5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ __('Data Intensity') }}</h3>
                    <div class="w-8 h-8 rounded-lg bg-brand-violet/10 flex items-center justify-center text-brand-violet">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-black text-white uppercase tracking-tight">{{ count($data ?? []) }} {{ __('FIELDS') }}</p>
                <p class="text-[10px] text-slate-500 font-bold mt-1 uppercase tracking-widest">{{ __('Manifest Injected') }}</p>
            </div>

            <div class="glass-card p-8 border-l-2 border-brand-accent shadow-brand-accent/5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ __('Selected Payload') }}</h3>
                    <div class="w-8 h-8 rounded-lg bg-brand-accent/10 flex items-center justify-center text-brand-accent">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-black text-white uppercase tracking-tight">{{ strtoupper($data['paket'] ?? 'Standard') }}</p>
                <p class="text-[10px] text-slate-500 font-bold mt-1 uppercase tracking-widest">{{ __('Design Blueprint Type') }}</p>
            </div>
        </div>

        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-12 gap-12">
                
                {{-- DETAIL DATA --}}
                <div class="lg:col-span-8 reveal" style="transition-delay: 300ms;">
                    <div class="glass-card p-8 md:p-12 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-cyan/5 blur-3xl rounded-full -mr-32 -mt-32"></div>
                        
                        <h2 class="text-xl font-black text-white uppercase tracking-[0.2em] mb-12 flex items-center gap-4">
                            <span class="w-12 h-px bg-brand-cyan"></span>
                            {{ __('Manifest Details') }}
                        </h2>

                        <div class="space-y-12">
                            <!-- Profil Perusahaan Section -->
                            <div>
                                <h3 class="text-[10px] font-black text-brand-cyan uppercase tracking-[0.4em] mb-8">{{ __('Identity Records') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    @php
                                        $identityFields = [
                                            ['label' => __('Officer Name'), 'key' => 'nama'],
                                            ['label' => __('Protocol Email'), 'key' => 'email'],
                                            ['label' => __('Secure WhatsApp'), 'key' => 'whatsapp'],
                                            ['label' => __('Brand Designation'), 'key' => 'brand']
                                        ];
                                    @endphp

                                    @foreach($identityFields as $field)
                                        @if(isset($data[$field['key']]))
                                            <div class="bg-white/5 border border-white/5 p-6 rounded-2xl group hover:bg-white/[0.08] transition-all">
                                                <p class="text-[9px] text-slate-500 font-black uppercase tracking-widest mb-1">{{ $field['label'] }}</p>
                                                <p class="text-white font-bold tracking-tight">{{ $data[$field['key']] }}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Brief Logo Section -->
                            <div class="pt-12 border-t border-white/5">
                                <h3 class="text-[10px] font-black text-brand-violet uppercase tracking-[0.4em] mb-8">{{ __('Directives Manifest') }}</h3>
                                <div class="space-y-6">
                                    @php
                                        $briefFields = [
                                            ['label' => __('Operational Sector'), 'key' => 'jenis_usaha'],
                                            ['label' => __('Requirement Details'), 'key' => 'keterangan', 'full' => true],
                                            ['label' => __('Visual DNA References'), 'key' => 'referensi'],
                                            ['label' => __('Chromatic Map'), 'key' => 'warna']
                                        ];
                                    @endphp

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        @foreach($briefFields as $field)
                                            @if(isset($data[$field['key']]))
                                                <div class="{{ isset($field['full']) ? 'md:col-span-2' : '' }} bg-white/5 border border-white/5 p-6 rounded-2xl group hover:bg-white/[0.08] transition-all">
                                                    <p class="text-[9px] text-slate-500 font-black uppercase tracking-widest mb-1">{{ $field['label'] }}</p>
                                                    <p class="text-white font-bold tracking-tight whitespace-pre-wrap">{{ $data[$field['key']] }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ACTIONS SIDE --}}
                <div class="lg:col-span-4 space-y-8 reveal" style="transition-delay: 400ms;">
                    <div class="glass-card p-8 sticky top-32 overflow-hidden shadow-2xl">
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-brand-violet/5 blur-3xl rounded-full -ml-16 -mb-16"></div>
                        
                        <h3 class="text-sm font-black text-white uppercase tracking-[0.2em] mb-8 border-b border-white/5 pb-4 text-center">{{ __('Protocol Commit') }}</h3>
                        
                        <div class="space-y-6">
                             <form action="{{ route('payment.process') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-primary w-full !py-5 text-xs tracking-[0.2em] font-black uppercase shadow-brand-cyan/20 mb-4 transition-transform hover:scale-[1.02]">
                                    {{ __('Commit & Execute') }} →
                                </button>
                            </form>
                            
                            <a href="{{ route('brief.show', $paket ?? 'standard') }}" class="btn-secondary w-full !py-4 block text-center text-xs tracking-[0.2em] font-black uppercase transition-transform hover:scale-[1.02]">
                                {{ __('Re-calibrate Brief') }}
                            </a>
                        </div>

                        <div class="mt-8 p-6 rounded-2xl bg-white/5 border border-white/5">
                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-lg bg-brand-cyan/10 flex items-center justify-center text-brand-cyan text-xs">ℹ</div>
                                <p class="text-[9px] text-slate-500 font-bold leading-relaxed uppercase tracking-widest">
                                    {{ __('Execution will initiate the design synchronization cycle. Payment protocol required for security clearance.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.1 });
    reveals.forEach(r => observer.observe(r));
});
</script>
@endpush

@endsection
