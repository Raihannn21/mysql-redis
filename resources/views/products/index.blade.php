@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-7xl" x-data="{ showModal: false, modalProduct: null, quantity: 1, showAddModal: false }">

    <!-- Header: Judul dan Tombol Tambah Produk -->
    <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-4">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-wide">Daftar Produk</h1>
        <button
            @click="showAddModal = true"
            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition duration-200 text-sm shadow"
        >
            + Tambah Produk
        </button>
    </div>

    <!-- Pesan Success -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Grid Produk -->
    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($products as $product)
            @php
                $stock = $product->stock ?? 0;
                $stockClass = $stock > 10 ? 'text-green-600' : ($stock > 0 ? 'text-yellow-600' : 'text-red-600');
            @endphp
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 border border-gray-200 hover:border-green-500 flex flex-col overflow-hidden relative">
                
                <!-- Gambar Produk -->
                <div class="relative overflow-hidden rounded-t-xl group">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                         class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105" />
                </div>

                <!-- Informasi Produk -->
                <div class="p-4 flex flex-col flex-grow">
                    <h2 class="text-lg font-bold text-gray-900 mb-1">{{ $product->name }}</h2>
                    <p class="text-base font-semibold text-green-700 mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-xs font-medium {{ $stockClass }} mb-2">
                        Stok tersisa: {{ $stock }}
                    </p>
                    <p class="text-gray-600 text-sm mb-4 leading-snug line-clamp-3 font-light">{{ $product->description }}</p>

                    <!-- Tombol Lihat Produk (modal) -->
                    <button
                        @click="modalProduct = {{ json_encode($product) }}; quantity = 1; showModal = true"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded text-sm transition mb-4"
                        :disabled="{{ $stock === 0 ? 'true' : 'false' }}"
                    >
                        {{ $stock === 0 ? 'Stok Habis' : 'Lihat Produk' }}
                    </button>

                    <!-- Tombol Edit & Hapus -->
                    <div class="mt-auto flex justify-end space-x-3">
                        <a href="{{ route('products.edit', $product) }}" 
                           class="text-yellow-500 hover:text-yellow-600 text-xl transition" 
                           title="Edit Produk">
                            ✏️
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-500 hover:text-red-600 text-xl transition" 
                                    title="Hapus Produk">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Detail Produk -->
    <div
        x-show="showModal"
        x-transition.opacity
        @click.away="showModal = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
        style="display: none;"
    >
        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full p-6 transform transition-all duration-300 scale-95" @click.stop>
            <h2 class="text-2xl font-bold mb-4" x-text="modalProduct.name"></h2>
            <img :src="`/storage/${modalProduct.image}`" alt="" class="w-full h-48 object-cover rounded mb-4" />
            <p class="text-green-700 font-bold mb-2">Rp <span x-text="modalProduct.price.toLocaleString('id-ID')"></span></p>
            <p class="mb-2">
                Stok tersisa: 
                <span :class="modalProduct.stock > 10 ? 'text-green-600' : (modalProduct.stock > 0 ? 'text-yellow-600' : 'text-red-600')" 
                      x-text="modalProduct.stock"></span>
            </p>
            <p class="mb-4 text-gray-700" x-text="modalProduct.description"></p>

            <form method="POST" :action="`/cart/add/${modalProduct.id}`" class="flex items-center space-x-3 mb-4">
                @csrf
                <input
                    type="number"
                    name="quantity"
                    min="1"
                    :max="modalProduct.stock"
                    x-model.number="quantity"
                    class="w-20 rounded border border-gray-300 text-center py-2 text-gray-800 focus:ring-2 focus:ring-green-500 transition"
                    aria-label="Jumlah produk"
                />
                <button
                    type="submit"
                    class="bg-green-700 hover:bg-green-800 text-white font-semibold px-4 py-2 rounded shadow transition text-sm"
                    :disabled="modalProduct.stock === 0 || quantity < 1 || quantity > modalProduct.stock"
                >
                    Tambah ke Keranjang
                </button>
            </form>

            <button 
                @click="showModal = false" 
                class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 rounded py-2 text-sm font-medium"
            >
                Tutup
            </button>
        </div>
    </div>

    <!-- Modal Tambah Produk -->
    <div
        x-show="showAddModal"
        x-transition.opacity
        @click.away="showAddModal = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
        style="display: none;"
    >
        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full p-6 transform transition-all duration-300 scale-95" @click.stop>
            <h2 class="text-2xl font-bold mb-4">Tambah Produk Baru</h2>

            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-1" for="name">Nama Produk</label>
                    <input type="text" name="name" id="name" required
                           class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-green-500" />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-1" for="price">Harga (Rp)</label>
                    <input type="number" name="price" id="price" min="0" required
                           class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-green-500" />
                    @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-1" for="stock">Stok</label>
                    <input type="number" name="stock" id="stock" min="0" required
                           class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-green-500" />
                    @error('stock')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-1" for="image">Gambar Produk</label>
                    <input type="file" name="image" id="image" accept="image/*" required
                           class="w-full" />
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-1" for="description">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" required
                              class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-green-500"></textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
