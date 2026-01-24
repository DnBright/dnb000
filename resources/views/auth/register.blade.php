@extends('layouts.main')

@section('content')
<main class="relative min-h-[90vh] flex items-center justify-center px-6 py-20 overflow-hidden">
    
    <!-- Immersive Background Elements -->
    <div class="fixed inset-0 -z-20 bg-[#0b0f14]"></div>
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute top-[-20%] right-[-10%] w-[60%] h-[60%] bg-brand-cyan/20 blur-[150px] rounded-full animate-blob-float"></div>
        <div class="absolute bottom-[-20%] left-[-10%] w-[60%] h-[60%] bg-brand-violet/20 blur-[150px] rounded-full animate-blob-float" style="animation-delay: -5s;"></div>
    </div>

    <div class="w-full max-w-6xl reveal">
        <div class="glass-card overflow-hidden flex flex-col md:flex-row shadow-2xl ring-1 ring-white/10">
            
            {{-- LEFT SIDE: Visual Hook --}}
            <div class="md:w-5/12 p-12 bg-gradient-to-br from-brand-charcoal via-brand-navy to-brand-charcoal relative overflow-hidden flex flex-col justify-between border-r border-white/5 order-2 md:order-1">
                <div class="absolute inset-0 bg-brand-violet/5 opacity-40"></div>
                
                <div class="relative z-10">
                    <a href="/" class="flex items-center gap-3 mb-16 group">
                        <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center group-hover:bg-brand-violet/10 group-hover:border-brand-violet/30 transition-all duration-300">
                            <span class="text-2xl">⚡</span>
                        </div>
                        <span class="text-xl font-bold tracking-tight text-white uppercase group-hover:text-brand-violet transition-colors">Grafisatu</span>
                    </a>

                    <div class="space-y-6">
                        <div class="inline-flex px-3 py-1 rounded-full bg-brand-violet/10 border border-brand-violet/20 text-brand-violet text-[10px] font-bold uppercase tracking-widest">
                            Creative Collective
                        </div>
                        <h2 class="text-4xl md:text-5xl font-extrabold leading-tight text-white">
                            Join the <br> 
                            <span class="animate-text-shimmer">Future.</span>
                        </h2>
                        <p class="text-slate-400 text-lg leading-relaxed max-w-sm">
                            Connect with top-tier designers and bring your most ambitious projects to life.
                        </p>
                    </div>
                </div>

                <div class="relative z-10 mt-12 grid grid-cols-2 gap-4">
                    <div class="glass-card p-4 border-white/10 bg-white/[0.02] text-center">
                        <p class="text-2xl font-black text-white">10K+</p>
                        <p class="text-[10px] uppercase text-slate-500 font-bold tracking-wider">Members</p>
                    </div>
                    <div class="glass-card p-4 border-white/10 bg-white/[0.02] text-center">
                        <p class="text-2xl font-black text-white">4.9/5</p>
                        <p class="text-[10px] uppercase text-slate-500 font-bold tracking-wider">Rating</p>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDE: FORM --}}
            <div class="md:w-7/12 p-12 lg:p-16 flex flex-col justify-center order-1 md:order-2">
                <div class="max-w-xl mx-auto w-full">
                    <h2 class="text-3xl font-extrabold text-white mb-2">Create Account 🚀</h2>
                    <p class="text-slate-400 mb-10">Initiate your journey into digital excellence</p>

                    <form class="space-y-6" action="{{ route('register.submit') }}" method="POST">
                        @csrf

                        <div class="grid md:grid-cols-2 gap-6">
                            {{-- NAME --}}
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500 ml-1">Identity</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="w-full px-4 py-4 rounded-2xl bg-white/5 border border-white/10 outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/5 text-white transition-all text-sm"
                                    placeholder="Full Name">
                                @error('name')<div class="text-red-400 text-[10px] font-bold uppercase tracking-widest mt-1 ml-1">{{ $message }}</div>@enderror
                            </div>

                            {{-- PHONE --}}
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500 ml-1">Contact Protocol</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                    class="w-full px-4 py-4 rounded-2xl bg-white/5 border border-white/10 outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/5 text-white transition-all text-sm"
                                    placeholder="+62 8xx">
                                @error('no_hp')<div class="text-red-400 text-[10px] font-bold uppercase tracking-widest mt-1 ml-1">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- EMAIL --}}
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500 ml-1">Universal ID</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full px-4 py-4 rounded-2xl bg-white/5 border border-white/10 outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/5 text-white transition-all text-sm"
                                placeholder="name@domain.com">
                            @error('email')<div class="text-red-400 text-[10px] font-bold uppercase tracking-widest mt-1 ml-1">{{ $message }}</div>@enderror
                        </div>

                        {{-- ADDRESS --}}
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500 ml-1">Physical Location</label>
                            <textarea name="alamat" rows="2" 
                                class="w-full px-4 py-4 rounded-2xl bg-white/5 border border-white/10 outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/5 text-white transition-all text-sm resize-none" 
                                placeholder="Your coordinates...">{{ old('alamat') }}</textarea>
                            @error('alamat')<div class="text-red-400 text-[10px] font-bold uppercase tracking-widest mt-1 ml-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            {{-- PASSWORD --}}
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500 ml-1">Access Key</label>
                                <input type="password" name="password"
                                    class="w-full px-4 py-4 rounded-2xl bg-white/5 border border-white/10 outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/5 text-white transition-all text-sm"
                                    placeholder="••••••••">
                                @error('password')<div class="text-red-400 text-[10px] font-bold uppercase tracking-widest mt-1 ml-1">{{ $message }}</div>@enderror
                            </div>

                            {{-- CONFIRM PASSWORD --}}
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500 ml-1">Verify Key</label>
                                <input type="password" name="password_confirmation"
                                    class="w-full px-4 py-4 rounded-2xl bg-white/5 border border-white/10 outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/5 text-white transition-all text-sm"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <button class="btn-primary w-full py-4 text-sm mt-4">
                            Forge Account
                        </button>
                    </form>

                    <div class="mt-10 text-center">
                        <p class="text-sm text-slate-500">
                            Already part of the collective? 
                            <a href="/login" class="text-brand-cyan font-bold hover:underline underline-offset-4 ml-1">Return to Void</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-10">
            <p class="text-[10px] uppercase tracking-[0.5em] text-slate-600">
                &copy; {{ date('Y') }} Grafisatu Archive. Beyond visual limits.
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
