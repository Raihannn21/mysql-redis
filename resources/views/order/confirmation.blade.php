@extends('layouts.app')

@section('content')
<div class="container max-w-3xl mx-auto p-8">
    <h1 class="text-4xl font-bold mb-6">Order #{{ $order->id }} Berhasil Dibuat</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <p>Status Order: <strong>{{ ucfirst($order->status) }}</strong></p>
    <p>Total Harga: <strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong></p>
    <p>Waktu Pesanan: {{ $order->created_at->format('d M Y, H:i') }}</p>

    <hr class="my-6">

    <h2 class="text-2xl font-semibold mb-4">Detail Produk</h2>
    <ul>
        @foreach($order->orderDetails as $detail)
            <li>
                {{ $detail->product->name }} - Jumlah: {{ $detail->quantity }} - Harga per item: Rp{{ number_format($detail->price, 0, ',', '.') }}
            </li>
        @endforeach
    </ul>

    <div class="mt-8">
        <a href="{{ route('home') }}" class="bg-blue-600 text-white px-5 py-3 rounded hover:bg-blue-700">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
