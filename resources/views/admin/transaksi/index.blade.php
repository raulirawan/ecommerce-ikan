@extends('layouts.admin')

@section('title', 'Halaman Transaksi')

@section('content')
    <style>
        .dataTables_filter {
            margin-bottom: 20px;
        }
    </style>
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Halaman Transaksi </h2>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row input-daterange ml-2 my-2">
                    <div class="col-md-3">
                        <input type="date" name="from_date" id="from_date" value="{{ date('Y-m-d', strtotime('-7 days')) }}" class="form-control"
                            placeholder="From Date" />
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="to_date" id="to_date"  value="{{ date('Y-m-d') }}" class="form-control"
                            placeholder="To Date" />
                    </div>
                    <div class="col-md-3">
                        <select name="status_transaksi" id="status_transaksi" class="form-control">
                            <option value="SEMUA">SEMUA</option>
                            <option value="SUCCESS">DELIVERED</option>
                            <option value="SUCCESS">SUCCESS</option>
                            <option value="PENDING">PENDING</option>
                            <option value="CANCELLED">CANCELLED</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" name="filter" id="filter" class="btn btn-primary">Filter</button>
                        <button type="button" name="refresh" id="refresh"
                            class="btn btn-default">Refresh</button>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table w-100 mt-2" id="table-data">
                        <thead>
                            <tr>
                                <th style="width: 10%">Tanggal Transaksi</th>
                                <th>Kode</th>
                                <th>Pembeli</th>
                                <th>Penjual</th>
                                <th>Status</th>
                                <th>Total Harga</th>
                                <th style="width: 15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5">Total</th>
                                <th id="total"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div> <!-- table-responsive //end -->
            </div> <!-- card-body end// -->
        </div> <!-- card end// -->
    </section> <!-- content-main end// -->
       @push('down-script')
       <script>
        $(document).ready(function() {
           function numberWithCommas(x) {
           return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
           }

           var status_transaksi = $('select[name=status_transaksi] option').filter(':selected').val();
           var from_date = $('#from_date').val();
           var to_date = $('#to_date').val();
           load_data(from_date, to_date, status_transaksi);

           $('#filter').click(function() {
               var from_date = $('#from_date').val();
               var to_date = $('#to_date').val();
               var status_transaksi = $('select[name=status_transaksi] option').filter(':selected').val();
               if (from_date != '' && to_date != '') {
                   $('#table-data').DataTable().destroy();
                   load_data(from_date, to_date, status_transaksi);
               } else {
                   alert('Silahkan Pilih Tanggal')
               }
           });

           $('#refresh').click(function() {
               var status_transaksi = $('select[name=status_transaksi] option').filter(':selected').val();
               var from_date = $('#from_date').val();
               var to_date = $('#to_date').val();
               $('#table-data').DataTable().destroy();
               load_data(from_date, to_date, status_transaksi);
           });

           function load_data(from_date = '', to_date = '', status_transaksi = '') {
               var datatable = $('#table-data').DataTable({
                   processing: true,
                   serverSide: true,
                   ordering: true,
                   ajax: {
                       url: '{!! url()->current() !!}',
                       type: 'GET',
                       data: {
                           from_date: from_date,
                           to_date: to_date,
                           status_transaksi: status_transaksi,
                       }
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
                           data: 'kode_transaksi',
                           name: 'kode_transaksi'
                       },
                       {
                           data: 'user.name',
                           name: 'user.name'
                       },
                       {
                           data: 'penjual.name',
                           name: 'penjual.name'
                       },
                       {
                           data: 'status',
                           name: 'status'
                       },
                       {
                           data: 'total_harga',
                           name: 'total_harga',
                           render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                       },
                       {
                           data: 'action',
                           name: 'action',
                           orderable: false,
                           searcable: false,
                           width: '10%',
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
                           .column(5)
                           .data()
                           .reduce(function(a, b) {
                               return intVal(a) + intVal(b);
                           }, 0);

                       // Total over this page
                       price = api
                           .column(5, {
                               page: 'current'
                           })
                           .data()
                           .reduce(function(a, b) {
                               return intVal(a) + intVal(b);
                           }, 0);

                       $(api.column(5).footer()).html(
                           'Rp' + price
                       );

                       var numFormat = $.fn.dataTable.render.number('\,', 'Rp').display;
                       $(api.column(5).footer()).html(
                           'Rp ' + numFormat(price)
                       );
                   }

               });
           }


       });
   </script>
       @endpush
@endsection
