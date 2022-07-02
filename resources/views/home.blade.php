@extends('layouts.frontend')

@section('title','Home')

@section('content')
<section class="home-slider position-relative mb-30">
    <div class="container">
        <div class="home-slide-cover bg-grey-10 mt-30">
            <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1">
                <div class="single-hero-slider single-animation-wrap">
                    <div class="container">
                        <div class="row align-items-center slider-animated-1">
                            <div class="col-lg-5 col-md-6">
                                <div class="hero-slider-content-2">
                                    <h2 class="animated fw-900 text-brand">Nama Website</h2>
                                    <p class="animated">Menjual Berbagai Ikan Segar</p>
                                    <a class="animated btn btn-brush btn-brush-3"
                                        href="shop-product-right.html" tabindex="0"> Belanja Sekarang </a>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-6">
                                <div class="single-slider-img single-slider-img-1">
                                    <img class="animated" src="{{ asset('frontend/assets/imgs/fish.png') }}"
                                        alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-hero-slider single-animation-wrap">
                    <div class="container">
                        <div class="row align-items-center slider-animated-1">
                            <div class="col-lg-5 col-md-6">
                                <div class="hero-slider-content-2">
                                    <h2 class="animated fw-900 text-brand">Nama Website</h2>
                                    <p class="animated">Menjual Berbagai Ikan Segar</p>
                                    <a class="animated btn btn-brush btn-brush-3"
                                        href="shop-product-right.html" tabindex="0"> Belanja Sekarang </a>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-6">
                                <div class="single-slider-img single-slider-img-1">
                                    <img class="animated" src="{{ asset('frontend/assets/imgs/fish-2.png') }}"
                                        alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slider-arrow hero-slider-1-arrow"></div>
        </div>
    </div>
</section>

<section class="product-tabs section-padding position-relative wow fadeIn animated">
    <div class="bg-square"></div>
    <div class="container">
        <div class="tab-header">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @foreach ($penjual as $item)
                @if ($item->produk->isNotEmpty())
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $loop->index == 0 ? 'active' : '' }}" id="nav-tab-{{ $item->id }}" data-bs-toggle="tab" data-bs-target="#tab-{{ $item->id }}" type="button" role="tab" aria-controls="tab-{{ $item->id }}" aria-selected="true">{{ $item->name }}</button>
                </li>
                @endif

                @endforeach
            </ul>
            {{-- <a href="#" class="view-more d-none d-md-flex">View More<i class="fi-rs-angle-double-small-right"></i></a> --}}
        </div>
        <!--End nav-tabs-->
        <div class="tab-content wow fadeIn animated" id="myTabContent">
            @foreach ($penjual as $val)
            <div class="tab-pane fade show active" id="tab-{{ $val->user_id }}" role="tabpanel" aria-labelledby="tab-{{ $val->user_id }}">
                <div class="row product-grid-4">
                    @foreach ($val->produk as $item)
                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a href="shop-product-right.html">
                                        <img class="default-img" src="{{ asset(json_decode($item->gambar)[0]) }}" alt="">
                                        <img class="hover-img" src="{{ asset(json_decode($item->gambar)[0]) }}" alt="">
                                    </a>
                                </div>


                            </div>
                            <div class="product-content-wrap">

                                <h2><a href="shop-product-right.html">{{ $item->nama_produk }}</a></h2>

                                <div class="product-price">
                                    <span>Rp{{ number_format($item->harga) }} / Kg</span>
                                </div>
                                <div class="product-action-1 show">
                                    <a aria-label="Tambah Keranjang" class="action-btn hover-up" href="shop-cart.html"><i class="fi-rs-shopping-bag-add"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!--End product-grid-4-->
            </div>
            @endforeach

        </div>
        <!--End tab-content-->
    </div>
</section>
@endsection
