<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class HomeController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategori')->latest()->take(6)->get();
        return view('home', compact('bukus'));
    }
}