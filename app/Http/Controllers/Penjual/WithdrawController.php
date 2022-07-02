<?php

namespace App\Http\Controllers\Penjual;

use App\User;
use App\Withdraw;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class WithdrawController extends Controller
{
    public function index(Request $request)
    {
        if(request()->ajax()) {
            $query = Withdraw::query();
            $query->with(['user'])->where('user_id', Auth::user()->id);
            return DataTables::of($query)
                ->editColumn('created_at', function ($item) {
                    return $item->created_at;
                })
                ->editColumn('nominal', function ($item) {
                    return 'Rp'.number_format($item->nominal);
                })
                  ->editColumn('bukti', function ($item) {
                    if($item->bukti != null) {
                        return '<img src="'.asset($item->bukti).'" style="width: 100px;">';
                    } else {
                        return 'Belum Tersedia';
                    }
                })
                ->editColumn('status', function($item) {
                    if($item->status == 'PENDING') {
                        return '<span class="badge bg-warning">PENDING</span>';
                    } else if($item->status == 'ACCEPT') {
                        return '<span class="badge bg-success">ACCEPT</span>';
                    }else if($item->status == 'REJECT') {
                        return '<span class="badge bg-danger">REJECT</span>';
                    }else {
                        return '<span class="badge bg-danger">NOTHING</span>';
                    }
                })

                ->rawColumns(['action','status','bukti'])
                ->make();
        }
        return view('penjual.withdraw.index');
    }

    public function request(Request $request)
    {
        $id_user = Auth::user()->id;
        $user = User::findOrFail($id_user);

        if($user->saldo >= $request->nominal) {
            $bank = explode('-', $request->bank);
            $withdraw = new Withdraw;
            $withdraw->user_id = $id_user;
            $withdraw->nominal = $request->nominal;
            $withdraw->status = 'PENDING';
            $withdraw->bank = $bank[0];
            $withdraw->no_rek = $bank[1];
            $withdraw->save();

            if($withdraw != null) {
                Alert::success('Success','Pengajuan Sudah Di Terima');
                return redirect()->route('penjual.withdraw.index');
            }else {
                Alert::error('Error','Ada Yang Salah, Coba Lagi Ya!');
                return redirect()->route('penjual.withdraw.index');
            }

        }
        Alert::error("Gagal","Saldo Tidak Cukup!");
        return redirect()->route('penjual.withdraw.index');
    }

}
