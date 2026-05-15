<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card-modern p-8 bg-white max-w-2xl mx-auto shadow-2xl">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest">Nama Kategori</label>
                            <input type="text" name="name" value="{{ $category->name }}" required class="w-full p-4 bg-gray-50 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-lg">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest text-opacity-50">Slug (URL)</label>
                            <input type="text" name="slug" value="{{ $category->slug }}" readonly class="w-full p-4 bg-gray-100 border border-gray-200 rounded-2xl text-gray-400 font-mono text-sm cursor-not-allowed">
                            <p class="mt-2 text-xs text-gray-400 italic">* Slug tidak dapat diubah untuk menjaga integritas URL produk.</p>
                        </div>

                        <div class="pt-6 border-t border-gray-100 flex justify-end items-center gap-6">
                            <a href="{{ route('admin.categories.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 uppercase tracking-widest transition-colors">Batal</a>
                            <button type="submit" class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-100 transition-all active:scale-95 leading-none">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
