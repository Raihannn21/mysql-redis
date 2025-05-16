@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Edit Produk</h1>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-8 shadow-lg rounded-lg">
        @csrf
        @method('PUT')

        <!-- Nama Produk -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $product->name) }}"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                   required>
        </div>

        <!-- Harga -->
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
            <input type="number" name="price" id="price"
                   value="{{ old('price', $product->price) }}"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                   required>
        </div>

        <!-- Stok -->
        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
            <input type="number" name="stock" id="stock"
                   value="{{ old('stock', $product->stock) }}"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                   required>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Upload Gambar -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
            <input type="file" name="image" id="image"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700">

            @if ($product->image)
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk" class="w-40 h-40 object-cover rounded border">
                </div>
            @endif
        </div>

        <!-- Tombol Submit -->
        <div class="text-right">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow-sm transition">
                Update Produk
            </button>
        </div>
    </form>
</div>
@endsection
