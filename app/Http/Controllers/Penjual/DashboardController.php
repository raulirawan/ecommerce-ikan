<?php

namespace App\Http\Controllers\Penjual;

use App\Produk;
use App\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pendapatan = Transaksi::where('status','DITERIMA')->where('penjual_id', Auth::user()->id)->sum('total_harga_bersih');
        $countTransaksiBerhasil = Transaksi::whereIn('status',['DITERIMA','SUCCESS'])->where('penjual_id', Auth::user()->id)->count();
        $countProduk = Produk::where('user_id', Auth::user()->id)->count();
        return view('penjual.dashboard', compact('pendapatan','countTransaksiBerhasil','countProduk'));
    }
}
