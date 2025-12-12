@extends('admin.layout')

@section('content')
<div class="grid grid-cols-12 gap-6">
  {{-- LEFT: main content (col 9) --}}
  <div class="col-span-12 lg:col-span-9 space-y-6">
    {{-- stat cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
      <div class="p-4 bg-white rounded-xl shadow">
        <p class="text-xs text-gray-500">Total Earnings</p>
        <div class="flex items-end justify-between">
          <h3 class="text-2xl font-bold">${{ number_format($totalEarnings,2) }}</h3>
          <span class="text-sm text-green-600 bg-green-50 px-2 py-1 rounded">↑ 12.5%</span>
        </div>
      </div>

      <div class="p-4 bg-white rounded-xl shadow">
        <p class="text-xs text-gray-500">Active Orders</p>
        <h3 class="text-2xl font-bold">{{ $activeOrders }}</h3>
      </div>

      <div class="p-4 bg-white rounded-xl shadow">
        <p class="text-xs text-gray-500">Impressions</p>
        <h3 class="text-2xl font-bold">{{ number_format($impressions) }}</h3>
      </div>

      <div class="p-4 rounded-xl" style="background:linear-gradient(135deg,#4F46E5,#3B82F6);color:white">
        <p class="text-xs opacity-80">Overall Rating</p>
        <h3 class="text-2xl font-bold">{{ $rating }}</h3>
        <div class="mt-2">★★★★★</div>
      </div>
    </div>

    {{-- revenue chart --}}
    <div class="bg-white p-6 rounded-xl shadow">
      <div class="flex justify-between items-start mb-4">
        <h4 class="font-semibold">Revenue Analytics</h4>
        <button class="text-sm px-3 py-1 bg-gray-100 rounded">Last 6 Months</button>
      </div>
      <canvas id="revenueChart" class="w-full h-64"></canvas>
    </div>

    {{-- recent orders table --}}
    <div class="bg-white p-6 rounded-xl shadow">
      <div class="flex justify-between items-center mb-4">
        <h4 class="font-semibold">Recent Orders</h4>
        <div class="flex gap-2">
          <button class="px-3 py-2 bg-gray-100 rounded">Filter</button>
          <button class="px-3 py-2 bg-indigo-600 text-white rounded">Export</button>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="text-gray-500">
            <tr>
              <th class="p-3 text-left">Order ID</th>
              <th class="p-3 text-left">Client</th>
              <th class="p-3 text-left">Service</th>
              <th class="p-3 text-left">Deadline</th>
              <th class="p-3 text-left">Status</th>
              <th class="p-3 text-right">Amount</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentOrders as $o)
            <tr class="border-t">
              <td class="p-3">#ORD-{{ $o->id }}</td>
              <td class="p-3">{{ $o->client_name ?? $o->user->name ?? '—' }}</td>
              <td class="p-3">{{ $o->service_name ?? 'Service' }}</td>
              <td class="p-3">{{ optional($o->deadline)->format('M d, Y') ?? '—' }}</td>
              <td class="p-3">
                <span class="px-2 py-1 rounded text-xs {{ $o->status == 'completed' ? 'bg-green-100 text-green-600' : ($o->status == 'in_progress' ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-600') }}">
                  {{ ucfirst($o->status) }}
                </span>
              </td>
              <td class="p-3 text-right">${{ number_format($o->amount,2) }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="p-6 text-center text-gray-500">No orders</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- RIGHT: side column (col 3) --}}
  <div class="col-span-12 lg:col-span-3 space-y-6">
    {{-- top performing gigs card --}}
    <div class="bg-white p-6 rounded-xl shadow">
      <h4 class="font-semibold mb-3">Top Performing Gigs</h4>
      <div class="space-y-3">
        @foreach($topServices as $s)
          <div class="flex items-center justify-between">
            <div>
              <div class="font-medium">{{ Str::limit($s['title'],26) }}</div>
              <div class="text-xs text-gray-500">{{ $s['sales'] }} Sales • ${{ number_format($s['revenue']) }}</div>
            </div>
            <div class="text-sm {{ $s['change'] > 0 ? 'text-green-600' : ($s['change'] < 0 ? 'text-red-600' :'text-gray-500') }}">
              {{ $s['change'] > 0 ? '+' : '' }}{{ $s['change'] }}%
            </div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- overall rating card --}}
    <div class="p-6 rounded-xl shadow text-white" style="background:linear-gradient(135deg,#4F46E5,#3B82F6)">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-sm opacity-90">Overall Rating</div>
          <div class="text-2xl font-bold">{{ $rating }}</div>
        </div>
        <div class="text-xs bg-white/20 px-3 py-2 rounded">Level 2 Seller</div>
      </div>
      <div class="mt-4 text-sm">4.9 ★★★★★</div>
    </div>
  </div>
</div>

{{-- Chart JS init --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('revenueChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: @json($months),
      datasets: [{
        label: 'Revenue',
        data: @json($revenues),
        fill: true,
        backgroundColor: 'rgba(59,130,246,0.08)',
        borderColor: '#3B82F6',
        tension: 0.35,
        pointRadius:4,
        pointBackgroundColor:'#fff',
        pointBorderColor:'#3B82F6'
      }]
    },
    options: {
      plugins:{legend:{display:false}},
      scales:{y:{beginAtZero:true}}
    }
  });
</script>
@endpush
@endsection

