@extends('admin.layout')

@section('content')
<div class="space-y-10 reveal active">

    {{-- STATS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Earnings --}}
        <div class="glass-card p-6 group hover:border-brand-cyan/30 transition-all duration-500">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-brand-cyan/10 flex items-center justify-center text-brand-cyan">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zM12 8V7m0 1v1m0 8v1m0-1v-1m-5-5H6m1-1h1m8 1h1m-1-1h-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="px-2 py-1 rounded-lg bg-emerald-500/10 text-emerald-500 text-[10px] font-black uppercase">↑ 12.5%</div>
            </div>
            <div class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-1">{{ __('Total Revenue') }}</div>
            <div class="text-2xl font-black text-white tracking-tight">Rp {{ number_format($totalEarnings ?? 0,0,',','.') }}</div>
        </div>

        {{-- Active Orders --}}
        <div class="glass-card p-6 group hover:border-brand-violet/30 transition-all duration-500">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-brand-violet/10 flex items-center justify-center text-brand-violet">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6"/></svg>
                </div>
                <div class="px-2 py-1 rounded-lg bg-brand-violet/10 text-brand-violet text-[10px] font-black uppercase">Live Ops</div>
            </div>
            <div class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-1">{{ __('Active Protocols') }}</div>
            <div class="text-2xl font-black text-white tracking-tight">{{ $activeOrders ?? 0 }}</div>
        </div>

        {{-- Impressions --}}
        <div class="glass-card p-6 group hover:border-brand-cyan/30 transition-all duration-500">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-brand-cyan/10 flex items-center justify-center text-brand-cyan">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
            </div>
            <div class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-1">{{ __('Global Visibility') }}</div>
            <div class="text-2xl font-black text-white tracking-tight">{{ number_format($impressions ?? 0) }}</div>
        </div>

        {{-- Rating --}}
        <div class="glass-card p-6 bg-gradient-to-br from-brand-cyan/5 to-brand-violet/5 group hover:border-white/20 transition-all duration-500">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-yellow-500 shadow-lg shadow-yellow-500/10">⭐</div>
                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Level 2 Elite</div>
            </div>
            <div class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-1">{{ __('Trust Compliance') }}</div>
            <div class="text-2xl font-black text-white tracking-tight">{{ $rating ?? '0.0' }}</div>
        </div>
    </div>

    {{-- ANALYTICS GRID --}}
    <div class="grid grid-cols-12 gap-8">
        {{-- Revenue Chart --}}
        <div class="col-span-12 lg:col-span-8 space-y-8">
            <div class="glass-card p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-widest">{{ __('Revenue Growth') }}</h3>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">{{ __('Periodic Fiscal Performance') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <select id="revenueMonthFilter" class="bg-[#0b0f14] border border-white/10 text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-xl focus:ring-1 focus:ring-brand-cyan outline-none appearance-none cursor-pointer">
                            <option value="">All Months</option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}">{{ date('M', mktime(0, 0, 0, $m, 1)) }}</option>
                            @endforeach
                        </select>
                        <select id="revenueYearFilter" class="bg-[#0b0f14] border border-white/10 text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-xl focus:ring-1 focus:ring-brand-cyan outline-none appearance-none cursor-pointer">
                            @foreach(range(date('Y'), 2024) as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="h-80 w-full">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="glass-card p-8">
                    <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6">{{ __('Service Distribution') }}</h3>
                    <div class="h-64">
                        <canvas id="serviceChart"></canvas>
                    </div>
                </div>
                <div class="glass-card p-8">
                    <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6">{{ __('Order Volume') }}</h3>
                    <div class="h-64">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Recent Orders Table --}}
            <div class="glass-card overflow-hidden">
                <div class="p-8 border-b border-white/5 flex justify-between items-center bg-white/[0.02]">
                    <div>
                        <h3 class="text-[10px] font-black text-white uppercase tracking-[0.3em]">{{ __('Latest Transactions') }}</h3>
                    </div>
                    <a href="{{ route('admin.orders') }}" class="text-[10px] font-black text-brand-cyan uppercase tracking-widest hover:underline">{{ __('Full Protocol Log') }} →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black text-slate-600 uppercase tracking-widest border-b border-white/5">
                                <th class="px-8 py-5">{{ __('Protocol ID') }}</th>
                                <th class="px-8 py-5">{{ __('Client Identity') }}</th>
                                <th class="px-8 py-5">{{ __('Directive') }}</th>
                                <th class="px-8 py-5">{{ __('Status') }}</th>
                                <th class="px-8 py-5 text-right">{{ __('Value') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($recentOrders as $o)
                            <tr class="group hover:bg-white/[0.03] transition-colors">
                                <td class="px-8 py-6 text-xs font-black text-slate-400 group-hover:text-brand-cyan transition-colors">#ORD-{{ $o->order_id }}</td>
                                <td class="px-8 py-6">
                                    <div class="text-xs font-bold text-white">{{ $o->customer->name ?? 'Unknown Identity' }}</div>
                                    <div class="text-[10px] text-slate-600 mt-1 uppercase">{{ $o->customer->email ?? '' }}</div>
                                </td>
                                <td class="px-8 py-6 text-xs font-medium text-slate-400">{{ $o->package->name ?? 'Generic Protocol' }}</td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $o->status == 'completed' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : ($o->status == 'submitted' ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20' : 'bg-slate-500/10 text-slate-400 border border-slate-500/20') }}">
                                        {{ $o->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right text-xs font-black text-white">Rp {{ number_format($o->package->price ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-8 py-12 text-center text-xs text-slate-600 italic uppercase tracking-widest">{{ __('No transaction signals recorded') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Side Column --}}
        <div class="col-span-12 lg:col-span-4 space-y-8">
            {{-- Performance Metrics --}}
            <div class="glass-card p-8">
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-8">{{ __('Performance DNA') }}</h3>
                <div class="space-y-8">
                    @foreach($topServices as $s)
                    <div class="relative group">
                        <div class="flex justify-between items-end mb-2">
                            <div>
                                <div class="text-xs font-black text-white uppercase tracking-tight">{{ Str::limit($s['title'], 24) }}</div>
                                <div class="text-[9px] text-slate-600 font-bold uppercase mt-1">{{ $s['sales'] }} {{ __('Nodes Processed') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs font-black {{ $s['change'] >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                                    {{ $s['change'] >= 0 ? '+' : '' }}{{ $s['change'] }}%
                                </div>
                            </div>
                        </div>
                        <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-brand-cyan to-brand-violet rounded-full transition-all duration-1000" style="width: {{ min(100, ($s['sales'] / 50) * 100) }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Traffic DNA --}}
            <div class="glass-card p-8">
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-8">{{ __('Traffic Origins') }}</h3>
                <div class="h-64">
                    <canvas id="trafficChart"></canvas>
                </div>
            </div>

            {{-- Elite Level Card --}}
            <div class="glass-card p-8 bg-gradient-to-br from-brand-violet/10 to-brand-cyan/10 border-brand-violet/20">
                <div class="flex items-center gap-6 mb-8">
                    <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white text-3xl font-black shadow-2xl">D</div>
                    <div>
                        <div class="text-xl font-black text-white tracking-tight leading-none uppercase">Authorized</div>
                        <div class="text-[10px] text-brand-cyan font-bold uppercase tracking-[0.2em] mt-2 italic">Refining Visual Protocols</div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest text-slate-500">
                        <span>{{ __('Success Rate') }}</span>
                        <span class="text-white">98.4%</span>
                    </div>
                    <div class="h-1 w-full bg-white/5 rounded-full">
                        <div class="h-full bg-brand-cyan rounded-full shadow-[0_0_10px_rgba(6,246,255,0.5)]" style="width: 98.4%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CHART ASSETS --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Chart.defaults.color = '#475569';
        Chart.defaults.font.family = 'Outfit';
        Chart.defaults.font.weight = 'bold';

        const createGradient = (ctx, color) => {
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, `${color}33`);
            gradient.addColorStop(1, `${color}00`);
            return gradient;
        };

        // Revenue Chart
        let revenueChart;
        const initRevenueChart = (labels, data) => {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            if (revenueChart) revenueChart.destroy();
            
            revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Fiscal Pulse',
                        data: data,
                        fill: true,
                        backgroundColor: createGradient(ctx, '#06f6ff'),
                        borderColor: '#06f6ff',
                        borderWidth: 3,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#06f6ff',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: 'rgba(255,255,255,0.03)' },
                            ticks: { font: { size: 9 }, color: '#64748b' }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { font: { size: 9 }, color: '#64748b' }
                        }
                    }
                }
            });
        };

        try {
            // Initial load
            initRevenueChart(@json($months), @json($revenues));

            // Filter listeners
            const updateChart = () => {
                const year = document.getElementById('revenueYearFilter').value;
                const month = document.getElementById('revenueMonthFilter').value;
                
                // Disable controls
                document.getElementById('revenueYearFilter').disabled = true;
                document.getElementById('revenueMonthFilter').disabled = true;
                
                fetch(`{{ route('admin.dashboard.chart_data') }}?year=${year}&month=${month}`)
                    .then(response => response.json())
                    .then(data => {
                        initRevenueChart(data.labels, data.data);
                        document.getElementById('revenueYearFilter').disabled = false;
                        document.getElementById('revenueMonthFilter').disabled = false;
                    })
                    .catch(err => {
                        console.error(err);
                        document.getElementById('revenueYearFilter').disabled = false;
                        document.getElementById('revenueMonthFilter').disabled = false;
                    });
            };

            document.getElementById('revenueYearFilter').addEventListener('change', updateChart);
            document.getElementById('revenueMonthFilter').addEventListener('change', updateChart);
        } catch(e) {}

        // Service Chart
        try {
            new Chart(document.getElementById('serviceChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($serviceLabels ?? []),
                    datasets: [{
                        data: @json($serviceRevenues ?? []),
                        backgroundColor: ['#06f6ff', '#8b5cf6', '#00e5ff', '#64748b'],
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { display: false },
                        x: { 
                            grid: { display: false },
                            ticks: { font: { size: 9 } }
                        }
                    }
                }
            });
        } catch(e) {}

        // Orders Chart
        try {
            new Chart(document.getElementById('ordersChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: @json($months),
                    datasets: [{
                        data: @json($ordersCounts ?? []),
                        borderColor: '#8b5cf6',
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 2,
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { display: false },
                        x: { 
                            grid: { display: false },
                            ticks: { font: { size: 9 } }
                        }
                    }
                }
            });
        } catch(e) {}

        // Traffic Donut
        try {
            new Chart(document.getElementById('trafficChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: @json($trafficLabels ?? []),
                    datasets: [{ 
                        data: @json($trafficCounts ?? []), 
                        backgroundColor: ['#06f6ff', '#8b5cf6', '#475569', '#1e293b'],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: { 
                        legend: { 
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: { size: 9 },
                                usePointStyle: true,
                                boxWidth: 6
                            }
                        } 
                    }
                }
            });
        } catch(e) {}
    });
</script>
@endpush
@endsection

