@extends('layouts.frontend')

@section('title', 'Halaman Keranjang')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ url('/') }}" rel="nofollow">Home</a>
            <span></span> Keranjang
        </div>
    </div>
</div>
<section class="mt-50 mb-50">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="">
                    <div class="table-responsive">
                        <table class="table shopping-summery text-center clean" id="data-cart">
                            <thead>
                                <tr class="main-heading">
                                    <th scope="col">Gambar</th>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Quantity (Kg)</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($carts as $cart)
                                <tr>
                                    <td class="image product-thumbnail"><img src="{{ asset(json_decode($cart->produk->gambar)[0]) }}" alt="#"></td>
                                    <td class="product-des product-name">
                                        <h5 class="product-name"><a href="shop-product-right.html">{{ $cart->produk->nama_produk }}</a></h5>
                                        </p>
                                    </td>
                                    <td class="price" data-title="Price"><span>Rp{{ number_format($cart->produk->harga) }} </span></td>
                                    <td class="text-right" data-title="Cart">
                                        <span>{{ $cart->quantity }} Kg</span>
                                    </td>
                                    <td class="text-right" data-title="Cart">
                                        <span>Rp{{ number_format($cart->harga) }} </span>
                                    </td>
                                    <td class="action" data-title="Remove"><a onclick="return confirm('Yakin ?')" href="{{ route('cart.delete', $cart->id) }}" class="text-muted"><i class="fi-rs-trash"></i></a></td>

                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="cart-action text-end">
                        <a class="btn " href="{{ route('home.index') }}"><i class="fi-rs-shopping-bag mr-10"></i>Lanjut Belanja</a>
                    </div>

                </form>
                <div class="divider center_icon mt-50 mb-50"><i class="fi-rs-fingerprint"></i></div>
                <div class="row mb-50">

                    <div class="col-lg-6 col-md-12">
                        <div class="border p-md-4 p-30 border-radius cart-totals">
                            <div class="heading_s1 mb-3">
                                <h4>Total Keranjang</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table" >
                                    <tbody>
                                        {{-- <tr>
                                            <td class="cart_total_label">Cart Subtotal</td>
                                            <td class="cart_total_amount"><span class="font-lg fw-900 text-brand">$240.00</span></td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">Shipping</td>
                                            <td class="cart_total_amount"> <i class="ti-gift mr-5"></i> Free Shipping</td>
                                        </tr> --}}
                                        <tr>
                                            <td class="cart_total_label">Total</td>
                                            <td class="cart_total_amount"><strong><span class="font-xl fw-900 text-brand">Rp{{ number_format($carts->sum('harga')) }}</span></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="btn "> <i class="fi-rs-box-alt mr-10"></i>Proses Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
