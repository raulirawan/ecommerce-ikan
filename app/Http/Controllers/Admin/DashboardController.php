<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Produk;
use App\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $pendapatan = Transaksi::where('status','DITERIMA')->sum('komisi');
        $countTransaksiBerhasil = Transaksi::whereIn('status',['DITERIMA','SUCCESS'])->count();
        $countProduk = Produk::count();
        $countPenjual = User::where('roles','PENJUAL')->count();
        return view('admin.dashboard', compact('pendapatan','countTransaksiBerhasil','countProduk','countPenjual'));
    }
}
