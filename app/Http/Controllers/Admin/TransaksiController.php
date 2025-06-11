<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function adminIndex()
    {
        // Debug sederhana untuk memastikan controller terpanggil
        \Log::info('Admin/TransaksiController reached');
        
        $transaksis = Transaksi::with('user')->get();
        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function updateStatus(Transaksi $transaksi)
    {
        $transaksi->update(['status' => request('status')]);
        return back()->with('success', 'Status updated');
    }
}