@extends('admin.layout')

@section('content')
<div class="reveal active space-y-10">
    {{-- HEADER & SEARCH --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight uppercase leading-none">Personnel <span class="animate-text-shimmer">Matrix</span></h2>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.4em] mt-3">
                Total Synchronized Entities: <span class="text-brand-cyan">{{ $users->total() }}</span>
            </p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-4">
            <form method="GET" action="{{ route('admin.customers') }}" class="relative group w-full sm:w-auto">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Scan by name or email..." class="w-full sm:w-80 bg-white/5 border border-white/10 rounded-xl py-3 px-5 text-xs text-white placeholder:text-slate-600 focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all font-medium">
                <button class="absolute right-2 top-2 h-8 px-4 bg-brand-cyan rounded-lg text-black text-[9px] font-black uppercase tracking-widest hover:scale-105 active:scale-95 transition-all">Search</button>
            </form>

            <a href="{{ route('admin.customers.create') }}" class="btn-primary py-3 px-8 text-[10px] uppercase tracking-[0.2em] font-black w-full sm:w-auto text-center">Deploy New Entity</a>
        </div>
    </div>

    {{-- CUSTOMER DATA CONSOLE --}}
    <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black text-slate-600 uppercase tracking-widest border-b border-white/5 bg-white/[0.01]">
                        <th class="px-8 py-6">Intelligence Profile</th>
                        <th class="px-8 py-6">Comms ID</th>
                        <th class="px-8 py-6">Initialization</th>
                        <th class="px-8 py-6 text-right">Directives</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($users as $user)
                    <tr class="group hover:bg-white/[0.03] transition-all duration-300">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-cyan/10 to-brand-violet/10 border border-white/10 flex items-center justify-center font-black text-lg text-white group-hover:border-brand-cyan/40 transition-all shadow-xl">
                                    {{ strtoupper(substr($user->name, 0, 1) ?? 'U') }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-white group-hover:text-brand-cyan transition-colors">{{ $user->name }}</div>
                                    <div class="text-[9px] text-slate-600 font-bold uppercase tracking-widest mt-1">{{ $user->nama ?? 'Anonymous Entity' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-medium text-slate-400 font-mono tracking-tighter group-hover:text-white transition-colors">{{ $user->email }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-bold text-slate-500 font-mono">{{ optional($user->created_at)->format('Y.m.d') }}</span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all transform translate-x-4 group-hover:translate-x-0">
                                <a href="{{ route('admin.customers.edit', $user) }}" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-brand-cyan hover:border-brand-cyan hover:bg-brand-cyan/10 transition-all shadow-lg">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z"/></svg>
                                </a>
                                <form action="{{ route('admin.customers.destroy', $user) }}" method="POST" class="js-delete-customer" data-name="{{ $user->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-red-500 hover:border-red-500 hover:bg-red-500/10 transition-all shadow-lg">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-24 text-center">
                            <div class="text-[10px] text-slate-700 font-black uppercase tracking-[0.5em] mb-4">No Matrix Entities Found</div>
                            <div class="w-1 h-12 bg-white/5 rounded-full mx-auto animate-pulse"></div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION CONSOLE --}}
        <div class="px-8 py-8 border-t border-white/5 bg-white/[0.01] flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="text-[9px] font-black text-slate-600 uppercase tracking-widest">
                Displaying <span class="text-white">{{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }}</span> // Total Pool <span class="text-brand-cyan">{{ $users->total() }}</span>
            </div>
            <div class="dark-pagination">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
