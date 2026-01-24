@extends('layouts.main')

@section('content')

<main class="relative min-h-[80vh] py-20 overflow-hidden">
    <!-- Immersive Background Elements -->
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-brand-cyan/5 blur-[120px] rounded-full animate-blob-float"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-brand-violet/5 blur-[120px] rounded-full animate-blob-float" style="animation-delay: -5s;"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-6xl mx-auto">
            <div class="reveal mb-12">
                <div class="inline-flex px-4 py-1.5 rounded-full bg-brand-cyan/10 border border-brand-cyan/20 text-brand-cyan text-[10px] font-bold uppercase tracking-[0.3em] mb-6">
                    Operational Monitoring
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-white leading-tight uppercase tracking-tight">
                    Order <span class="animate-text-shimmer">Registry.</span>
                </h1>
                <p class="text-slate-500 mt-4 font-bold uppercase text-xs tracking-widest">Real-time status tracking for your creative investments.</p>
            </div>

            <div class="glass-card overflow-hidden shadow-2xl border-white/5 reveal" style="transition-delay: 100ms;">
                <div id="ordersTable" class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/[0.02] border-b border-white/5 uppercase tracking-[0.2em] text-[10px] font-black text-slate-500">
                                <th class="px-8 py-6">Protocol ID</th>
                                <th class="px-8 py-6">Investment</th>
                                <th class="px-8 py-6">Current Status</th>
                                <th class="px-8 py-6">Payment Link</th>
                                <th class="px-8 py-6">Last Sync</th>
                                <th class="px-8 py-6 text-right">Directives</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($orders as $o)
                            <tr class="group hover:bg-white/[0.03] transition-all duration-300" data-order-id="{{ $o->order_id }}">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 font-mono text-[10px] border border-white/10 group-hover:border-brand-cyan group-hover:text-brand-cyan transition-colors">
                                            #{{ $o->order_id }}
                                        </div>
                                        <span class="text-white font-bold tracking-tight">Active Protocol</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-white font-black">IDR {{ number_format($o->package->price ?? 0,0,',','.') }}</span>
                                </td>
                                <td class="px-8 py-6 text-xs font-black uppercase tracking-widest">
                                    <span class="order-status px-4 py-1.5 rounded-full border {{ $o->status == 'completed' ? 'bg-green-500/10 border-green-500/30 text-green-400' : ($o->status == 'submitted' ? 'bg-brand-cyan/10 border-brand-cyan/30 text-brand-cyan' : 'bg-white/5 border-white/10 text-slate-400') }}">
                                        {{ $o->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    @php $isPaid = $o->payments()->where('status', 'paid')->exists(); @endphp
                                    <span class="order-payment px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-dashed {{ $isPaid ? 'bg-green-500/10 border-green-500/30 text-green-400' : 'bg-red-500/10 border-red-500/30 text-red-500' }}">
                                        {{ $isPaid ? 'Settled' : 'Pending' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-[10px] text-slate-500 font-bold uppercase tracking-widest order-updated font-mono">
                                    {{ optional($o->updated_at)->diffForHumans() }}
                                </td>
                                <td class="px-8 py-6 text-right action-cell">
                                    <div class="flex items-center justify-end gap-3">
                                        {{-- Revision Button (Available for Paid or Completed Orders) --}}
                                        @if($isPaid || $o->status === 'completed' || $o->status === 'revision')
                                            <a href="{{ route('user.orders.revision.show', $o->order_id) }}" class="p-2 rounded-xl bg-purple-500/10 border border-purple-500/30 text-purple-400 hover:bg-purple-500 hover:text-white transition-all" title="Request Revision">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                        @endif

                                        <a href="{{ route('payment.show', $o->order_id) }}" class="p-2 rounded-xl bg-white/5 border border-white/10 text-slate-400 hover:text-brand-cyan hover:border-brand-cyan transition-all" title="View Details">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        
                                        @if($o->status === 'completed' && $o->finalFiles->count() > 0)
                                            @php $final = $o->finalFiles->last(); @endphp
                                            <a href="{{ asset('storage/' . $final->file_path) }}" class="p-2 rounded-xl bg-green-500/10 border border-green-500/30 text-green-400 hover:bg-green-500 hover:text-white transition-all final-download" title="Download Final Assets" download>
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            </a>
                                        @endif

                                        @if($o->status !== 'completed')
                                            <form method="POST" action="{{ route('user.orders.cancel', $o->order_id) }}" class="inline-block">
                                                @csrf
                                                <button type="submit" class="p-2 rounded-xl bg-red-500/10 border border-red-500/30 text-red-500 hover:bg-red-500 hover:text-white transition-all" title="Cancel Order" onclick="return confirm('Abort this protocol?')">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@push('scripts')
<script>
    // Polling logic with refactored aesthetics
    (function(){
        const endpoint = '{{ route('user.orders.updates') }}';
        async function fetchUpdates(){
            try {
                const res = await fetch(endpoint, { headers: { 'Accept': 'application/json' } });
                if (!res.ok) return;
                const json = await res.json();
                if (!json || !json.orders) return;

                json.orders.forEach(o => {
                    const row = document.querySelector('[data-order-id="'+o.id+'"]');
                    if (row) {
                        const statusEl = row.querySelector('.order-status');
                        const updatedEl = row.querySelector('.order-updated');
                        
                        if (statusEl && statusEl.textContent.trim().toLowerCase() !== (o.status||'').toLowerCase()) {
                            statusEl.textContent = o.status;
                            statusEl.className = 'order-status px-4 py-1.5 rounded-full border transition-all duration-500 ';
                            if (o.status === 'completed') statusEl.classList.add('bg-green-500/10', 'border-green-500/30', 'text-green-400');
                            else if (o.status === 'submitted') statusEl.classList.add('bg-brand-cyan/10', 'border-brand-cyan/30', 'text-brand-cyan');
                            else statusEl.classList.add('bg-white/5', 'border-white/10', 'text-slate-400');
                        }

                        if (updatedEl) updatedEl.textContent = new Date(o.updated_at).toLocaleString();

                        // Update payment badge
                        const payEl = row.querySelector('.order-payment');
                        if (payEl) {
                            payEl.textContent = o.payment_status || 'pending';
                            payEl.className = 'order-payment px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-dashed transition-all duration-500 ';
                            if (o.payment_status === 'success') payEl.classList.add('bg-green-500/10', 'border-green-500/30', 'text-green-400');
                            else payEl.classList.add('bg-red-500/10', 'border-red-500/30', 'text-red-500');
                        }
                    }
                });
            } catch (e) { /* silent */ }
        }
        setInterval(fetchUpdates, 5000);
    })();

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
