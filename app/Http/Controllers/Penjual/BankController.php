<?php

namespace App\Http\Controllers\Penjual;

use App\Cart;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BankController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {
            $query = User::where('id', Auth::user()->id)->first();
            $bank = collect(json_decode($query->bank, true));
            return DataTables::of($bank)
                ->addColumn('action', function ($item) {
                    return '
                <a href="'.route('penjual.bank.delete', $item['no_rek']).'" class="btn btn-sm font-sm btn-danger rounded" onclick="return confirm(' . "'Yakin ?'" . ')"><i class="fa fa-eye"></i> Delete</a>
                ';
                })
                ->rawColumns(['action', 'status'])
                ->make();
        }
        return view('penjual.bank.index');
    }

    public function create(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $oldBank = json_decode($user->bank);
        $newBank = [];
        $newBank[] = [
            'nama_bank' => $request->nama_bank,
            'no_rek' => $request->no_rek,
        ];
        if($oldBank!=null) {
            $bank = array_merge($oldBank, $newBank);
        } else {
            $bank = $newBank;
        }
        $user->bank = json_encode($bank);

        $user->save();

        if($newBank != null) {
            Alert::success('Success','Data Berhasil di Tambahkan');
            return redirect()->route('penjual.bank.index');
        }else {
            Alert::error('Error','Data Gagal di Tambahkan');
            return redirect()->route('penjual.bank.index');
        }
    }

    public function deleteBank($norek)
    {
        $user = User::findOrFail(Auth::user()->id);

        $bank = json_decode($user->bank);
        $bankBaru = [];

        foreach ($bank as $key => $value) {
            if($value->no_rek == $norek)
            {
                unset($value);
            }else {
                $bankBaru[] = $value;
            }
        }
        $user->bank = json_encode($bankBaru);
        $user->save();
        if($user != null) {
            Alert::success('Success','Data Berhasil di Hapus');
            return redirect()->route('penjual.bank.index');
        }else {
            Alert::error('Error','Data Gagal di Hapus');
            return redirect()->route('penjual.bank.index');
        }
    }
}
