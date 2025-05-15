@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-7xl">
    <h1 class="text-5xl font-extrabold text-center mb-16 text-gray-900 tracking-wide">Produk Premium Kami</h1>
    <div class="grid gap-10 md:grid-cols-3 sm:grid-cols-2 grid-cols-1">
        @foreach($products as $product)
        <div class="bg-gradient-to-tr from-white via-gray-100 to-gray-50 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-400 flex flex-col overflow-hidden border border-gray-200 hover:border-green-500">
            <div class="relative group">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-56 w-full object-cover rounded-t-2xl transition-transform duration-500 group-hover:scale-105" />
            </div>
            <div class="p-8 flex flex-col flex-grow">
                <h2 class="text-3xl font-serif font-extrabold text-gray-900 mb-3 tracking-tight">{{ $product->name }}</h2>
                <p class="text-2xl font-bold text-green-700 mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                {{-- Stok tersisa --}}
                @php
                    $stock = $product->stock ?? 0; // pastikan ada atribut stock
                    $stockClass = $stock > 10 ? 'text-green-600' : ($stock > 0 ? 'text-yellow-600' : 'text-red-600');
                @endphp
                <p class="text-sm font-semibold {{ $stockClass }} mb-4">
                    Stok tersisa: {{ $stock }}
                </p>

                <p class="text-gray-600 text-base mb-8 leading-relaxed line-clamp-4 font-light">{{ $product->description }}</p>
                
                <form method="POST" action="{{ route('cart.add', $product) }}" class="flex items-center space-x-4 mt-auto">
                    @csrf
                    <input
                        type="number"
                        name="quantity"
                        min="1"
                        max="{{ $stock }}"
                        value="1"
                        class="w-24 rounded-lg border border-gray-300 text-center py-3 font-semibold text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        aria-label="Jumlah produk"
                        {{ $stock === 0 ? 'disabled' : '' }}
                    />
                    <button
                        type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-green-600/50 transition duration-300 flex items-center justify-center tracking-wide"
                        {{ $stock === 0 ? 'disabled cursor-not-allowed opacity-50' : '' }}
                    >
                        {{ $stock === 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
