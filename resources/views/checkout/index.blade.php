@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-4xl">
    <h1 class="text-4xl font-extrabold mb-10 text-gray-900">Checkout</h1>

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-400 text-red-700 rounded-lg shadow-sm">
        {{ session('error') }}
    </div>
    @endif

    <div class="overflow-x-auto rounded-lg shadow-md">
        <table class="min-w-full bg-white rounded-lg">
            <thead>
                <tr class="bg-green-600 text-white text-left">
                    <th class="py-4 px-6 rounded-tl-lg">Produk</th>
                    <th class="py-4 px-6">Harga</th>
                    <th class="py-4 px-6">Jumlah</th>
                    <th class="py-4 px-6 rounded-tr-lg">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b hover:bg-green-50 transition-colors duration-200">
                    <td class="py-4 px-6 text-gray-800 font-semibold">{{ $product->name }}</td>
                    <td class="py-4 px-6 text-gray-700">Rp {{ number_format($product->price,0,',','.') }}</td>
                    <td class="py-4 px-6 text-gray-700 text-center">{{ $product->quantity }}</td>
                    <td class="py-4 px-6 text-gray-900 font-bold">Rp {{ number_format($product->subtotal,0,',','.') }}</td>
                </tr>
                @endforeach
                <tr class="bg-gray-100 font-bold text-lg">
                    <td colspan="3" class="py-4 px-6 text-right">Total</td>
                    <td class="py-4 px-6">Rp {{ number_format($total,0,',','.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <form method="POST" action="{{ route('checkout.process') }}" class="mt-10">
        @csrf
        <button type="submit" 
            class="w-full bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300
                   text-white font-semibold py-4 rounded-lg shadow-lg transition duration-300">
            Bayar & Buat Order
        </button>
    </form>
</div>
@endsection
