@extends('layouts.frontend')

@section('title', 'Akun Saya')

@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ url('/') }}" rel="nofollow">Home</a>
                <span></span> Akun Saya
            </div>
        </div>
    </div>
    <section class="pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="dashboard-menu">
                                <ul class="nav flex-column tabs" id="nav-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard"
                                            role="tab" aria-controls="dashboard" aria-selected="false"><i
                                                class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders"
                                            role="tab" aria-controls="orders" aria-selected="false"><i
                                                class="fi-rs-shopping-bag mr-10"></i>Order</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab"
                                            href="#account-detail" role="tab" aria-controls="account-detail"
                                            aria-selected="true"><i class="fi-rs-user mr-10"></i>Profil</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><i
                                                class="fi-rs-sign-out mr-10"></i>Logout</a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="tab-content dashboard-content">
                                <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                    aria-labelledby="dashboard-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Halo {{ ucfirst(Auth::user()->name) }}! </h5>
                                        </div>
                                        <div class="card-body">
                                            <p>Halaman Ini adalah Halaman Profil Anda Untuk Melihat Data Transaksi Dan Juga
                                                Update Profil Anda</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Orderan Anda</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Kode Transaksi</th>
                                                            <th>Penjual</th>
                                                            <th>Tanggal</th>
                                                            <th>Status</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach (App\Transaksi::where('user_id', Auth::user()->id)->get() as $transaksi)
                                                            <tr>
                                                                <td>#{{ $transaksi->kode_transaksi }}</td>
                                                                <td>{{ $transaksi->penjual->name }}</td>
                                                                <td>{{ $transaksi->created_at }}</td>
                                                                <td>{{ $transaksi->status }}</td>
                                                                <td>{{ number_format($transaksi->total_harga) }}</td>
                                                                <td>
                                                                    <a  href="#"
                                                                        onclick="detailTransaction({{ $transaksi->id }})"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#modal-detail"
                                                                        class="btn-small btn btn-sm btn-info d-block mb-2">Detail</a>
                                                                    @if ($transaksi->status == 'DELIVERED')
                                                                    <a href="{{ route('terima.barang', $transaksi->id) }}"
                                                                    class="btn-small btn btn-sm btn-info d-block mb-2"
                                                                    onclick="return confirm('Barang Sudah Di Terima ?')">Terima</a>
                                                                    @endif
                                                                    @if ($transaksi->status == 'PENDING')
                                                                    <a href="{{ $transaksi->link_pembayaran ?? '' }}"
                                                                    target="_blank"
                                                                    class="btn-small btn btn-sm btn-info d-block mb-2">Bayar</a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="account-detail" role="tabpanel"
                                    aria-labelledby="account-detail-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Profil</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{ route('profil.update') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label>Nama Lengkap <span class="required">*</span></label>
                                                        <input required="" class="form-control square" name="name"
                                                            type="text" value="{{ Auth::user()->name }}">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Nomor Handphone <span class="required">*</span></label>
                                                        <input required="" class="form-control square" name="no_hp"
                                                            type="number" value="{{ Auth::user()->no_hp }}">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Alamat Email <span class="required">*</span></label>
                                                        <input required="" class="form-control square" type="email"
                                                            disabled value="{{ Auth::user()->email }}">
                                                    </div>

                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-fill-out submit"
                                                            name="submit" value="Submit">Save</button>
                                                    </div>
                                                </div>
                                            </form>


                                        </div>
                                    </div>
                                    <div class="card mt-3">
                                        <div class="card-header">
                                            <h5>Ganti Password</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{ route('change.password') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label>Password Lama <span class="required">*</span></label>
                                                        <input type="password" name="oldPassword"
                                                            class="form-control @error('oldPassword') is-invalid @enderror"
                                                            autocomplete="off" placeholder="Password Lama" required>
                                                        <div class="invalid-feedback">
                                                            Masukan Password Lama
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Password Baru <span class="required">*</span></label>
                                                        <input type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            name="password" placeholder="Password Baru" required>
                                                        <div class="invalid-feedback">
                                                            Konfirmasi Password Baru Tidak Sesuai
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Konfirmasi Password Baru <span
                                                                class="required">*</span></label>
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                                            placeholder="Konfirmasi Password Baru" required>
                                                        <div class="invalid-feedback">
                                                            Konfirmasi Password Baru Tidak Sesuai
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-fill-out submit"
                                                            name="submit" value="Submit">Save</button>
                                                    </div>
                                                </div>
                                            </form>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade bd-example-modal-lg" data-target=".bd-example-modal-lg" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document" style="margin-top: 120px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Transaksi</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-lg">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Quantity</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody id="data-detail"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('down-script')
        <script>
            $(document).ready(function() {
                $('#nav-tab a[href="#{{ old('tab') }}"]').tab('show')
            });

            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            function detailTransaction(transaction_id) {
                $('#data-detail').html('');
                $.ajax({
                    url: window.location.origin + "/akun-saya/transaksi/detail/" + transaction_id,
                    method: 'get',
                    dataType: 'json',
                    success: function(e) {
                        let html = '';
                        e.forEach((val, item) => {
                            html += `
                                <tr>
                                    <td>
                                        <img src="${JSON.parse(val.produk.gambar)[0]}" style="width: 100px">
                                    </td>
                                    <td>${val.produk.nama_produk}</td>
                                    <td>${val.quantity} KG</td>
                                    <td>Rp${numberWithCommas(val.harga)}</td>
                                </tr>
                            `;
                        })
                        $('#data-detail').append(html)
                    },
                    error: function(e) {}
                })
            }
        </script>
    @endpush
@endsection
