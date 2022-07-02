<?php

namespace App\Http\Controllers\Admin;

use App\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        if(request()->ajax()) {
            if (!empty($request->from_date)) {
                if ($request->from_date === $request->to_date) {
                    $query  = Transaksi::query();
                    if ($request->status_transaksi != 'SEMUA') {
                        $query->with(['user','penjual'])
                        ->whereDate('created_at', $request->from_date)
                        ->where('status', $request->status_transaksi);
                    }else {
                        $query->with(['user','penjual'])
                        ->whereDate('created_at', $request->from_date);
                    }


                } else {
                    $query  = Transaksi::query();
                    if ($request->status_transaksi != 'SEMUA') {
                        $query->with(['user','penjual'])
                        ->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59'])
                        ->where('status', $request->status_transaksi);
                    } else {
                        $query->with(['user','penjual'])
                        ->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
                    }


                }
            } else {
                $today = date('Y-m-d');
                $query  = Transaksi::query();
                if ($request->status_transaksi != 'SEMUA') {
                    $query->with(['user','penjual'])
                    ->whereDate('created_at', $today)
                    ->where('status', $request->status_transaksi);
                } else {
                    $query->with(['user','penjual'])
                    ->whereDate('created_at', $today);
                }


            }
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                        return '
                        <a
                        href="'.route('admin.transaksi.detail', $item->id).'"
                        class="btn btn-sm font-sm rounded btn-brand"
                        >Detail</a>
                        ';
                })
                ->editColumn('harga', function($item) {
                    return number_format($item->total_harga);
                })
                ->editColumn('status', function($item) {
                    if($item->status == 'PENDING') {
                        return '<span class="badge bg-warning">PENDING</span>';
                    } else if($item->status == 'SUCCESS') {
                        return '<span class="badge bg-success">SUCCESS</span>';
                    }else if($item->status == 'DELIVERED') {
                        return '<span class="badge bg-success">DELIVERED</span>';
                    }else if($item->status == 'CANCELLED') {
                        return '<span class="badge bg-danger">CANCELLED</span>';
                    } else {
                        return '<span class="badge bg-danger">NOTHING</span>';
                    }
                })
                ->editColumn('created_at', function($item) {
                    return $item->created_at;
                })
                ->rawColumns(['action','harga','created_at','status'])
                ->make();
        }
        return view('admin.transaksi.index');
    }

    public function detail($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('admin.transaksi.detail', compact('transaksi'));
    }
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->no_resi = $request->no_resi;
        $transaksi->save();

        if($transaksi != null) {
            Alert::success('Success','Data Berhasil di Tambah');
            return redirect()->route('admin.transaksi.detail', $id);
        }else {
            Alert::error('Error','Data Gagal di Tambah');
            return redirect()->route('admin.transaksi.detail', $id);
        }
    }
}
