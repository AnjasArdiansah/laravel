@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<div class="container">
    <h1>Edit Buku</h1>
    
    <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ $buku->judul }}" required>
        </div>
        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select class="form-select" id="kategori_id" name="kategori_id" required>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ $buku->kategori_id == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ $buku->deskripsi }}</textarea>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" value="{{ $buku->harga }}" required>
        </div>
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" value="{{ $buku->stok }}" required>
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
            @if($buku->gambar)
                <div class="mt-2">
                    <img src="{{ asset('images/'.$buku->gambar) }}" width="100" class="img-thumbnail">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="hapus_gambar" name="hapus_gambar">
                        <label class="form-check-label" for="hapus_gambar">
                            Hapus gambar
                        </label>
                    </div>
                </div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection