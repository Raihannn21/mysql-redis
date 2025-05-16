@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-4xl">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        {{-- Gambar produk --}}
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full object-cover h-96" />
        @else
            <div class="w-full h-96 bg-gray-200 flex items-center justify-center text-gray-400 text-xl italic">
                Gambar tidak tersedia
            </div>
        @endif

        <div class="p-8">
            {{-- Nama produk --}}
            <h1 class="text-4xl font-bold mb-4">{{ $product->name }}</h1>

            {{-- Harga --}}
            <p class="text-3xl font-semibold text-green-700 mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

            {{-- Stok --}}
            @php
                $stock = $product->stock ?? 0;
                $stockClass = $stock > 10 ? 'text-green-600' : ($stock > 0 ? 'text-yellow-600' : 'text-red-600');
            @endphp
            <p class="text-lg font-semibold {{ $stockClass }} mb-6">
                Stok tersisa: {{ $stock }}
            </p>

            {{-- Deskripsi --}}
            <p class="text-gray-700 text-lg leading-relaxed mb-8 whitespace-pre-line">{{ $product->description }}</p>

            {{-- Form tambah ke keranjang --}}
            <form method="POST" action="{{ route('cart.add', $product) }}" class="flex items-center space-x-4">
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

            {{-- Link kembali --}}
            <a href="{{ route('products.index') }}" class="inline-block mt-8 text-green-700 hover:text-green-900 font-semibold">
                &larr; Kembali ke Daftar Produk
            </a>
        </div>
    </div>
</div>
@endsection
