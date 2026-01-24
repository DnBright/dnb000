@extends('layouts.main')

@section('content')
<main class="relative min-h-[90vh] flex items-center justify-center px-6 py-20 overflow-hidden">
    
    <!-- Immersive Background Elements -->
    <div class="fixed inset-0 -z-20 bg-[#0b0f14]"></div>
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute top-[-20%] left-[-10%] w-[60%] h-[60%] bg-brand-cyan/20 blur-[150px] rounded-full animate-blob-float"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[60%] h-[60%] bg-brand-violet/20 blur-[150px] rounded-full animate-blob-float" style="animation-delay: -5s;"></div>
    </div>

    <div class="w-full max-w-6xl reveal">
        <div class="glass-card overflow-hidden flex flex-col md:flex-row shadow-2xl ring-1 ring-white/10">
            
            {{-- LEFT BRANDING --}}
            <div class="md:w-5/12 p-12 bg-gradient-to-br from-brand-charcoal via-brand-navy to-brand-charcoal relative overflow-hidden flex flex-col justify-between border-r border-white/5">
                <div class="absolute inset-0 bg-brand-cyan/5 opacity-40"></div>
                
                <div class="relative z-10">
                    <a href="/" class="flex items-center gap-3 mb-16 group">
                        <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center group-hover:bg-brand-cyan/10 group-hover:border-brand-cyan/30 transition-all duration-300">
                            <span class="text-2xl">✨</span>
                        </div>
                        <span class="text-xl font-bold tracking-tight text-white uppercase group-hover:text-brand-cyan transition-colors">Dark & Bright</span>
                    </a>

                    <div class="space-y-6">
                        <div class="inline-flex px-3 py-1 rounded-full bg-brand-cyan/10 border border-brand-cyan/20 text-brand-cyan text-[10px] font-bold uppercase tracking-widest">
                            Secure Access
                        </div>
                        <h2 class="text-4xl md:text-5xl font-extrabold leading-tight text-white">
                            Welcome Back <br> 
                            <span class="animate-text-shimmer">to Infinite.</span>
                        </h2>
                        <p class="text-slate-400 text-lg leading-relaxed max-w-sm">
                            Access your curated workspace and continue crafting digital excellence.
                        </p>
                    </div>
                </div>

                <div class="relative z-10 mt-12">
                    <div class="glass-card p-6 border-white/10 bg-white/[0.02]">
                        <p class="text-slate-300 italic text-sm mb-4 leading-relaxed">
                            "The best way to predict the future is to design it with clarity and contrast."
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-brand-cyan/20 flex items-center justify-center text-xs text-brand-cyan font-bold">DT</div>
                            <span class="text-xs font-bold text-white uppercase tracking-widest">Design Team</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT FORM --}}
            <div class="md:w-7/12 p-12 lg:p-16 flex flex-col justify-center">
                <div class="max-w-md mx-auto w-full">
                    <h2 class="text-3xl font-extrabold text-white mb-2">Member Login</h2>
                    <p class="text-slate-400 mb-10">Sign in to your premium dashboard</p>

                    @if(session('error'))
                        <div class="mb-8 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm flex items-center gap-3 reveal-card">
                            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    <form class="space-y-7" method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500 ml-1">Email Protocol</label>
                            <div class="relative group">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-brand-cyan transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </span>
                                <input type="email" name="email" required 
                                    class="w-full pl-12 pr-4 py-4 rounded-2xl bg-white/5 border border-white/10 outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/5 text-white transition-all" 
                                    placeholder="yourname@domain.com">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between items-end mb-1">
                                <label class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500 ml-1">Access Key</label>
                                <a href="#" class="text-[10px] font-bold uppercase tracking-widest text-brand-violet hover:text-brand-cyan transition-colors">Forgot Key?</a>
                            </div>
                            <div class="relative group">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-brand-cyan transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </span>
                                <input type="password" name="password" required 
                                    class="w-full pl-12 pr-4 py-4 rounded-2xl bg-white/5 border border-white/10 outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/5 text-white transition-all" 
                                    placeholder="••••••••••••">
                            </div>
                        </div>

                        <button class="btn-primary w-full py-4 text-sm mt-4">
                            Establish Connection
                        </button>
                    </form>

                    <div class="mt-12 text-center">
                        <p class="text-sm text-slate-500">
                            New to the future? 
                            <a href="{{ route('register') }}" class="text-brand-cyan font-bold hover:underline underline-offset-4 ml-1">
                                Join the Collective
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-10">
            <p class="text-[10px] uppercase tracking-[0.5em] text-slate-600">
                &copy; {{ date('Y') }} Dark and Bright Archive. All systems operational.
            </p>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const reveal = document.querySelector('.reveal');
    if (reveal) {
        setTimeout(() => reveal.classList.add('active'), 100);
    }
});
</script>
@endsection
