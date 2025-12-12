@extends('admin.layout')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">
  <div class="flex items-center justify-between mb-4">
    <div>
      <h2 class="text-2xl font-semibold">Orders</h2>
      <p class="text-sm text-gray-500">{{ $orders->count() ?? count($orders) }} orders found</p>
    </div>
    <div>
      <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded">New Order</a>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="text-gray-500">
        <tr>
          <th class="p-3 text-left">Id</th>
          <th class="p-3 text-left">Name</th>
          <th class="p-3 text-left">Address</th>
          <th class="p-3 text-left">Date</th>
          <th class="p-3 text-left">Price</th>
          <th class="p-3 text-left">Status</th>
          <th class="p-3 text-right">Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $o)
        <tr class="border-t">
          <td class="p-3">#{{ $o->id }}</td>
          <td class="p-3 flex items-center">
            <div class="w-9 h-9 rounded-full overflow-hidden mr-3 bg-gray-100">
              <img src="{{ $o->avatar ?? asset('default-avatar.png') }}" alt="" class="w-full h-full object-cover">
            </div>
            {{ $o->customer_name ?? $o->name ?? '—' }}
          </td>
          <td class="p-3">{{ $o->address }}</td>
          <td class="p-3">{{ optional($o->created_at)->format('d M Y') }}</td>
          <td class="p-3">${{ number_format($o->amount ?? $o->price ?? 0,2) }}</td>
          <td class="p-3">
            <span class="px-2 py-1 rounded text-xs {{ $o->status == 'completed' ? 'bg-green-100 text-green-600' : ($o->status == 'pending' ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-600') }}">
              {{ ucfirst($o->status ?? '—') }}
            </span>
          </td>
          <td class="p-3 text-right">
            <a href="{{ route('admin.orders.show', $o->id) }}" class="text-indigo-600 hover:underline">View</a>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="p-6 text-center text-gray-500">No orders</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    @if(is_object($orders) && method_exists($orders, 'links'))
      {{ $orders->links() }}
    @endif
  </div>
</div>

@endsection
