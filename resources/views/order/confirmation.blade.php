@extends('layouts.app')

@section('content')
<div class="container max-w-4xl mx-auto p-8">
    <h1 class="text-4xl mb-6 font-bold">Konfirmasi Order #{{ $order->id }}</h1>

    <p>Status: <strong>{{ ucfirst($order->status) }}</strong></p>
    <p>Total Harga: Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
    <p>Metode Pembayaran: {{ $order->payment_method ?? 'Belum ditentukan' }}</p>

    <h2 class="mt-6 mb-4 text-2xl font-semibold">Detail Produk</h2>

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
            @foreach($order->orderDetails as $detail)
            <tr>
                <td class="p-4">{{ $detail->product->name }}</td>
                <td class="p-4 text-center">{{ $detail->quantity }}</td>
                <td class="p-4 text-right">Rp{{ number_format($detail->price, 0, ',', '.') }}</td>
                <td class="p-4 text-right">Rp{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Kembali ke Dashboard</a>
</div>
@endsection
