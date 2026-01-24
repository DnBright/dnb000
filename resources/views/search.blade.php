@extends('layouts.main')

@section('content')
<div class="py-12">
  <div class="container mx-auto px-6">
    <h1 class="text-3xl font-bold mb-4">{{ $c['intro_text'] ?? 'Pencarian Pelayanan' }}</h1>

    <div class="mb-6">
      <input type="text" placeholder="{{ $c['search_placeholder'] ?? 'Cari...' }}" class="w-full md:w-2/3 px-4 py-3 border rounded">
    </div>

    @php
      $items = [];
      if (!empty($c['featured_items']) && is_array($c['featured_items'])) {
        $items = $c['featured_items'];
      } else {
        foreach(explode(',', $c['featured_categories'] ?? '') as $cat) {
          $t = trim($cat);
          if ($t !== '') $items[] = ['title' => $t];
        }
      }
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @foreach($items as $it)
        <div class="rounded-2xl overflow-hidden shadow-lg bg-white">
          <div class="h-40 bg-gray-100">
            <img src="{{ $it['image'] ?? 'https://dummyimage.com/600x350/ddd/000&text=Gambar' }}" alt="{{ $it['title'] ?? '' }}" class="w-full h-full object-cover">
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold">{{ $it['title'] ?? '' }}</h3>
            <p class="opacity-80 mt-1">Deskripsi singkat untuk {{ $it['title'] ?? '' }}</p>
            <a href="#" class="mt-4 inline-block w-full text-center px-6 py-3 rounded-lg bg-blue-600 text-white">Pilih Layanan</a>
          </div>
        </div>
      @endforeach
    </div>

  </div>
</div>
@endsection
