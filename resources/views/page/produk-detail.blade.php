@extends('layouts.frontend')

@section('title', 'Produk Detail '. $produk->nama_produk)

@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow">Home</a>
                <span></span> Ikan
                <span></span> {{ $produk->nama_produk }}
            </div>
        </div>
    </div>
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-gallery">
                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                    <!-- MAIN SLIDES -->
                                    @php
                                        $gambar = json_decode($produk->gambar);
                                    @endphp
                                    <div class="product-image-slider">
                                        @foreach ($gambar as $item)
                                        <figure class="border-radius-10">
                                            <img src="{{ asset($item) }}" alt="product image">
                                        </figure>
                                        @endforeach

                                    </div>
                                    <!-- THUMBNAILS -->
                                    <div class="slider-nav-thumbnails pl-15 pr-15">
                                        @foreach ($gambar as $item)
                                        <div><img src="{{ asset($item) }}" alt="product image"></div>

                                        @endforeach

                                    </div>
                                </div>
                                <!-- End Gallery -->
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-info">
                                    <h2 class="title-detail">{{ $produk->nama_produk }}</h2>

                                    <div class="clearfix product-price-cover">
                                        <div class="product-price primary-color float-left">
                                            <ins><span class="text-brand">Rp{{ number_format($produk->harga) }} / KG</span></ins>
                                        </div>
                                    </div>
                                    <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                    <div class="short-desc mb-30">
                                        <p>{{ $produk->deskripsi ?? 'Tidak Ada Deskripsi' }}</p>
                                    </div>


                                    <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                    <form action="{{ route('cart.add.quantity') }}" method="post">
                                        @csrf
                                        <div class="detail-extralink">
                                            <div class="detail-qty border radius">
                                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                                <input type="hidden" name="quantity" id="qty-val-id" value="1">
                                                <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                <span class="qty-val">1</span>
                                                <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                            </div>
                                            <div class="product-extra-link2">
                                                <button type="submit" class="button button-add-to-cart">Tambah Keranjang</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <!-- Detail Info -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
