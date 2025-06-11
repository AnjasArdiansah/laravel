@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Buku</h1>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah Buku</a>
            @endif
        @endauth
    </div>

    <div class="row">
        @foreach($bukus as $buku)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($buku->gambar)
                        <img src="{{ asset('images/'.$buku->gambar) }}" class="card-img-top" alt="{{ $buku->judul }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $buku->judul }}</h5>
                        <p class="card-text text-muted">{{ $buku->kategori->nama }}</p>
                        <p class="card-text">{{ Str::limit($buku->deskripsi, 100) }}</p>
                        <p class="card-text"><strong>Rp {{ number_format($buku->harga, 0, ',', '.') }}</strong></p>
                        <p class="card-text">Stok: {{ $buku->stok }}</p>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            @auth
                                @if(!auth()->user()->is_admin)
                                    <form action="{{ route('keranjang.store', $buku->id) }}" method="POST">
                                        @csrf
                                        <div class="input-group input-group-sm" style="width: 120px;">
                                            <input type="number" name="jumlah" class="form-control" value="1" min="1" max="{{ $buku->stok }}">
                                            <button type="submit" class="btn btn-outline-success">+ Keranjang</button>
                                        </div>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        @auth
                            @if(auth()->user()->is_admin)
                                <div class="mt-2 d-flex justify-content-between">
                                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection