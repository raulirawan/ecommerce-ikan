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
                <h2 class="content-title card-title">Transaksi Detail</h2>
                <p>Detail Taransaksi Untuk Kode Transaksi: #{{ $transaksi->kode_transaksi }}</p>
            </div>
        </div>
        <div class="card">
            <header class="card-header">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 mb-lg-0 mb-15">
                        <span>
                            <i class="material-icons md-calendar_today"></i> <b>{{ $transaksi->created_at }}</b>
                        </span> <br>
                        <small class="text-muted">Kode Transaksi: #{{ $transaksi->kode_transaksi }}</small>
                    </div>
                    <div class="col-lg-6 col-md-6 ms-auto text-md-end">
                        {{-- <select class="form-select d-inline-block mb-lg-0 mb-15 mw-200">
                            <option>Change status</option>
                            <option>Awaiting payment</option>
                            <option>Confirmed</option>
                            <option>Shipped</option>
                            <option>Delivered</option>
                        </select> --}}
                       <form action="{{ route('penjual.transaksi.update', $transaksi->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="no_resi" value="{{ $transaksi->no_resi }}" class="form-control d-inline-block mb-lg-0 mb-15 mw-200" placeholder="Masukan Resi">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>
                    </div>
                </div>
            </header> <!-- card-header end// -->
            <div class="card-body">
                <div class="row mb-50 mt-20 order-info-wrap">
                    <div class="col-md-6">
                        <article class="icontext align-items-start">
                            <span class="icon icon-sm rounded-circle bg-primary-light">
                                <i class="text-primary material-icons md-person"></i>
                            </span>
                            <div class="text">
                                <h6 class="mb-1">Pembeli</h6>
                                <p class="mb-1">
                                    {{ $transaksi->user->name }} <br> {{ $transaksi->user->no_hp }}
                                </p>
                            </div>
                        </article>
                    </div> <!-- col// -->

                    <div class="col-md-6">
                        <article class="icontext align-items-start">
                            <span class="icon icon-sm rounded-circle bg-primary-light">
                                <i class="text-primary material-icons md-place"></i>
                            </span>
                            <div class="text">
                                <h6 class="mb-1">Kirim Ke</h6>
                                <p class="mb-1">
                                    Alamat: {{ $transaksi->alamat_pengiriman }}
                                </p>
                            </div>
                        </article>
                    </div> <!-- col// -->
                </div> <!-- row // -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="40%">Product</th>
                                        <th width="20%">Harga Produk</th>
                                        <th width="20%">Quantity</th>
                                        <th width="20%" class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksi->detail as $item)
                                        <tr>
                                            <td>
                                                <a class="itemside" href="#">
                                                    <div class="left">
                                                        <img src="{{ asset(json_decode($item->produk->gambar)[0]) }}"
                                                            width="100" height="100" class="img-xs" alt="Item">
                                                    </div>
                                                    <div class="info"> {{ $item->produk->nama_produk }} </div>
                                                </a>
                                            </td>
                                            <td> Rp{{ number_format($item->produk->harga) }} </td>
                                            <td>{{ $item->quantity }} KG</td>
                                            <td class="text-end">Rp{{ number_format($item->harga) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4">
                                            <article class="float-end">
                                                {{-- <dl class="dlist">
                                                    <dt>Subtotal:</dt>
                                                    <dd>$973.35</dd>
                                                </dl>
                                                <dl class="dlist">
                                                    <dt>Shipping cost:</dt>
                                                    <dd>$10.00</dd>
                                                </dl> --}}
                                                <dl class="dlist">
                                                    <dt>Total Harga:</dt>
                                                    <dd> <b
                                                            class="h5">RP{{ number_format($transaksi->total_harga) }}</b>
                                                    </dd>
                                                </dl>
                                                <dl class="dlist">
                                                    <dt class="text-muted">Status:</dt>
                                                    @if ($transaksi->status == 'SUCCESS')
                                                        <dd>
                                                            <span
                                                                class="badge rounded-pill alert-success text-success">{{ $transaksi->status }}</span>
                                                        </dd>
                                                    @elseif ($transaksi->status == 'PENDING')
                                                        <dd>
                                                            <span
                                                                class="badge rounded-pill alert-warning text-warning">{{ $transaksi->status }}</span>
                                                        </dd>
                                                    @elseif ($transaksi->status == 'DELIVERED')
                                                        <dd>
                                                            <span
                                                                class="badge rounded-pill alert-success text-success">{{ $transaksi->status }}</span>
                                                        </dd>
                                                    @elseif ($transaksi->status == 'CANCELLED')
                                                        <dd>
                                                            <span
                                                                class="badge rounded-pill alert-danger text-danger">{{ $transaksi->status }}</span>
                                                        </dd>
                                                    @else
                                                        <dd>
                                                            <span
                                                                class="badge rounded-pill alert-danger text-danger">NOTHING</span>
                                                        </dd>
                                                    @endif
                                                </dl>
                                            </article>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div> <!-- table-responsive// -->
                    </div> <!-- col// -->
                </div>
            </div> <!-- card-body end// -->
        </div> <!-- card end// -->
    </section> <!-- content-main end// -->

@endsection
