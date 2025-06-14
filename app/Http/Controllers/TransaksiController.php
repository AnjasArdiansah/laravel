<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Keranjang;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function store(Request $request)
    {
        $keranjangs = Keranjang::with('buku')->where('user_id', Auth::id())->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang belanja kosong');
        }

        // Cek stok untuk semua item di keranjang
        foreach ($keranjangs as $keranjang) {
            if ($keranjang->buku->stok < $keranjang->jumlah) {
                return redirect()->route('keranjang.index')->with('error', 'Stok untuk buku "'.$keranjang->buku->judul.'" tidak mencukupi');
            }
        }

        // Buat transaksi
        $total = $keranjangs->sum(function($item) {
            return $item->buku->harga * $item->jumlah;
        });

        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'total_harga' => $total,
            'status' => 'pending',
            'metode_pembayaran' => $request->metode_pembayaran,
            'alamat_pengiriman' => $request->alamat_pengiriman,
        ]);

        // Buat detail transaksi dan kurangi stok
        foreach ($keranjangs as $keranjang) {
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'buku_id' => $keranjang->buku_id,
                'jumlah' => $keranjang->jumlah,
                'harga' => $keranjang->buku->harga,
            ]);

            // Kurangi stok
            $buku = Buku::find($keranjang->buku_id);
            $buku->stok -= $keranjang->jumlah;
            $buku->save();
        }

        // Kosongkan keranjang
        Keranjang::where('user_id', Auth::id())->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat');
    }

    public function show(Transaksi $transaksi)
    {
        if ($transaksi->user_id != Auth::id()) {
            abort(403);
        }

        $transaksi->load('details.buku');
        return view('transaksi.show', compact('transaksi'));
    }


    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $transaksi->update(['status' => $request->status]);
        return back()->with('success', 'Status transaksi berhasil diperbarui');
    }
}