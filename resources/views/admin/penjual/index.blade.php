@extends('layouts.admin')

@section('title', 'Halaman Penjual')

@section('content')
    <style>
        .dataTables_filter {
            margin-bottom: 20px;
        }
    </style>
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Halaman Penjual </h2>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <button data-toggle="modal" data-target="#modal-create" class="btn btn-md rounded font-sm">(+) Tambah Penjual</button>
                <div class="table-responsive">
                    <table class="table w-100 mt-2" id="table-data">
                        <thead>
                            <tr>
                                <th style="width: 10%">#ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Nomor HP</th>
                                <th>Saldo</th>
                                <th>Tanggal Daftar</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Penjual</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.penjual.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Nama Penjual</label>
                                <input type="text" class="form-control" value="{{ old('nama_penjual') }}"
                                    name="nama_penjual" placeholder="Masukan Nama" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" value="{{ old('email') }}"
                                    name="email" placeholder="Masukan Email" required>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="password" class="form-control" value="{{ old('password') }}"
                                    name="password" placeholder="Masukan Password" required>
                            </div>
                             <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Nomor Handphone</label>
                                <input type="number" class="form-control" value="{{ old('no_hp') }}"
                                    name="no_hp" placeholder="Masukan Nomor Handphone" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Nama Bank</label>
                                <select name="nama_bank" id="nama_bank" class="form-select" required>
                                    <option value="">Pilih Bank</option>
                                    <option value="BCA">BCA</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BRI">BRI</option>
                                    <option value="CIMB NIAGA">CIMB NIAGA</option>
                                    <option value="PERMATA BANK">PERMATA BANK</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Nomor Handphone</label>
                                <input type="number" class="form-control" name="no_rek" placeholder="Masukan Nomor Rekening" required>

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

       <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Foem Edit Data Penjual</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="form-edit" action="#" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Nama Penjual</label>
                                <input type="text" class="form-control" value="{{ old('nama_penjual') }}" id="nama_penjual"
                                    name="nama_penjual" placeholder="Masukan Nama" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" value="{{ old('email_edit') }}" id="email"
                                    name="email_edit" placeholder="Masukan Email" required>
                                @if ($errors->has('email_edit'))
                                    <span class="text-danger">{{ $errors->first('email_edit') }}</span>
                                @endif
                            </div>
                             <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Nomor Handphone</label>
                                <input type="number" class="form-control" value="{{ old('no_hp') }}" id="no_hp"
                                    name="no_hp" placeholder="Masukan Nomor Handphone" required>
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
    @if ($errors->has('email'))
        <script type="text/javascript">
            $('#modal-create').modal('show');
        </script>
    @endif
    @if ($errors->has('email_edit'))
    <script type="text/javascript">
        $('#modal-edit').modal('show');
    </script>
@endif
        <script>
            $(document).ready(function() {
                $(document).on('click', '#edit', function() {
                    var id = $(this).data('id');
                    var nama_penjual = $(this).data('nama_penjual');
                    var email = $(this).data('email');
                    var no_hp = $(this).data('no_hp');
                    $('#nama_penjual').val(nama_penjual);
                    $('#email').val(email);
                    $('#no_hp').val(no_hp);
                    $('#form-edit').attr('action','/admin/penjual/update/' + id);
                });
            });
        </script>
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
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'no_hp',
                            name: 'no_hp'
                        },
                        {
                            data: 'saldo',
                            name: 'saldo'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
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
