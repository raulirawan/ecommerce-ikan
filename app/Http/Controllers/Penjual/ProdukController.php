<?php

namespace App\Http\Controllers\Penjual;

use App\Produk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        if(request()->ajax()) {
            $query = Produk::query();
            $query->where('user_id', Auth::user()->id);
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                        return '
                        <a
                        href="'.route('penjual.produk.edit', $item->id).'"
                        class="btn btn-sm font-sm rounded btn-brand"

                        >Edit</a>
                        <a href="'.route('penjual.produk.delete', $item->id).'" class="btn btn-sm font-sm btn-light rounded" onclick="return confirm('."'Yakin ?'".')"><i class="fa fa-eye"></i> Delete</a>
                        ';
                })
                ->editColumn('gambar', function($item) {
                    $gambar = json_decode($item->gambar)[0];
                    return '<img class="img-fluid" src="'.asset($gambar).'" style="width: 100px">';
                })
                ->editColumn('harga', function($item) {
                    return number_format($item->harga);
                })
                ->rawColumns(['action','gambar','harga'])
                ->make();
        }
        return view('penjual.produk.index');
    }


    public function store(Request $request)
    {
        $request->validate(
            [
            'gambar.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
            'gambar.*.mimes' => 'Gambar Harus Bertipe PNG, JPG, JPEG atau BMP',
            ]
        );

        $data = new Produk();
        $data->user_id = Auth::user()->id;
        $data->nama_produk = $request->nama_produk;
        $data->slug = Str::slug($request->nama_produk);
        $data->stok = $request->stok;
        $data->harga = $request->harga;
        $data->deskripsi = $request->deskripsi;

        if($request->hasFile('gambar')) {
            $dataGambar = [];
            foreach ($request->file('gambar') as $key => $val) {
                $tujuan_upload = 'image/produk/';
                $nama_file = time()."_".$val->getClientOriginalName();
                $nama_file = str_replace(' ', '', $nama_file);
                $val->move($tujuan_upload,$nama_file);

                $dataGambar[] =$tujuan_upload.$nama_file;
            }
            $gambar = json_encode($dataGambar);
            $data->gambar = $gambar;
        }

        $data->save();

        if($data != null) {
            Alert::success('Success','Data Berhasil di Tambah');
            return redirect()->route('penjual.produk.index');
        }else {
            Alert::error('Error','Data Gagal di Tambah');
            return redirect()->route('penjual.produk.index');
        }
    }

    public function edit($id)
    {
        $data = Produk::findOrFail($id);
        return view('penjual.produk.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
            'gambar.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
            'gambar.*.mimes' => 'Gambar Harus Bertipe PNG, JPG, JPEG atau BMP',
            ]
        );

        $data = Produk::findOrFail($id);
        $data->user_id = Auth::user()->id;
        $data->nama_produk = $request->nama_produk;
        $data->slug = Str::slug($request->nama_produk);
        $data->stok = $request->stok;
        $data->harga = $request->harga;
        $data->deskripsi = $request->deskripsi;


        if($request->hasFile('gambar')) {
            $dataGambar = [];
            foreach ($request->file('gambar') as $key => $val) {
                $tujuan_upload = 'image/produk/';
                $nama_file = time()."_".$val->getClientOriginalName();
                $nama_file = str_replace(' ', '', $nama_file);
                $val->move($tujuan_upload,$nama_file);

                $dataGambar[] =$tujuan_upload.$nama_file;
            }
            if($data->gambar != null) {
                $oldGambar = json_decode($data->gambar);
                $newGambar = array_merge($oldGambar, $dataGambar);
                $gambar = json_encode($newGambar);

            } else {
                $gambar = json_encode($dataGambar);
            }

        $data->gambar = $gambar;
        }
        $data->save();
        if($data != null) {
            Alert::success('Success','Data Berhasil di Update');
            return redirect()->route('penjual.produk.index');
        }else {
            Alert::error('Error','Data Gagal di Update');
            return redirect()->route('penjual.produk.index');
        }
    }

    public function delete($id)
    {
        $data = Produk::findOrFail($id);
        if($data != null) {
            $gambar = json_decode($data->gambar);
            foreach ($gambar as $value) {
                if(file_exists($value)) {
                    unlink($value);
                }
            }
            $data->delete();
            Alert::success('Success','Data Berhasil di Hapus');
            return redirect()->route('penjual.produk.index');
        }else {
            Alert::error('Error','Data Gagal di Hapus');
            return redirect()->route('penjual.produk.index');
        }

    }

    public function deleteGambar($id, $keyGambar)
    {
        $data = Produk::findOrFail($id);

        $gambar = json_decode($data->gambar);
        $gambarBaru = [];

        foreach ($gambar as $key => $value) {
            if($key == $keyGambar)
            {
                if(file_exists($value)) {
                    unlink($value);
                }
                unset($value);
            }else {
                $gambarBaru[] = $value;
            }
        }

        $data->gambar = json_encode($gambarBaru);
        $data->save();
        if($data != null) {
            Alert::success('Success','Data Berhasil di Hapus');
            return redirect()->route('penjual.produk.edit', $id);
        }else {
            Alert::error('Error','Data Gagal di Hapus');
            return redirect()->route('penjual.produk.edit', $id);
        }
    }
}

