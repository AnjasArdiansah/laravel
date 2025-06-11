@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            @if($buku->gambar)
                <img src="{{ asset('images/'.$buku->gambar) }}" class="img-fluid rounded" alt="{{ $buku->judul }}">
            @else
                <img src="https://via.placeholder.com/300x400?text=No+Image" class="img-fluid rounded" alt="No Image">
            @endif
        </div>
        <div class="col-md-8">
            <h1>{{ $buku->judul }}</h1>
            <p class="text-muted">Kategori: {{ $buku->kategori->nama }}</p>
            <p><strong>Harga: Rp {{ number_format($buku->harga, 0, ',', '.') }}</strong></p>
            <p>Stok: {{ $buku->stok }}</p>
            <p>{{ $buku->deskripsi }}</p>
            
            @auth
                @if(!auth()->user()->is_admin)
                    <form action="{{ route('keranjang.store', $buku->id) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="input-group" style="width: 200px;">
                            <input type="number" name="jumlah" class="form-control" value="1" min="1" max="{{ $buku->stok }}">
                            <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                        </div>
                    </form>
                @endif
            @else
                <div class="alert alert-info mt-4">
                    <a href="{{ route('login') }}" class="alert-link">Login</a> untuk menambahkan ke keranjang.
                </div>
            @endauth
            
            @auth
                @if(auth()->user()->is_admin)
                    <div class="mt-4">
                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection