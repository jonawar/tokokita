@extends('layouts.frontend')

@section('title', 'Profil Saya - ' . config('app.name'))

@section('content')
<div class="container" style="padding-top: 50px; padding-bottom: 50px;">
    <div style="max-width: 900px; margin: 0 auto;">
        <h1 style="margin-bottom: 30px; display: flex; align-items: center; gap: 15px;">
            <span style="font-size: 2.5rem;">👤</span> Profil Saya
        </h1>

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
            <!-- Sidebar Info -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div style="background: white; padding: 25px; border-radius: 20px; box-shadow: var(--shadow); text-align: center;">
                    <div style="width: 80px; height: 80px; background: var(--secondary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800; margin: 0 auto 15px;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h3 style="margin-bottom: 5px;">{{ $user->name }}</h3>
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 15px;">{{ $user->email }}</p>
                    <span style="background: #e1f5fe; color: #0288d1; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                        {{ $user->is_admin ? 'ADMIN' : 'PELANGGAN' }}
                    </span>
                </div>

                <div style="background: white; padding: 25px; border-radius: 20px; box-shadow: var(--shadow);">
                    <h4 style="margin-bottom: 15px;">Menu Cepat</h4>
                    <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 12px;">
                        <li>
                            <a href="{{ route('orders.index') }}" style="text-decoration: none; color: #333; display: flex; align-items: center; gap: 10px; font-weight: 600;">
                                <span>📋</span> Riwayat Pesanan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}" style="text-decoration: none; color: #333; display: flex; align-items: center; gap: 10px; font-weight: 600;">
                                <span>🛒</span> Lanjut Belanja
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content Form -->
            <div style="display: flex; flex-direction: column; gap: 30px;">
                <!-- Profile Info Form -->
                <div style="background: white; padding: 35px; border-radius: 20px; box-shadow: var(--shadow);">
                    <h3 style="margin-bottom: 25px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">Informasi Pribadi</h3>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #444;">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #eee; background: #fafafa;" required>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #444;">Email (Tidak dapat diubah)</label>
                            <input type="email" value="{{ $user->email }}" disabled
                                style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #eee; background: #f0f0f0; cursor: not-allowed;">
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #444;">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567xxx"
                                style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #eee; background: #fafafa;">
                        </div>

                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #444;">Alamat Pengiriman</label>
                            <textarea name="address" rows="4" placeholder="Alamat lengkap rumah atau kantor..."
                                style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #eee; background: #fafafa; resize: vertical;">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <button type="submit" class="btn" style="width: 100%; padding: 15px; border-radius: 12px; font-size: 1rem;">Simpan Perubahan</button>
                    </form>
                </div>

                <!-- Password Update Form -->
                <div style="background: white; padding: 35px; border-radius: 20px; box-shadow: var(--shadow);">
                    <h3 style="margin-bottom: 25px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">Keamanan (Ganti Password)</h3>
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #444;">Password Saat Ini</label>
                            <input type="password" name="current_password" 
                                style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #eee; background: #fafafa;" required>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #444;">Password Baru</label>
                            <input type="password" name="password" 
                                style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #eee; background: #fafafa;" required>
                        </div>

                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #444;">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" 
                                style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #eee; background: #fafafa;" required>
                        </div>

                        <button type="submit" class="btn" style="width: 100%; padding: 15px; border-radius: 12px; font-size: 1rem; background: #6c757d;">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
