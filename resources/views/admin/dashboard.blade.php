<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Quick Links --}}
            <div class="flex flex-wrap gap-4 mb-8">
                <a href="{{ route('admin.products.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Kelola Produk
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Kelola Kategori
                </a>
                <a href="{{ route('admin.suppliers.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700 active:bg-pink-900 focus:outline-none focus:border-pink-900 focus:ring ring-pink-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Kelola Suplier
                </a>
                <a href="{{ route('admin.orders.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Kelola Pesanan
                </a>
                <a href="{{ route('admin.reviews.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:border-yellow-900 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Kelola Ulasan
                </a>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {{-- Revenue --}}
                <div class="card-modern p-6 border-b-4 border-green-500">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Total Pendapatan</h3>
                    <p class="text-2xl font-bold text-green-600">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </p>
                </div>

                {{-- Waiting Verification --}}
                <div class="card-modern p-6 border-b-4 border-orange-500">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Perlu Verifikasi</h3>
                    <div class="flex items-center justify-between">
                        <p class="text-3xl font-bold text-orange-600">{{ $waitingVerificationCount }}</p>
                        @if($waitingVerificationCount > 0)
                            <a href="{{ route('admin.orders.index') }}" class="text-sm text-orange-600 hover:underline">
                                Tinjau &rarr;
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Total Orders --}}
                <div class="card-modern p-6 border-b-4 border-indigo-500">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Total Pesanan</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $orderCount }}</p>
                </div>

                {{-- Products --}}
                <div class="card-modern p-6 border-b-4 border-purple-500">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Katalog Produk</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $productCount }}</p>
                </div>
            </div>

            {{-- Recent Orders Table --}}
            <div class="card-modern overflow-hidden">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pesanan Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Order ID</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pelanggan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            #{{ $order->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp
                                            {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>