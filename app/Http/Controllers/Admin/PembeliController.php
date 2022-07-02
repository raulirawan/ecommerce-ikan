<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PembeliController extends Controller
{
    public function index(Request $request)
    {
        if(request()->ajax()) {
            $query = User::query();
            $query->where('roles','PEMBELI');
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                        return '
                        <button
                        id="edit"
                        data-toggle="modal"
                        data-target="#modal-edit"
                        class="btn btn-sm font-sm rounded btn-brand"
                        data-id="'.$item->id.'"
                        data-nama_pembeli="'.$item->name.'"
                        data-email="'.$item->email.'"
                        data-no_hp="'.$item->no_hp.'"
                        >Edit</button>
                        <a href="'.route('admin.pembeli.delete', $item->id).'" class="btn btn-sm font-sm btn-light rounded" onclick="return confirm('."'Yakin ?'".')"><i class="fa fa-eye"></i> Delete</a>
                        ';
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at;
                })

                ->rawColumns(['action'])
                ->make();
        }
        return view('admin.pembeli.index');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'email' => 'unique:users,email'
            ],
            [
                'email.unique' => 'Email Sudah Terdaftar'
            ]
        );
        $data = new User();
        $data->name = $request->nama_pembeli;
        $data->email = $request->email;
        $data->no_hp = $request->no_hp;
        $data->password = bcrypt($request->password);
        $data->roles = 'PEMBELI';
        $data->save();

        if($data != null) {
            Alert::success('Sukses','Data Berhasil di Tambahkan');
            return redirect()->route('admin.pembeli.index');
        } else {
            Alert::error('Gagal','Data Gagal di Tambahkan');
            return redirect()->route('admin.pembeli.index');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'email_edit' => 'unique:users,email,'.$id,
            ],
            [
                'email_edit.unique' => 'Email Sudah Terdaftar'
            ]
        );
        $data = User::findOrFail($id);
        $data->name = $request->nama_pembeli;
        $data->email = $request->email_edit;
        $data->no_hp = $request->no_hp;
        $data->save();

        if($data != null) {
            Alert::success('Sukses','Data Berhasil di Update');
            return redirect()->route('admin.pembeli.index');
        } else {
            Alert::error('Gagal','Data Gagal di Update');
            return redirect()->route('admin.pembeli.index');
        }
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);
            if($data != null) {
                $data->delete();
            Alert::success('Sukses','Data Berhasil di Hapus');
            return redirect()->route('admin.pembeli.index');
        } else {
            Alert::error('Gagal','Data Gagal di Hapus');
            return redirect()->route('admin.pembeli.index');
        }

    }
}
