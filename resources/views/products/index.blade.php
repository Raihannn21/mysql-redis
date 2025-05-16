@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-7xl">
    <h1 class="text-3xl font-extrabold text-center mb-12 text-gray-900 tracking-wide">Produk Premium Kami</h1>
    <div class="grid gap-6 md:grid-cols-4 sm:grid-cols-2 grid-cols-1">
        @foreach($products as $product)
        <div class="bg-gradient-to-tr from-white via-gray-100 to-gray-50 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col overflow-hidden border border-gray-200 hover:border-green-500">
            <div class="relative group">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-40 w-full object-cover rounded-t-xl transition-transform duration-300 group-hover:scale-105" />
            </div>
            <div class="p-4 flex flex-col flex-grow">
                <h2 class="text-xl font-serif font-bold text-gray-900 mb-2 tracking-tight">{{ $product->name }}</h2>
                <p class="text-lg font-bold text-green-700 mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                @php
                    $stock = $product->stock ?? 0;
                    $stockClass = $stock > 10 ? 'text-green-600' : ($stock > 0 ? 'text-yellow-600' : 'text-red-600');
                @endphp
                <p class="text-xs font-semibold {{ $stockClass }} mb-3">
                    Stok tersisa: {{ $stock }}
                </p>

                <p class="text-gray-600 text-sm mb-4 leading-relaxed line-clamp-3 font-light">{{ $product->description }}</p>

                <form method="POST" action="{{ route('cart.add', $product) }}" class="flex items-center space-x-2 mt-auto mb-3">
                    @csrf
                    <input
                        type="number"
                        name="quantity"
                        min="1"
                        max="{{ $stock }}"
                        value="1"
                        class="w-16 rounded border border-gray-300 text-center py-2 font-semibold text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        aria-label="Jumlah produk"
                        {{ $stock === 0 ? 'disabled' : '' }}
                    />
                    <button
                        type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white font-semibold px-4 py-2 rounded shadow hover:shadow-green-600/50 transition duration-300 flex items-center justify-center tracking-wide text-sm"
                        {{ $stock === 0 ? 'disabled cursor-not-allowed opacity-50' : '' }}
                    >
                        {{ $stock === 0 ? 'Stok Habis' : 'Tambah' }}
                    </button>
                </form>

                <a href="{{ route('products.edit', $product) }}" 
                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded shadow transition duration-300 text-center text-sm">
                    Edit
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
