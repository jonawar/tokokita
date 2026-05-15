<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Supplier Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card-modern p-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('admin.suppliers.index') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest">Nama Supplier</label>
                            <input type="text" name="name" required class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest">Kontak / Tlp</label>
                            <input type="text" name="phone" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest">Email</label>
                            <input type="email" name="email" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-widest">Alamat</label>
                            <textarea name="address" rows="4" class="w-full p-4 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium italic"></textarea>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-100 flex justify-end items-center gap-4">
                        <a href="{{ route('admin.suppliers.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 uppercase tracking-widest">Batal</a>
                        <button type="submit" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-100 transition-all active:scale-95">
                            Simpan Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
