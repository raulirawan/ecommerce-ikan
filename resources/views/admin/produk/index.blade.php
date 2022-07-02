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
    </style>
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Halaman Produk </h2>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <button data-toggle="modal" data-target="#modal-create" class="btn btn-md rounded font-sm">(+) Tambah Produk</button>
                <div class="table-responsive">
                    <table class="table w-100 mt-2" id="table-data">
                        <thead>
                            <tr>
                                <th style="width: 10%">#ID</th>
                                <th>Foto Produk</th>
                                <th>Nama Produk</th>
                                <th>Penjual</th>
                                <th>Harga</th>
                                <th>Stok (KG)</th>
                                <th style="width: 15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div> <!-- table-responsive //end -->
            </div> <!-- card-body end// -->
        </div> <!-- card end// -->
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
                    <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
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
                                <label for="exampleInputEmail1">Deskripsi (opsional)</label>
                                <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Masukan Deskripsi">{{ old('deskripsi') }}</textarea>
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
