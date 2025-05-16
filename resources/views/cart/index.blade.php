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
        <div class="overflow-x-auto rounded-lg shadow-md mb-6">
            <table class="min-w-full bg-white rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm font-semibold">
                        <th class="py-4 px-6 text-left rounded-tl-lg">Produk</th>
                        <th class="py-4 px-6 text-center">Jumlah</th>
                        <th class="py-4 px-6 text-right">Harga</th>
                        <th class="py-4 px-6 text-right rounded-tr-lg">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($products as $product)
                        @php
                            $subtotal = $product->price * $product->quantity;
                            $total += $subtotal;
                        @endphp
                        <tr class="border-t border-gray-200">
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                                    <span class="font-semibold text-gray-900">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ $product->quantity }}
                            </td>
                            <td class="py-4 px-6 text-right text-gray-700">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-right text-gray-900 font-semibold">
                                Rp{{ number_format($subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-100">
                        <td colspan="3" class="py-4 px-6 text-right font-bold text-gray-800">Total:</td>
                        <td class="py-4 px-6 text-right font-bold text-green-600">
                            Rp{{ number_format($total, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('checkout.index') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-300 shadow">
                Lanjut ke Checkout
            </a>
        </div>
    @else
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow text-center text-gray-600">
            Keranjang Anda kosong.
        </div>
    @endif
</div>
@endsection
