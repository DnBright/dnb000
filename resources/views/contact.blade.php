@extends('layouts.main')

@section('content')

<main class="relative min-h-[80vh] flex items-center justify-center py-20 overflow-hidden">
    <!-- Immersive Background Elements -->
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute top-[20%] right-[-10%] w-[50%] h-[50%] bg-brand-cyan/10 blur-[120px] rounded-full animate-blob-float"></div>
        <div class="absolute bottom-[10%] left-[-10%] w-[50%] h-[50%] bg-brand-violet/10 blur-[120px] rounded-full animate-blob-float" style="animation-delay: -8s;"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-5xl mx-auto">
            <div class="grid lg:grid-cols-12 gap-12 items-start">
                
                {{-- INFO SIDE --}}
                <div class="lg:col-span-5 reveal">
                    <div class="inline-flex px-4 py-1.5 rounded-full bg-brand-cyan/10 border border-brand-cyan/20 text-brand-cyan text-[10px] font-bold uppercase tracking-[0.3em] mb-8">
                        {{ __('Secure Connection') }}
                    </div>
                    <h1 class="text-5xl font-black text-white leading-tight mb-8">
                        {{ __('Establish') }} <br>
                        <span class="animate-text-shimmer">{{ __('Protocol.') }}</span>
                    </h1>
                    <p class="text-slate-400 text-lg leading-relaxed mb-12">
                        {{ __('Ready to elevate your visual identity? Initiate a transmission through our secure channel. Our creative divisions are standing by.') }}
                    </p>

                    <div class="space-y-6">
                        <div class="glass-card p-6 flex items-center gap-6 group hover:bg-white/[0.08] transition-all cursor-default">
                            <div class="w-12 h-12 rounded-2xl bg-brand-cyan/10 border border-brand-cyan/20 flex items-center justify-center text-brand-cyan group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">{{ __('Comms Email') }}</h4>
                                <p class="text-white font-bold tracking-tight">kontak@grafisatu.com</p>
                            </div>
                        </div>

                        <div class="glass-card p-6 flex items-center gap-6 group hover:bg-white/[0.08] transition-all cursor-default">
                            <div class="w-12 h-12 rounded-2xl bg-brand-violet/10 border border-brand-violet/20 flex items-center justify-center text-brand-violet group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">{{ __('Secure WhatsApp') }}</h4>
                                <p class="text-white font-bold tracking-tight">+62 812 3456 7890</p>
                            </div>
                        </div>

                        <div class="glass-card p-6 flex items-center gap-6 group hover:bg-white/[0.08] transition-all cursor-default">
                            <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">{{ __('Active Window') }}</h4>
                                <p class="text-white font-bold tracking-tight text-sm uppercase">{{ __('Mon–Fri : 09.00 – 17.00') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FORM SIDE --}}
                <div class="lg:col-span-7 reveal" style="transition-delay: 200ms;">
                    <div class="glass-card p-8 lg:p-12 shadow-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-cyan/5 blur-3xl rounded-full -mr-32 -mt-32"></div>
                        
                        <form action="#" method="POST" class="relative z-10 space-y-8">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-1">{{ __('Identity Name') }}</label>
                                    <input type="text"
                                        class="w-full px-6 py-4 rounded-2xl bg-white/5 border border-white/10 text-white focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan/20 outline-none transition-all placeholder:text-slate-600"
                                        placeholder="{{ __('Full Name / Brand') }}" required>
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-1">{{ __('Protocol Email') }}</label>
                                    <input type="email"
                                        class="w-full px-6 py-4 rounded-2xl bg-white/5 border border-white/10 text-white focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan/20 outline-none transition-all placeholder:text-slate-600"
                                        placeholder="your@nexus.com" required>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-1">{{ __('Comms Channel (WhatsApp)') }}</label>
                                <input type="text"
                                    class="w-full px-6 py-4 rounded-2xl bg-white/5 border border-white/10 text-white focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan/20 outline-none transition-all placeholder:text-slate-600"
                                    placeholder="+62 812..." required>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-1">{{ __('Manifest Details') }}</label>
                                <textarea rows="5"
                                    class="w-full px-6 py-4 rounded-2xl bg-white/5 border border-white/10 text-white focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan/20 outline-none transition-all placeholder:text-slate-600 resize-none"
                                    placeholder="{{ __('Describe your vision / project brief...') }}" required></textarea>
                            </div>

                            <button class="btn-primary w-full py-5 text-xl tracking-[0.1em]">
                                {{ __('Sync Transmission') }}
                            </button>
                        </form>
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
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });
    reveals.forEach(r => observer.observe(r));
});
</script>
@endpush

@endsection
