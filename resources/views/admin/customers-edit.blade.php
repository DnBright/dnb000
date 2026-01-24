@extends('admin.layout')

@section('content')
<div class="reveal active max-w-2xl mx-auto space-y-10">
    {{-- HEADER --}}
    <div class="text-center">
        <h2 class="text-3xl font-black text-white tracking-tight uppercase leading-none">Core <span class="animate-text-shimmer">Modification</span></h2>
        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.4em] mt-4 italic">Personnel ID: <span class="text-brand-cyan">#{{ $user->user_id }}</span> // Intelligence Update</p>
    </div>

    {{-- FORM CONSOLE --}}
    <div class="glass-card p-10 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-violet/5 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
        
        @if($errors->any())
            <div class="mb-8 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-[10px] font-black text-red-400 uppercase tracking-widest leading-loose">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.customers.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div class="group">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 block ml-1">Designated Alias</label>
                    <input name="name" type="text" placeholder="Full designation..." value="{{ old('name', $user->name) }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all font-medium">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 block ml-1">Comms Frequency (Email)</label>
                        <input name="email" type="email" placeholder="email@protocol.com" value="{{ old('email', $user->email) }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all font-medium font-mono">
                    </div>
                    <div class="group">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 block ml-1">Secure Line (Phone)</label>
                        <input name="no_hp" type="text" placeholder="+62..." value="{{ old('no_hp', $user->no_hp) }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all font-medium font-mono">
                    </div>
                </div>

                <div class="group">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 block ml-1">Operation Base (Address)</label>
                    <textarea name="alamat" placeholder="Primary residence data..." class="w-full bg-white/5 border border-white/10 rounded-xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all font-medium h-24 resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 block ml-1">Override Matrix Key</label>
                        <input name="password" type="password" placeholder="Leave blank to keep current" class="w-full bg-white/5 border border-white/10 rounded-xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all placeholder:text-slate-600">
                    </div>
                    <div class="group">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 block ml-1">Confirm New Key</label>
                        <input name="password_confirmation" type="password" placeholder="Confirm override..." class="w-full bg-white/5 border border-white/10 rounded-xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all placeholder:text-slate-600">
                    </div>
                </div>

                <div class="pt-6 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('admin.customers') }}" class="btn-secondary py-4 px-8 text-[10px] uppercase tracking-[0.2em] font-black flex-1 text-center">Abort protocol</a>
                    <button type="submit" class="btn-primary py-4 px-8 text-[10px] uppercase tracking-[0.2em] font-black flex-1 shadow-lg shadow-brand-cyan/20">Commit Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
