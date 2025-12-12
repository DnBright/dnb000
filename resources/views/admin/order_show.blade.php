@extends('admin.layout')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">
  <div class="flex items-center justify-between mb-4">
    <div>
      <h2 class="text-2xl font-semibold">Order #{{ $order->id }}</h2>
      <p class="text-sm text-gray-500">{{ ucfirst($order->status ?? '—') }} • {{ optional($order->created_at)->format('d M Y H:i') }}</p>
    </div>
    <div>
      <a href="{{ route('admin.orders') }}" class="px-4 py-2 bg-gray-100 rounded">Back to Orders</a>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <h3 class="text-sm text-gray-500">Customer</h3>
      <p class="font-medium">{{ $order->customer_name ?? $order->name ?? '—' }}</p>
      <p class="text-sm text-gray-500">{{ $order->address }}</p>
    </div>
    <div>
      <h3 class="text-sm text-gray-500">Amount</h3>
      <p class="font-medium">${{ number_format($order->amount ?? $order->price ?? 0, 2) }}</p>
    </div>
  </div>

  <div class="mt-6">
    <h4 class="text-sm text-gray-500">Notes</h4>
    <p class="mt-2 text-sm text-gray-700">{{ $order->notes ?? '—' }}</p>
  </div>
</div>
@endsection
