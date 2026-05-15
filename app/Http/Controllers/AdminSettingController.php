<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = [
            'store_name' => setting('store_name', config('app.name')),
            'store_address' => setting('store_address'),
            'store_phone' => setting('store_phone'),
            'store_email' => setting('store_email'),
            'whatsapp_number' => setting('whatsapp_number'),
            'meta_description' => setting('meta_description'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'nullable|string',
            'store_phone' => 'nullable|string|max:20',
            'store_email' => 'nullable|email|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'meta_description' => 'nullable|string',
        ]);

        foreach ($data as $key => $value) {
            \App\Models\Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
