@extends('admin.layout')

@section('content')
<div class="reveal active max-w-2xl mx-auto space-y-10">
    {{-- HEADER --}}
    <div class="text-center">
        <h2 class="text-3xl font-black text-white tracking-tight uppercase leading-none">Entity <span class="animate-text-shimmer">Initialization</span></h2>
        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.4em] mt-4 italic">Protocol: Personnel Registration Alpha-7</p>
    </div>

    {{-- FORM CONSOLE --}}
    <div class="glass-card p-10 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-cyan/5 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
        
        @if($errors->any())
            <div class="mb-8 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-[10px] font-black text-red-400 uppercase tracking-widest leading-loose">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-6">
                <div class="group">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 block ml-1">Subject Identity</label>
                    <input name="name" type="text" placeholder="Full designation..." value="{{ old('name') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all placeholder:text-slate-600 font-medium">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 block ml-1">Comms Frequency (Email)</label>
                        <input name="email" type="email" placeholder="email@protocol.com" value="{{ old('email') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all placeholder:text-slate-600 font-medium font-mono">
                    </div>
                    <div class="group">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 block ml-1">Secure Line (Phone)</label>
                        <input name="no_hp" type="text" placeholder="+62..." value="{{ old('no_hp') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all placeholder:text-slate-600 font-medium font-mono">
                    </div>
                </div>

                <div class="group">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 block ml-1">Geographic Coordinates</label>
                    <textarea name="alamat" placeholder="Primary residence data..." class="w-full bg-white/5 border border-white/10 rounded-xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all placeholder:text-slate-600 font-medium h-24 resize-none">{{ old('alamat') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 block ml-1">Access Credentials</label>
                        <input name="password" type="password" placeholder="••••••••" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all placeholder:text-slate-600">
                    </div>
                    <div class="group">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 block ml-1">Confirm Matrix Key</label>
                        <input name="password_confirmation" type="password" placeholder="••••••••" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all placeholder:text-slate-600">
                    </div>
                </div>

                <div class="pt-6 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('admin.customers') }}" class="btn-secondary py-4 px-8 text-[10px] uppercase tracking-[0.2em] font-black flex-1 text-center">Abort Sequence</a>
                    <button type="submit" class="btn-primary py-4 px-8 text-[10px] uppercase tracking-[0.2em] font-black flex-1 shadow-lg shadow-brand-cyan/20">Commit Entry</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
