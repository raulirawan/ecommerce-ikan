<?php

namespace App\Http\Controllers;

use App\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function detail($slug)
    {
        $produk = Produk::where('slug', $slug)->first();

        return view('page.produk-detail', compact('produk'));
    }
}
