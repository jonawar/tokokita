<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card-modern p-8 bg-white overflow-hidden shadow-2xl transition-all hover:shadow-indigo-100">
                @if ($errors->any())
                    <div class="mb-8 p-6 bg-red-50 border-l-4 border-red-500 rounded-xl shadow-sm">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <h3 class="text-red-800 font-bold uppercase tracking-widest text-sm">Terjadi Kesalahan</h3>
                        </div>
                        <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        {{-- Basic Info Section --}}
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest">Nama Produk</label>
                                <input type="text" name="name" value="{{ $product->name }}" required class="w-full p-4 bg-gray-50 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-lg">
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest">Harga (Rp)</label>
                                    <input type="number" name="price" value="{{ $product->price }}" required class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest">Stok</label>
                                    <input type="number" name="stock" value="{{ $product->stock }}" required class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                                </div>
                            </div>

                            {{-- Promo Section --}}
                            <div class="p-6 bg-indigo-50 rounded-2xl border border-indigo-100 space-y-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_promo" id="is_promo" value="1" {{ $product->is_promo ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition-all">
                                    <label for="is_promo" class="ml-3 block text-sm font-bold text-indigo-900 uppercase tracking-widest">Aktifkan Harga Promo</label>
                                </div>
                                <div id="promo_price_wrapper" class="{{ $product->is_promo ? '' : 'hidden' }}">
                                    <label class="block text-xs font-bold text-indigo-700 mb-2 uppercase tracking-widest">Harga Promo (Rp)</label>
                                    <input type="number" name="promo_price" value="{{ $product->promo_price }}" class="w-full p-3 bg-white border border-indigo-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                                    <p class="mt-2 text-xs text-indigo-500 italic">* Harus lebih kecil dari harga normal</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest">Kategori</label>
                                    <select name="category_id" required class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest">Tipe</label>
                                    <select name="type" required class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                                        <option value="book" {{ $product->type == 'book' ? 'selected' : '' }}>Buku</option>
                                        <option value="toy" {{ $product->type == 'toy' ? 'selected' : '' }}>Mainan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Metadata Section --}}
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest">Deskripsi</label>
                                <textarea name="description" rows="6" class="w-full p-5 bg-gray-50 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium italic leading-relaxed text-gray-600">{{ $product->description }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest">Supplier</label>
                                <select name="supplier_id" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                                    <option value="">Tanpa Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Media Section --}}
                    <div class="mt-8 pt-8 border-t border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-6 uppercase tracking-widest">Media Produk</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest">URL Gambar</label>
                                <input type="url" name="image_url" value="{{ $product->image_url }}" placeholder="https://example.com/image.jpg" class="w-full p-4 bg-gray-50 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                                @if($product->image_url)
                                    <div class="mt-4">
                                        <p class="text-xs text-gray-400 mb-2 uppercase font-bold">Preview:</p>
                                        <img src="{{ $product->image_url }}" alt="Preview" class="w-32 h-32 object-cover rounded-2xl border border-gray-200 shadow-lg">
                                    </div>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest">URL Video</label>
                                <input type="url" name="video_url" value="{{ $product->video_url }}" placeholder="https://youtube.com/watch?v=..." class="w-full p-4 bg-gray-50 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                                @if($product->video_url)
                                    <div class="mt-4">
                                        <p class="text-xs text-gray-400 mb-2 uppercase font-bold">Tautan Video:</p>
                                        <a href="{{ $product->video_url }}" target="_blank" class="text-sm text-indigo-600 font-bold hover:text-indigo-800 transition-colors inline-flex items-center gap-2">
                                            <span>Lihat Video</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Additional Images --}}
                        <div class="mt-8">
                            <label class="block text-sm font-bold text-gray-700 mb-4 uppercase tracking-widest flex justify-between items-center">
                                Gambar Tambahan (Galeri)
                                <button type="button" onclick="addImageInput()" class="text-xs bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full hover:bg-indigo-200 transition-all">+ Tambah URL</button>
                            </label>
                            <div id="additional_images_container" class="space-y-3">
                                @foreach($product->images as $image)
                                    <div class="flex gap-2">
                                        <input type="url" name="additional_images[]" value="{{ $image->image_url }}" placeholder="https://example.com/another-image.jpg" class="flex-1 p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                                        <button type="button" onclick="this.parentElement.remove()" class="px-3 text-red-400 hover:text-red-600">×</button>
                                    </div>
                                @endforeach
                                @if($product->images->isEmpty())
                                    <div class="flex gap-2">
                                        <input type="url" name="additional_images[]" placeholder="https://example.com/another-image.jpg" class="flex-1 p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                                        <button type="button" onclick="this.parentElement.remove()" class="px-3 text-red-400 hover:text-red-600">×</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-10 border-t border-gray-100 flex justify-end items-center gap-6">
                        <a href="{{ route('admin.products.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 uppercase tracking-widest transition-colors">Batal</a>
                        <button type="submit" class="px-14 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-95 leading-none">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Promo toggle
        const promoCheckbox = document.getElementById('is_promo');
        const promoWrapper = document.getElementById('promo_price_wrapper');
        
        promoCheckbox.addEventListener('change', function() {
            if(this.checked) {
                promoWrapper.classList.remove('hidden');
            } else {
                promoWrapper.classList.add('hidden');
            }
        });

        // Additional Images dynamic inputs
        function addImageInput() {
            const container = document.getElementById('additional_images_container');
            const div = document.createElement('div');
            div.className = 'flex gap-2';
            div.innerHTML = `
                <input type="url" name="additional_images[]" placeholder="https://example.com/another-image.jpg" class="flex-1 p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                <button type="button" onclick="this.parentElement.remove()" class="px-3 text-red-400 hover:text-red-600">×</button>
            `;
            container.appendChild(div);
        }
    </script>
</x-app-layout>
