@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-4xl">
    <h1 class="text-4xl font-extrabold mb-10 text-gray-900">Keranjang Belanja</h1>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-400 text-green-700 rounded-lg shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    @if(count($products) > 0)
    <div class="overflow-x-auto rounded-lg shadow-md">
        <table class="min-w-full bg-white rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm font-semibold">
                    <th class="py-4 px-6 text-left rounded-tl-lg">Produk</th>
                    <th class="py-4 px-6 text-left">Harga</th>
                    <th class="py-4 px-6 text-center">Jumlah</th>
                    <th class="py-4 px-6 text-left">Subtotal</th>
                    <th class="py-4 px-6 text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm font-normal">
                @foreach($products as $product)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                    <td class="py-4 px-6 whitespace-nowrap font-semibold">{{ $product->name }}</td>
                    <td class="py-4 px-6">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="py-4 px-6 text-center">{{ $product->quantity }}</td>
                    <td class="py-4 px-6 font-bold">Rp {{ number_format($product->subtotal, 0, ',', '.') }}</td>
                    <td class="py-4 px-6 text-center">
                        <form method="POST" action="{{ route('cart.remove', $product) }}">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg text-sm font-semibold shadow transition duration-300">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <tr class="bg-gray-100 font-bold text-lg">
                    <td colspan="3" class="py-4 px-6 text-right">Total</td>
                    <td class="py-4 px-6">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-10 flex justify-end">
        <a href="#" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-lg shadow-lg transition duration-300">
            Checkout
        </a>
    </div>
    @else
    <p class="text-gray-600 text-center mt-10 text-lg">Keranjang belanja kosong.</p>
    @endif
</div>
@endsection
