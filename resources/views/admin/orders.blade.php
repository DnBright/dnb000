@extends('admin.layout')

@section('content')
<div class="reveal active">
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight uppercase leading-none">Protocol <span class="animate-text-shimmer">Registry</span></h2>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.4em] mt-3">
                @if(is_object($orders) && method_exists($orders, 'total'))
                    {{ $orders->total() }} Active Signals Detected
                @else
                    {{ $orders->count() ?? count($orders) }} Signals Synced
                @endif
            </p>
        </div>
        <div class="flex items-center gap-3">
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.orders.report') }}" method="GET" target="_blank" class="flex items-center gap-2">
                <select name="month" class="bg-[#0b0f14] border border-white/10 text-white text-[10px] font-bold uppercase tracking-widest px-3 py-2.5 rounded-xl focus:ring-1 focus:ring-brand-cyan outline-none appearance-none">
                    <option value="">Month</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                    @endforeach
                </select>
                <select name="year" class="bg-[#0b0f14] border border-white/10 text-white text-[10px] font-bold uppercase tracking-widest px-3 py-2.5 rounded-xl focus:ring-1 focus:ring-brand-cyan outline-none appearance-none">
                    <option value="">Year</option>
                    @foreach(range(date('Y'), 2024) as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-secondary py-2.5 px-6 text-[10px] uppercase tracking-[0.2em] font-black shadow-lg hover:bg-white/10">
                    <span class="hidden md:inline">Print Report</span>
                    <span class="md:hidden">Print</span>
                </button>
            </form>
            <a href="#" class="btn-primary py-2.5 px-8 text-[10px] uppercase tracking-[0.2em] font-black shadow-lg shadow-brand-cyan/20">Init New Entry</a>
        </div>
        </div>
    </div>

    {{-- TABLE CONSOLE --}}
    <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-slate-600 uppercase tracking-widest border-b border-white/5 bg-white/[0.01]">
                        <th class="px-8 py-5">ID</th>
                        <th class="px-8 py-5">Correspondent</th>
                        <th class="px-8 py-5">Date Logged</th>
                        <th class="px-8 py-5">Value</th>
                        <th class="px-8 py-5 text-center">Payment</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right">Directives</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($orders as $o)
                    <tr class="group hover:bg-white/[0.03] transition-all duration-300">
                        <td class="px-8 py-6 text-xs font-black text-slate-500 group-hover:text-brand-cyan transition-colors">#{{ $o->order_id }}</td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center overflow-hidden shadow-inner uppercase font-black text-[10px] text-slate-500">
                                    {{ substr($o->customer->name ?? '?', 0, 2) }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-white group-hover:text-brand-cyan transition-colors">{{ $o->customer->name ?? '—' }}</div>
                                    <div class="text-[9px] text-slate-600 font-bold uppercase tracking-widest mt-1">{{ Str::limit($o->customer->address ?? '', 30) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-xs font-medium text-slate-400 font-mono tracking-tighter">{{ optional($o->created_at)->format('d.m / Y') }}</td>
                        <td class="px-8 py-6 text-xs font-black text-white">Rp{{ number_format($o->package->price ?? 0, 0, ',', '.') }}</td>
                        <td class="px-8 py-6 text-center">
                            @php $isPaid = $o->payments()->where('status', 'paid')->exists(); @endphp
                            <div class="relative px-3 py-1.5 rounded-full border border-dashed transition-all duration-300 {{ $isPaid ? 'bg-green-500/10 border-green-500/30' : 'bg-red-500/10 border-red-500/30' }}">
                                <span class="text-[9px] font-black uppercase tracking-widest {{ $isPaid ? 'text-green-400' : 'text-red-500' }}">
                                    {{ $isPaid ? 'Settled' : 'Pending' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <form method="POST" action="{{ route('admin.orders.update_status', $o->order_id) }}" class="inline-block group/form">
                                @csrf
                                <div class="relative px-4 py-1.5 rounded-full border transition-all duration-300 {{ $o->status == 'completed' ? 'bg-green-500/10 border-green-500/30' : ($o->status == 'submitted' ? 'bg-brand-cyan/10 border-brand-cyan/30' : 'bg-white/5 border-white/10') }}">
                                    <select name="status" class="bg-transparent border-none text-[9px] font-black uppercase tracking-widest px-1 py-0 {{ $o->status == 'completed' ? 'text-green-400' : ($o->status == 'submitted' ? 'text-brand-cyan' : 'text-slate-400') }} focus:ring-0 transition-all cursor-pointer appearance-none" onchange="this.form.submit()">
                                        <option value="submitted" class="bg-[#0b0f14] text-brand-cyan" {{ $o->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                        <option value="in_progress" class="bg-[#0b0f14] text-slate-400" {{ $o->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="revision" class="bg-[#0b0f14] text-slate-400" {{ $o->status === 'revision' ? 'selected' : '' }}>Revision</option>
                                        <option value="completed" class="bg-[#0b0f14] text-green-400" {{ $o->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" class="bg-[#0b0f14] text-red-500" {{ $o->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </form>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('admin.orders.show', $o->order_id) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-slate-400 hover:text-white hover:bg-brand-cyan hover:border-brand-cyan transition-all shadow-xl group/btn">
                                <svg class="w-4 h-4 transition-transform group-hover/btn:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-8 py-20 text-center">
                            <div class="text-[10px] text-slate-600 font-black uppercase tracking-[0.5em] mb-2">No Active Signals Detected</div>
                            <div class="text-[10px] text-brand-cyan/40 font-bold uppercase tracking-widest animate-pulse">Scanning Archive...</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if(is_object($orders) && method_exists($orders, 'links'))
        <div class="px-8 py-6 bg-white/[0.01] border-t border-white/5">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
