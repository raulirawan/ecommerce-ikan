@extends('layouts.frontend')

@section('title', 'Halaman Keranjang')

@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ url('/') }}" rel="nofollow">Home</a>
                <span></span> Checkout
            </div>
        </div>
    </div>
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="divider mt-50 mb-50"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-4">
                    <div class="order_review">
                        <div class="mb-25">
                            <h4>Informasi Pengriman</h4>
                        </div>
                        <form action="{{ route('checkout.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Nama Penerima</label>
                                <input required="" value="{{ Auth::user()->name }}" placeholder="Nama Penerima"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input required="" value="{{ Auth::user()->email }}" placeholder="Alamat Email"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Nomor Handphone</label>
                                <input required="" value="{{ Auth::user()->no_hp }}" placeholder="Nomor Handphone"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Alamat Lengkap</label>
                                <input type="text" name="alamat_lengkap" required="" placeholder="Alamat Lengkap">
                            </div>
                            <div class="form-group">
                                <label for="">Provinsi</label>
                                <input required="" type="text" name="provinsi" placeholder="Provinsi">
                            </div>
                            <div class="form-group">
                                <label for="">Kota</label>
                                <input required="" type="text" name="kota" placeholder="Kota">
                            </div>
                            <div class="form-group">
                                <label for="">Kecamatan</label>
                                <input required="" type="text" name="kecamatan" placeholder="Kecamatan">
                            </div>
                            <div class="form-group">
                                <label for="">Kelurahan</label>
                                <input required="" type="text" name="kelurahan" placeholder="Kelurahan">
                            </div>

                    </div>
                </div>
                <div class="col-md-6 mt-4">
                    <div class="order_review">
                        <div class="mb-20">
                            <h4>Data Orderan</h4>
                        </div>
                        <div class="table-responsive order_table text-center">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">Produk</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $carts = App\Cart::where('user_id', Auth::user()->id)->get();
                                    @endphp
                                    @foreach ($carts as $cart)
                                        <tr>
                                            <td class="image product-thumbnail"><img
                                                    src="{{ json_decode($cart->produk->gambar)[0] }}" alt="#"></td>
                                            <td>
                                                <h5><a href="{{ route('detail.produk', $cart->produk->slug) }}">{{ $cart->produk->nama_produk }}</a>
                                                </h5>
                                                <span class="product-qty">Rp{{ number_format($cart->produk->harga) }} x {{ $cart->quantity }}</span>
                                            </td>
                                            <td>Rp{{ number_format($cart->harga) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Total</th>
                                        <td colspan="2" class="product-subtotal"><span
                                                class="font-xl text-brand fw-900">Rp{{ number_format($carts->sum('harga')) }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bt-1 border-color-1 mt-30 mb-30"></div>

                        <button type="submit" class="btn btn-fill-out mt-30" onclick="return confirm('Buat Transaksi ?')" style="display: block">Checkout Sekarang</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </section>
@endsection
