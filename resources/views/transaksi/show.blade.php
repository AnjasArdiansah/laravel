@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container">
    <h1>Detail Transaksi #{{ $transaksi->id }}</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    Informasi Transaksi
                </div>
                <div class="card-body">
                    <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d M Y H:i') }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge 
                            @if($transaksi->status == 'pending') bg-warning text-dark
                            @elseif($transaksi->status == 'success') bg-success
                            @elseif($transaksi->status == 'failed') bg-danger
                            @else bg-secondary @endif">
                            {{ ucfirst($transaksi->status) }}
                        </span>
                    </p>
                    <p><strong>Metode Pembayaran:</strong> {{ ucfirst($transaksi->metode_pembayaran) }}</p>
                    <p><strong>Alamat Pengiriman:</strong> {{ $transaksi->alamat_pengiriman }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    Ringkasan Pembayaran
                </div>
                <div class="card-body">
                    <p><strong>Total Harga:</strong> Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Daftar Buku
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->details as $detail)
                        <tr>
                            <td>{{ $detail->buku->judul }}</td>
                            <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>Rp {{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection