@extends('layouts.app')

@section('content')
<div class="container max-w-4xl mx-auto p-8">
    <h1 class="text-4xl mb-6 font-bold">Checkout</h1>

    @if(session('error'))
        <div class="mb-4 text-red-600">{{ session('error') }}</div>
    @endif

    <table class="w-full mb-6 border border-gray-200 rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-4">Produk</th>
                <th class="p-4 text-center">Jumlah</th>
                <th class="p-4 text-right">Harga</th>
                <th class="p-4 text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td class="p-4">{{ $product->name }}</td>
                <td class="p-4 text-center">{{ $product->quantity }}</td>
                <td class="p-4 text-right">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="p-4 text-right">Rp{{ number_format($product->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-gray-50 font-bold">
                <td colspan="3" class="p-4 text-right">Total:</td>
                <td class="p-4 text-right">Rp{{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <form action="{{ route('checkout.process') }}" method="POST" class="space-y-4">
        @csrf
        <label class="block">
            <span class="text-gray-700">Metode Pembayaran</span>
            <select name="payment_method" required class="mt-1 block w-full rounded border-gray-300">
                <option value="">-- Pilih Metode Pembayaran --</option>
                <option value="transfer">Transfer Bank</option>
                <option value="kartu">Kartu Kredit</option>
            </select>
            @error('payment_method')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </label>

        <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">
            Bayar & Buat Order
        </button>
    </form>
</div>
@endsection
