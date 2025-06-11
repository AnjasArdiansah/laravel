@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="jumbotron bg-light p-5 rounded-3 mb-4">
        <h1 class="display-4">Selamat Datang di Bukucape</h1>
        <p class="lead">Tempat terbaik untuk membeli buku-buku berkualitas.</p>
    </div>

    @if(isset($bukus) && $bukus->count() > 0)
        <h2 class="mb-4">Buku Terbaru</h2>
        <div class="row">
            @foreach($bukus as $buku)
                <div class="col-md-4 mb-4">
                    <!-- Tampilkan data buku -->
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Tidak ada buku tersedia saat ini.</div>
    @endif
</div>
@endsection