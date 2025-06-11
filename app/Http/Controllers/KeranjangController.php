<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjangs = Keranjang::with('buku')->where('user_id', Auth::id())->get();
        $total = $keranjangs->sum(function($item) {
            return $item->buku->harga * $item->jumlah;
        });
        
        return view('keranjang.index', compact('keranjangs', 'total'));
    }

    public function store(Request $request, $buku_id)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ]);

        $buku = Buku::findOrFail($buku_id);

        // Cek stok
        if ($buku->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        // Cek apakah buku sudah ada di keranjang
        $keranjang = Keranjang::where('user_id', Auth::id())
            ->where('buku_id', $buku_id)
            ->first();

        if ($keranjang) {
            $keranjang->jumlah += $request->jumlah;
            $keranjang->save();
        } else {
            Keranjang::create([
                'user_id' => Auth::id(),
                'buku_id' => $buku_id,
                'jumlah' => $request->jumlah,
            ]);
        }

        return redirect()->route('keranjang.index')->with('success', 'Buku berhasil ditambahkan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ]);

        $keranjang = Keranjang::findOrFail($id);
        $buku = $keranjang->buku;

        // Cek stok
        if ($buku->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $keranjang->update(['jumlah' => $request->jumlah]);

        return redirect()->route('keranjang.index')->with('success', 'Keranjang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $keranjang = Keranjang::findOrFail($id);
        $keranjang->delete();

        return redirect()->route('keranjang.index')->with('success', 'Buku berhasil dihapus dari keranjang');
    }
}