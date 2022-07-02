@extends('layouts.admin')

@section('title', 'Halaman Produk')

@section('content')
    <style>
        .dataTables_filter {
            margin-bottom: 20px;
        }
        table td {
            vertical-align: middle;
        }
        .photo-gallery a {
            display: block;
        }
         .photo-gallery .btn-danger {
            background-color: #c20041 !important;
        }

    </style>
  <section class="content-main">
    <div class="row">
        <div class="col-9">
            <div class="content-header">
                <h2 class="content-title">Edit Data Produk</h2>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Form Edit Data Produk</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('penjual.produk.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="product_name" class="form-label">Penjual</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                @foreach (App\User::where('roles','PENJUAL')->get() as $penjual)
                                    <option value="{{ $penjual->id }}" {{ $penjual->id == $data->user_id ? 'selected' : '' }}>{{ $penjual->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="product_name" class="form-label">Nama Produk</label>
                            <input type="text" placeholder="Masukan Nama Produk" name="nama_produk" value="{{ $data->nama_produk }}" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Harga</label>
                                    <input type="number" placeholder="Masukan Harga Produk" name="harga" value="{{ $data->harga }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Stok</label>
                                    <input type="number" placeholder="Masukan Stok Produk" name="stok" value="{{ $data->stok }}" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Deskripsi (opsional)</label>
                            <textarea placeholder="Masukan Deskripsi" class="form-control" name="deskripsi" rows="4">{{ $data->deskripsi }}</textarea>
                        </div>

                        @if ($data->gambar != null)
                        <div class="row mb-2 photo-gallery">
                            @php
                                $gambar = json_decode($data->gambar)
                            @endphp
                            @foreach ($gambar as $key => $val)
                            <div class="col-4">
                                <img src="{{ asset($val) }}" class="img-fluid">
                                <a href="{{ route('penjual.produk.delete.gambar',[$data->id, $key]) }}" class="btn btn-danger rounded btn-sm badge btn-block">Hapus</a>
                            </div>
                            @endforeach
                        </div>
                        @endif
                         <div class="mb-4">
                            <label for="product_name" class="form-label">Gambar</label>
                            <input type="file" name="gambar[]"  class="form-control" multiple>
                            @if ($errors->has('gambar.*'))
                            <span class="text-danger">{{ $errors->first('gambar.*') }}</span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-md rounded font-sm">Simpan Data</button>
                    </form>
                </div>
            </div> <!-- card end// -->

        </div>

    </div>
</section> <!-- content-main end// -->

    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('penjual.produk.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Penjual</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="">Pilih Penjual</option>
                                    @foreach (App\User::where('roles','PENJUAL')->get() as $penjual)
                                        <option value="{{ $penjual->id }}">{{ $penjual->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Nama Produk</label>
                                <input type="text" class="form-control" value="{{ old('nama_produk') }}"
                                    name="nama_produk" placeholder="Masukan Nama Produk" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Stok (KG)</label>
                                <input type="number" class="form-control" value="{{ old('stok') }}"
                                    name="stok" placeholder="Masukan Stok Barang" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Harga</label>
                                <input type="number" class="form-control" value="{{ old('harga') }}"
                                    name="harga" placeholder="Masukan Harga Barang" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Gambar</label>
                                <input type="file" class="form-control"
                                    name="gambar[]" placeholder="Masukan Harga Barang" required multiple>
                                @if ($errors->has('gambar.*'))
                                    <span class="text-danger">{{ $errors->first('gambar.*') }}</span>
                                @endif
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
                </form>

            </div>
        </div>
    </div>

    @push('down-script')
    @if ($errors->has('gambar.*'))
        <script type="text/javascript">
            $('#modal-create').modal('show');
        </script>
    @endif
        <script>
            $(document).ready(function() {
                var datatable = $('#table-data').DataTable({
                    processing: true,
                    serverSide: true,
                    ordering: true,
                    ajax: {
                        url: '{!! url()->current() !!}',
                        type: 'GET',
                    },
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'pdfHtml5',
                            orientation: 'potrait',
                            footer: true,
                        },
                        {
                            extend: 'excelHtml5',
                            footer: true,
                        }
                    ],

                    columns: [
                        {
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'gambar',
                            name: 'gambar'
                        },
                        {
                            data: 'nama_produk',
                            name: 'nama_produk'
                        },
                        {
                            data: 'user.name',
                            name: 'user.name'
                        },
                        {
                            data: 'harga',
                            name: 'harga'
                        },
                        {
                            data: 'stok',
                            name: 'stok'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searcable: false,
                        }
                    ],

                    "footerCallback": function(row, data) {
                        var api = this.api(),
                            data;

                        var intVal = function(i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                i : 0;
                        };

                        total = api
                            .column(4)
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        // Total over this page
                        price = api
                            .column(4, {
                                page: 'current'
                            })
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        $(api.column(4).footer()).html(
                            'Rp' + price
                        );

                        var numFormat = $.fn.dataTable.render.number('\,', 'Rp').display;
                        $(api.column(4).footer()).html(
                            'Rp ' + numFormat(price)
                        );
                    }

                });
            });
        </script>
    @endpush
@endsection
