@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-5xl">
    <h1 class="text-4xl font-extrabold mb-12 text-gray-900">Keranjang Belanja</h1>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-50 border border-green-400 text-green-700 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(count($products) > 0)
        <div class="overflow-x-auto rounded-lg shadow-lg mb-8 border border-gray-200">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm font-semibold tracking-wide">
                        <th class="py-4 px-6 text-left rounded-tl-lg">Produk</th>
                        <th class="py-4 px-6 text-center">Jumlah</th>
                        <th class="py-4 px-6 text-right">Harga</th>
                        <th class="py-4 px-6 text-right">Subtotal</th>
                        <th class="py-4 px-6 text-center rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($products as $product)
                        @php
                            $subtotal = $product->price * $product->quantity;
                            $total += $subtotal;
                        @endphp
                        <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg border border-gray-300">
                                    <span class="font-semibold text-gray-900">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center font-medium text-gray-700">{{ $product->quantity }}</td>
                            <td class="py-4 px-6 text-right text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-right font-semibold text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('cart.remove', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?');">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold transition duration-200">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-gray-50 font-semibold text-gray-900 border-t border-gray-300">
                        <td colspan="3" class="py-4 px-6 text-right text-lg">Total</td>
                        <td class="py-4 px-6 text-right text-lg">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-right">
            <a href="{{ route('checkout.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-md transition duration-300 ease-in-out">
                Lanjut ke Checkout
            </a>
        </div>
    @else
        <div class="text-center text-gray-600 py-20">
            <p class="text-lg mb-6">Keranjang kamu kosong. Yuk, belanja dulu!</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300">
                Lihat Produk
            </a>
        </div>
    @endif
</div>
@endsection
