<?php

namespace App\Http\Controllers;

use App\User;
use App\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $penjual = User::with(['produk'])->where('roles','PENJUAL')->get();
        return view('ikan', compact('penjual'));
    }
    public function detail($slug)
    {
        $produk = Produk::where('slug', $slug)->first();

        return view('page.produk-detail', compact('produk'));
    }
}
