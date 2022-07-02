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
    </style>
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Halaman Withdraw </h2>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <form method="POST" action="{{ route('penjual.bank.create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                          <div class="col-3">
                            <select name="nama_bank" id="nama_bank" class="form-select" required>
                                <option value="">Pilih Bank</option>
                                <option value="BCA">BCA</option>
                                <option value="BNI">BNI</option>
                                <option value="BRI">BRI</option>
                                <option value="CIMB NIAGA">CIMB NIAGA</option>
                                <option value="PERMATA BANK">PERMATA BANK</option>
                            </select>
                          </div>
                          <div class="col-3">
                            <input type="number" class="form-control" name="no_rek" placeholder="Nomor Rekening" required>
                          </div>
                          <div class="col-3 align-self-center">
                            <button type="submit" class="btn btn-sm rounded btn-brand">Simpan</button>
                          </div>
                        </div>
                      </form>
                </div>
                <div class="table-responsive">
                    <table class="table w-100 mt-2" id="table-data">
                        <thead>
                            <tr>
                                <th>Nama Bank</th>
                                <th>Nomor Rekening</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div> <!-- table-responsive //end -->
            </div> <!-- card-body end// -->
        </div> <!-- card end// -->
    </section> <!-- content-main end// -->


    @push('down-script')
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
                            data: 'nama_bank',
                            name: 'nama_bank'
                        },
                        {
                            data: 'no_rek',
                            name: 'no_rek',
                        },
                        {
                            data: 'action',
                            name: 'action',
                        },
                    ],

                });
            });
        </script>
    @endpush
@endsection
