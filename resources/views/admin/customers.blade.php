@extends('admin.layout')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">
  <div class="flex items-center justify-between mb-4">
    <div>
      <h2 class="text-2xl font-semibold">Customers</h2>
      <p class="text-sm text-gray-500">Manage registered users from the registration form.</p>
    </div>
    <div>
      <a href="/register" class="px-4 py-2 bg-indigo-600 text-white rounded">New Customer</a>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="text-gray-500">
        <tr>
          <th class="p-3 text-left">ID</th>
          <th class="p-3 text-left">Name</th>
          <th class="p-3 text-left">Email</th>
          <th class="p-3 text-left">Registered</th>
          <th class="p-3 text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        <tr class="border-t">
          <td class="p-3">#{{ $user->id }}</td>
          <td class="p-3">{{ $user->name }}</td>
          <td class="p-3">{{ $user->email }}</td>
          <td class="p-3">{{ optional($user->created_at)->format('d M Y') }}</td>
          <td class="p-3 text-right">
            <a href="#" class="text-indigo-600 hover:underline">View</a>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="p-6 text-center text-gray-500">No customers found</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $users->links() }}
  </div>
</div>

@endsection
