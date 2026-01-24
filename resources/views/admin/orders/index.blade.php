@extends('admin.layout')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-semibold mb-1">Order</h1>
    <p class="text-gray-500 mb-6">{{ count($orders) }} orders found</p>

    <!-- Filter Tabs -->
    <div class="flex gap-6 border-b mb-6 text-gray-600">
        <button class="pb-2 border-b-2 border-blue-500 text-blue-500 font-medium">All orders</button>
        <button class="pb-2 hover:text-blue-500">Dispatch</button>
        <button class="pb-2 hover:text-blue-500">Pending</button>
        <button class="pb-2 hover:text-blue-500">Completed</button>
    </div>

    <!-- Header -->
    <div class="flex justify-between mb-4">
        <div></div>
        <div class="flex gap-3 items-center">
            <input type="date" class="border rounded-lg p-2">
            <span class="text-gray-500">To</span>
            <input type="date" class="border rounded-lg p-2">
        </div>
    </div>

    <!-- TABLE -->
    <div class="overflow-hidden rounded-xl shadow bg-white">
        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4">Id</th>
                    <th class="p-4">Name</th>
                    <th class="p-4">Address</th>
                    <th class="p-4">Date</th>
                    <th class="p-4">Price</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($orders as $order)
                <tr class="border-b hover:bg-blue-50 transition">
                    <td class="p-4 font-medium">#{{ $order->order_id }}</td>

                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $order->avatar }}" class="w-8 h-8 rounded-full">
                            <span>{{ $order->name }}</span>
                        </div>
                    </td>

                    <td class="p-4">{{ $order->address }}</td>

                    <td class="p-4">{{ $order->date }}</td>

                    <td class="p-4">Rp {{ number_format($order->price, 0, ',', '.') }}</td>

                    <td class="p-4">
                        @if($order->status === 'Pending')
                            <span class="text-red-500">● Pending</span>
                        @elseif($order->status === 'Dispatch')
                            <span class="text-green-500">● Dispatch</span>
                        @else
                            <span class="text-gray-500">● Completed</span>
                        @endif
                    </td>

                    <td class="p-4">
                        <button class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200">⚙</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-end mt-4">
        <div class="flex gap-2">
            @for ($i = 1; $i <= 5; $i++)
                <button class="px-3 py-1 border rounded {{ $i == 1 ? 'bg-blue-500 text-white' : '' }}">
                    {{ $i }}
                </button>
            @endfor
        </div>
    </div>

</div>
@endsection
