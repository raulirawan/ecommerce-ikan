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
                @php
                    $pendingWithdraw = App\Withdraw::where('status','PENDING')->count();
                @endphp
                @if ($pendingWithdraw == 0)
                <button data-toggle="modal" data-target="#modal-create" class="btn btn-md rounded font-sm">(+) Request Withdraw</button>
                @endif
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
                <form method="POST" action="{{ route('penjual.withdraw.request') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="exampleInputEmail1">Nominal Withdraw</label>
                            <input type="number" class="form-control" value="{{ old('nominal') }}"
                                name="nominal" placeholder="Masukan Nominal" required>

                        </div>
                         <div class="form-group mb-3">
                            <label for="exampleInputEmail1">Bank</label>
                            @php
                                $bank = json_decode(App\User::where('id', Auth::user()->id)->first()->bank);
                            @endphp
                              <select name="bank" id="bank" class="form-control" required>
                                <option value="">Pilih Bank</option>
                                @foreach ($bank as $val)
                                <option value="{{ $val->nama_bank }}-{{ $val->no_rek }}">{{ $val->nama_bank }} - {{ $val->no_rek }}</option>
                                @endforeach
                              </select>

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
                            name: 'status',
                        },
                        {
                            data: 'bukti',
                            name: 'bukti'
                        },

                    ],

                });
            });
        </script>
    @endpush
@endsection
