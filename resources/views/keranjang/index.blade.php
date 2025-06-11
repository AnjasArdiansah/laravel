@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container">
    <h1>Keranjang Belanja</h1>
    
    @if($keranjangs->isEmpty())
        <div class="alert alert-info">
            Keranjang belanja Anda kosong. <a href="{{ route('buku.index') }}" class="alert-link">Mulai belanja</a>
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keranjangs as $keranjang)
                    <tr>
                        <td>{{ $keranjang->buku->judul }}</td>
                        <td>Rp {{ number_format($keranjang->buku->harga, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('keranjang.update', $keranjang->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="number" name="jumlah" value="{{ $keranjang->jumlah }}" min="1" max="{{ $keranjang->buku->stok }}" class="form-control form-control-sm" style="width: 70px; display: inline;">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                            </form>
                        </td>
                        <td>Rp {{ number_format($keranjang->buku->harga * $keranjang->jumlah, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('keranjang.destroy', $keranjang->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

        <div class="card">
            <div class="card-header">
                Checkout
            </div>
            <div class="card-body">
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                        <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                            <option value="transfer">Transfer Bank</option>
                            <option value="cod">COD (Bayar di Tempat)</option>
                            <option value="e-wallet">E-Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_pengiriman" class="form-label">Alamat Pengiriman</label>
                        <textarea class="form-control" id="alamat_pengiriman" name="alamat_pengiriman" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Proses Checkout</button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection