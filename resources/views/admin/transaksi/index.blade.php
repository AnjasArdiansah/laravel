{{-- filepath: resources/views/admin/transaksi/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Transaksi Admin')

@section('content')
    <h1>Daftar Transaksi</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Status</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->user->name ?? '-' }}</td>
                    <td>{{ $transaksi->status }}</td>
                    <td>Rp{{ number_format($transaksi->total,0,',','.') }}</td>
                    <td>
                        <form action="{{ route('admin.transaksi.updateStatus', $transaksi) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()">
                                <option {{ $transaksi->status == 'pending' ? 'selected' : '' }}>pending</option>
                                <option {{ $transaksi->status == 'diproses' ? 'selected' : '' }}>diproses</option>
                                <option {{ $transaksi->status == 'dikirim' ? 'selected' : '' }}>dikirim</option>
                                <option {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>selesai</option>
                                <option {{ $transaksi->status == 'dibatalkan' ? 'selected' : '' }}>dibatalkan</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection