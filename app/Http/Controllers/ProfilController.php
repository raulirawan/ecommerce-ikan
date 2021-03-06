<?php

namespace App\Http\Controllers;

use App\User;
use App\Transaksi;
use App\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilController extends Controller
{
    public function index()
    {
        return view('page.akun');
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $user->name = $request->name;
        $user->no_hp = $request->no_hp;
        $user->save();

        if ($user != null) {
            Alert::success('Success', 'Data Berhasil di Update');
            return back()->withInput(['tab' => 'account-detail']);
        } else {
            Alert::error('Error', 'Data Gagal di Update');
            return back()->withInput(['tab' => 'account-detail']);
        }
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'oldPassword' => 'required',
            'password' => 'required|confirmed',

        ]);

        if (!(Hash::check($request->get('oldPassword'), Auth::user()->password))) {
            Alert::error('Error', 'Password Lama Anda Salah');
            return back()->withInput(['tab' => 'account-detail']);
        }

        if (strcmp($request->get('oldPassword'), $request->get('password')) == 0) {
            Alert::error('Error', 'Password Lama Anda Tidak Boleh Sama Dengan Password Baru');
            return back()->withInput(['tab' => 'account-detail']);
        }

        $user = Auth::user();
        $user->password = bcrypt($request->get('password'));
        $user->save();

        Alert::success('Success', 'Password Anda Berhasil di Ganti');
        return back()->withInput(['tab' => 'account-detail']);
    }

    public function transaksiDetail($id)
    {
        $transaksi = TransaksiDetail::with(['produk','transaksi'])->where('transaksi_id', $id)->get();
        return response()->json($transaksi);
    }

    public function terimaBarang($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->status = 'DITERIMA';

        $komisi = $transaksi->total_harga / 100 * 5;


        $total_harga_bersih = $transaksi->total_harga - $komisi;
        $transaksi->komisi = $komisi;

        $transaksi->total_harga_bersih = $total_harga_bersih;

        $penjual = User::findOrFail($transaksi->penjual_id);

        $penjual->saldo = $penjual->saldo + $total_harga_bersih;
        $penjual->save();

        $transaksi->save();

        if ($transaksi != null) {
            Alert::success('Success', 'Data Berhasil di Update');
            return back()->withInput(['tab' => 'orders']);
        } else {
            Alert::error('Error', 'Data Gagal di Update');
            return back()->withInput(['tab' => 'orders']);
        }
    }
}
