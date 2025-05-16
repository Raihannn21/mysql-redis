@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">Daftar Produk</h1>
    <ul class="divide-y divide-gray-200">
        @forelse($products as $product)
            <li class="py-3 flex items-center space-x-4">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-md" />
                <div class="flex-grow">
                    <a href="{{ route('products.show', $product) }}" class="text-lg font-semibold text-blue-600 hover:underline">
                        {{ $product->name }}
                    </a>
                    <p class="text-green-700 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
            </li>
        @empty
            <li>Tidak ada produk.</li>
        @endforelse
    </ul>
</div>
@endsection
