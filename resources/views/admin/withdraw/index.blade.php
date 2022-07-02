@extends('layouts.admin')

@section('title', 'Halaman Withdraw')

@section('content')
    <style>
        .dataTables_filter {
            margin-bottom: 20px;
        }
        tbody .btn-danger {
            background-color: #c20041 !important;
        }
        tbody  td{
            vertical-align: middle;
        }
    </style>
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Halaman Withdraw </h2>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                {{-- <button data-toggle="modal" data-target="#modal-create" class="btn btn-md rounded font-sm">(+) Tambah Withdraw</button> --}}
                <div class="table-responsive">
                    <table class="table w-100 mt-2" id="table-data">
                        <thead>
                            <tr>
                                <th style="width: 10%">Tanggal Pengajuan</th>
                                <th>Penjual</th>
                                <th>Nominal</th>
                                <th>Bank</th>
                                <th>Nomor Rekening</th>
                                <th>Status</th>
                                <th>Bukti</th>
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

    <div class="modal fade" id="modal-terima" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Upload Bukti Transfer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form-terima" action="#" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="exampleInputEmail1">Bukti Transfer</label>
                            <input type="file" class="form-control"
                                name="bukti" required>
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
    <script>
        $(document).ready(function() {
            $(document).on('click', '#terima', function() {
                var id = $(this).data('id');
                $('#form-terima').attr('action','/admin/withdraw/terima/' + id);
            });
        });
    </script>
        <script>
            $(document).ready(function() {
                var datatable = $('#table-data').DataTable({
                    processing: true,
                    serverSide: true,
                    ordering: true,
                    order: [[ 0 , "desc" ]],
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
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'user.name',
                            name: 'user.name'
                        },
                        {
                            data: 'nominal',
                            name: 'nominal'
                        },
                         {
                            data: 'bank',
                            name: 'bank'
                        },
                         {
                            data: 'no_rek',
                            name: 'no_rek'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'bukti',
                            name: 'bukti'
                        },

                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searcable: false,
                        }
                    ],

                });
            });
        </script>
    @endpush
@endsection
