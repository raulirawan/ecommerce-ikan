@extends('layouts.frontend')

@section('title','Halaman Ikan')

@section('content')

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
                                    <a href="{{ route('detail.produk', $item->slug) }}">
                                        <img class="default-img" src="{{ asset(json_decode($item->gambar)[0]) }}" alt="">
                                        <img class="hover-img" src="{{ asset(json_decode($item->gambar)[0]) }}" alt="">
                                    </a>
                                </div>


                            </div>
                            <div class="product-content-wrap">

                                <h2><a href="{{ route('detail.produk', $item->slug) }}">{{ $item->nama_produk }}</a></h2>

                                <div class="product-price">
                                    <span>Rp{{ number_format($item->harga) }} / Kg</span>
                                </div>
                                <div class="product-action-1 show">
                                    <a aria-label="Tambah Keranjang" class="action-btn hover-up" href="{{ route('cart.add', $item->id) }}"><i class="fi-rs-shopping-bag-add"></i></a>
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
