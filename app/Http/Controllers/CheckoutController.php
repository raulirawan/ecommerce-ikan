<?php

namespace App\Http\Controllers;

use App\Cart;
use Exception;
use App\Transaksi;
use Midtrans\Snap;
use Midtrans\Config;
use App\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();

        if($carts->isNotEmpty()) {
            return view('page.checkout');

        } else {
            return redirect()->route('home.index');
        }
    }

    public function store(Request $request)
    {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        $kode = 'INV-'.mt_rand(00000,99999);

        $carts = Cart::where('user_id', Auth::user()->id);
        $carts = $carts->get();
        $harga = $carts->sum('harga');

        $penjual_id = $carts->first()->produk->user_id;

        // insert ke transaction
        $transaksi = new Transaksi();
        $transaksi->user_id = Auth::user()->id;
        $transaksi->penjual_id = $penjual_id;
        $transaksi->kode_transaksi = $kode;
        $transaksi->total_harga = $harga;
        $transaksi->alamat_pengiriman = $request->alamat_lengkap;
        $transaksi->provinsi = $request->provinsi;
        $transaksi->kota = $request->kota;
        $transaksi->kecamatan = $request->kecamatan;
        $transaksi->kelurahan = $request->kelurahan;
        $transaksi->status = 'PENDING';

        // midtrans
        $midtrans_params = [
            'transaction_details' => [
                'order_id' => $kode,
                'gross_amount' => (int) $harga,
            ],

            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            // 'callbacks' => [
            //     'finish' => 'https://murnicollection.my.id/success',
            // ],
            'enable_payments' => ['bca_va','permata_va','bni_va','bri_va','gopay'],
            'vtweb' => [],
        ];

        try {
            //ambil halaman payment midtrans

            $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;

            $transaksi->link_pembayaran = $paymentUrl;
            $transaksi->save();
             // insert ke detail
            foreach ($carts as $key => $cart) {
                $transaksiDetail = new TransaksiDetail();
                $transaksiDetail->transaksi_id = $transaksi->id;
                $transaksiDetail->produk_id = $cart->produk->id;
                $transaksiDetail->harga = $cart->produk->harga;
                $transaksiDetail->quantity = $cart->quantity;
                $transaksiDetail->save();
            }
            if($transaksi != null) {
                 // delete cart
                Cart::where('user_id', Auth::user()->id)->delete();

                return redirect($paymentUrl);
            } else {
                return redirect()->route('home.index');

            }
            //reditect halaman midtrans
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
