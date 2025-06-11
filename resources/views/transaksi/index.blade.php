@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container">
    <h1>Riwayat Transaksi</h1>
    
    @if($transaksis->isEmpty())
        <div class="alert alert-info">
            Anda belum memiliki transaksi. <a href="{{ route('buku.index') }}" class="alert-link">Mulai belanja</a>
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $transaksi)
                    <tr>
                        <td>#{{ $transaksi->id }}</td>
                        <td>{{ $transaksi->created_at->format('d M Y H:i') }}</td>
                        <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge 
                                @if($transaksi->status == 'pending') bg-warning text-dark
                                @elseif($transaksi->status == 'success') bg-success
                                @elseif($transaksi->status == 'failed') bg-danger
                                @else bg-secondary @endif">
                                {{ ucfirst($transaksi->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('transaksi.show', $transaksi->id) }}" class="btn btn-sm btn-primary">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection