<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pesanan') }} <span class="text-indigo-600">#{{ $order->id }}</span>
            </h2>
            <a href="{{ route('admin.orders.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Order Details & Items (Main Content) --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Product List Card --}}
                    <div class="card-modern overflow-hidden">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                                📦 Produk Dipesan
                            </h3>
                            <div class="space-y-6">
                                @foreach($order->items as $item)
                                    <div
                                        class="flex justify-between items-center pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-16 h-16 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl flex items-center justify-center p-2 border border-indigo-100 shadow-sm shrink-0">
                                                <img src="{{ asset('images/logo.png') }}" alt="logo"
                                                    class="max-w-full max-h-full object-contain filter drop-shadow">
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900 leading-tight">{{ $item->product->name }}
                                                </h4>
                                                <p class="text-sm text-gray-500 font-medium mt-1">
                                                    {{ $item->quantity }} x Rp
                                                    {{ number_format($item->price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="font-bold text-indigo-600">
                                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-8 pt-8 border-t-2 border-dashed border-gray-100 text-right">
                                <p class="text-sm text-gray-500 font-semibold mb-1 uppercase tracking-wider">Total
                                    Pembayaran</p>
                                <h3 class="text-3xl font-extrabold text-indigo-600">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Info Card --}}
                    <div class="card-modern p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                            🚚 Informasi Pengiriman
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Nama
                                    Penerima</label>
                                <p class="text-gray-900 font-semibold">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <label
                                    class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Nomor
                                    HP</label>
                                <p class="text-gray-900 font-semibold">{{ $order->phone }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Alamat
                                    Lengkap</label>
                                <p
                                    class="text-gray-900 font-medium leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100 italic">
                                    {{ $order->address }}
                                </p>
                            </div>
                            @if($order->note)
                                <div class="md:col-span-2">
                                    <label
                                        class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Catatan</label>
                                    <p
                                        class="text-orange-700 bg-orange-50 border border-orange-100 p-4 rounded-xl text-sm italic font-medium">
                                        "{{ $order->note }}"
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar: Update Order (Form) --}}
                <div class="space-y-8">
                    <div class="card-modern p-6 bg-white border-b border-gray-200 sticky top-8 shadow-xl">
                        <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                            ⚙️ Update Status Pesanan
                        </h3>

                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            {{-- Payment Proof Display --}}
                            @if($order->payment_proof)
                                <div class="mb-8 p-4 bg-green-50 border-2 border-green-200 rounded-2xl">
                                    <h4 class="text-sm font-bold text-green-700 mb-4 flex items-center gap-1">🖼️ Bukti
                                        Pembayaran</h4>
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank"
                                        class="block overflow-hidden rounded-xl border border-green-200 hover:opacity-90 transition-opacity">
                                        <img src="{{ asset('storage/' . $order->payment_proof) }}"
                                            class="w-full h-auto object-cover" title="Klik untuk memperbesar">
                                    </a>
                                    <p class="text-[10px] text-green-600 mt-3 font-semibold text-center italic">
                                        * Klik gambar untuk melihat ukuran penuh
                                    </p>
                                </div>
                            @endif

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Status Saat Ini</label>
                                    <select name="status"
                                        class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                            Pending (Menunggu)</option>
                                        <option value="waiting_verification" {{ $order->status == 'waiting_verification' ? 'selected' : '' }}>Verifikasi Pembayaran</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                            Dibayar / Diproses</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                            Dikirim (Input Resi)</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                            Selesai</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                            Dibatalkan</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Resi /
                                        Tracking</label>
                                    <input type="text" name="tracking_number" value="{{ $order->tracking_number }}"
                                        placeholder="Contoh: JNE12345678"
                                        class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                                </div>

                                <button type="submit"
                                    class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-100 transition-all active:scale-95">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>