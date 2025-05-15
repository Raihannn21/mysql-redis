@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-gray-100 via-gray-50 to-white px-4">
    <div class="w-full max-w-md bg-white bg-opacity-70 backdrop-blur-md rounded-3xl shadow-xl p-10">
        <h1 class="text-4xl font-light text-gray-900 mb-8 text-center tracking-wide">Tambah Produk Baru</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-7">
            @csrf

            <div>
                <label for="name" class="block text-gray-700 font-light mb-2 text-sm tracking-wide">Nama Produk</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    placeholder="Masukkan nama produk"
                    class="w-full px-5 py-3 rounded-xl border border-gray-300 bg-white text-gray-900 text-base placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
                />
            </div>

            <div>
                <label for="price" class="block text-gray-700 font-light mb-2 text-sm tracking-wide">Harga</label>
                <input
                    type="number"
                    id="price"
                    name="price"
                    required
                    placeholder="Masukkan harga produk"
                    class="w-full px-5 py-3 rounded-xl border border-gray-300 bg-white text-gray-900 text-base placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
                />
            </div>

            <div>
                <label for="stock" class="block text-gray-700 font-light mb-2 text-sm tracking-wide">Stok</label>
                <input
                    type="number"
                    id="stock"
                    name="stock"
                    required
                    placeholder="Jumlah stok tersedia"
                    class="w-full px-5 py-3 rounded-xl border border-gray-300 bg-white text-gray-900 text-base placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
                />
            </div>

            <div>
                <label for="description" class="block text-gray-700 font-light mb-2 text-sm tracking-wide">Deskripsi</label>
                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Deskripsikan produk secara singkat"
                    class="w-full px-5 py-3 rounded-xl border border-gray-300 bg-white text-gray-900 text-base placeholder-gray-400 resize-none focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
                ></textarea>
            </div>

            <div>
                <label for="image" class="block text-gray-700 font-light mb-2 text-sm tracking-wide">Gambar</label>
                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/*"
                    class="w-full text-gray-700"
                />
            </div>

            <button
                type="submit"
                class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 rounded-xl text-white font-semibold text-lg tracking-wide shadow-md transition duration-300"
            >
                Simpan
            </button>
        </form>
    </div>
</div>
@endsection
