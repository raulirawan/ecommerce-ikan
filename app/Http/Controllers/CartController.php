<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        return view('page.cart', compact('carts'));
    }

    public function add($id)
    {
        $harga = Produk::where('id', $id)->first()->harga;
        $cart = new Cart();

        $dataCart = Cart::where('produk_id', $id)->where('user_id', Auth::user()->id)->first();
        if ($dataCart != null) {
            $dataCart->harga = $dataCart->harga + $harga * 1;
            $dataCart->quantity = $dataCart->quantity + 1;
            $dataCart->save();
        } else {
            $cart->produk_id = $id;
            $cart->harga = $harga;
            $cart->user_id = Auth::user()->id;
            $cart->quantity = 1;
            $cart->save();
        }

        if ($cart != null || $dataCart != null) {
            Alert::success('Success', 'Data Keranjang Berhasil di Tambahkan');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Data Keranjang Berhasil di Tambahkan');
            return redirect()->back();
        }
    }
    public function delete($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();

        if ($cart != null) {
            $cart->delete();
            Alert::success('Success', 'Data Keranjang Berhasil di Hapus');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Data Keranjang Gagal di Hapus');
            return redirect()->back();
        }
    }

    public function addCart(Request $request)
    {
        $harga = Produk::where('id', $request->produk_id)->first()->harga;
        $cart = new Cart();

        $dataCart = Cart::where('produk_id', $request->produk_id)->where('user_id', Auth::user()->id)->first();
        if ($dataCart != null) {
            $dataCart->harga = $dataCart->harga + $harga * $request->quantity;
            $dataCart->quantity = $dataCart->quantity + $request->quantity;
            $dataCart->save();
        } else {
            $cart->produk_id = $request->produk_id;
            $cart->harga = $harga * $request->quantity;
            $cart->user_id = Auth::user()->id;
            $cart->quantity = $request->quantity;
            $cart->save();
        }

        if ($cart != null || $dataCart != null) {
            Alert::success('Success', 'Data Keranjang Berhasil di Tambahkan');
            return redirect()->route('cart.index');
        } else {
            Alert::error('Error', 'Data Keranjang Berhasil di Tambahkan');
            return redirect()->route('cart.index');
        }
    }
}
