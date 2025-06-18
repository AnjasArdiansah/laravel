<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiAdminController extends Controller
{
    public function index()
    {
        // Cek apakah user login dan admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $transaksis = Transaksi::with(['user', 'details.buku'])->latest()->get();
        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        // Cek apakah user login dan admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan'
        ]);

        $transaksi->update(['status' => $request->status]);
        return back()->with('success', 'Status transaksi berhasil diperbarui');
    }
}