<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Withdraw;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class WithdrawController extends Controller
{
    public function index(Request $request)
    {
        if(request()->ajax()) {
            $query = Withdraw::query();
            $query->with(['user']);
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                      if($item->status == 'PENDING') {
                        return '
                        <button
                        id="terima"
                        data-toggle="modal"
                        data-target="#modal-terima"
                        data-id="'.$item->id.'"
                         class="btn btn-sm font-sm rounded btn-brand"><i class="fa fa-eye"></i> Terima</button>
                        <a href="'.route('admin.withdraw.tolak', $item->id).'" class="btn btn-sm btn-danger font-sm rounded" onclick="return confirm('."'Yakin ?'".')"><i class="fa fa-eye"></i> Tolak</a>
                        ';
                      }
                })
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
        return view('admin.withdraw.index');
    }

    public function terima(Request $request ,$id)
    {
        $withdraw = Withdraw::findOrFail($id);

        if($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $tujuan_upload = 'image/bukti-transfer/';
            $nama_file = time()."_".$file->getClientOriginalName();
            $nama_file = str_replace(' ', '', $nama_file);
            $file->move($tujuan_upload,$nama_file);

            $withdraw->bukti = $tujuan_upload.$nama_file;
        }
        // update saldo user
        $user = User::findOrFail($withdraw->user_id);

        $user->saldo = $user->saldo - $withdraw->nominal;
        $user->save();

        // update stattus withdraw
        $withdraw->status = 'ACCEPT';
        $withdraw->save();

        if($withdraw != null) {
            Alert::success('Success','Withdraw Di Terima');
            return redirect()->route('admin.withdraw.index');
        }else {
            Alert::error('Error','Ada Kesalahan Coba Lagi!');
            return redirect()->route('admin.withdraw.index');
        }
    }
    public function tolak($id)
    {
        $withdraw = Withdraw::findOrFail($id);

          // update stattus withdraw
          $withdraw->status = 'REJECT';
          $withdraw->save();


        if($withdraw != null) {
            Alert::success('Success','Withdraw Di Tolak');
            return redirect()->route('admin.withdraw.index');
        }else {
            Alert::error('Error','Ada Kesalahan Coba Lagi!');
            return redirect()->route('admin.withdraw.index');
        }
    }
}
