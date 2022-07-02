<?php

namespace App\Http\Controllers;

use App\User;
use App\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $penjual = User::with(['produk'])->where('roles','PENJUAL')->get();
        return view('home', compact('penjual'));
    }
}
