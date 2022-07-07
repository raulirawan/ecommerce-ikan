<header class="header-area header-style-1 header-height-2">


    <div class="header-bottom header-bottom-bg-color sticky-bar">
        <div class="container">
            <div class="header-wrap header-space-between position-relative">
                <div class="logo logo-width-1 d-block d-lg-none">
                    <a href="index.html"><img src="{{ asset('frontend') }}/assets/imgs/theme/logo.svg"
                            alt="logo"></a>
                </div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-categori-wrap d-none d-lg-block">
                        <a class="categori-button-active" href="#">
                            <span class="fi-rs-apps"></span> Nama Website
                        </a>

                    </div>
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block">
                        <nav>
                            <ul>
                                <li><a class="active" href="{{ url('/') }}">Home</a>

                                </li>
                                <li>
                                    <a href="{{ route('produk.index') }}">Ikan</a>
                                </li>

                                @guest
                                    <li>
                                        <a href="{{ route('login') }}">Masuk</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('register') }}">Daftar Akun</a>
                                    </li>
                                @endguest
                                @auth
                                    <li><a href="index.html">Halo, {{ Auth::user()->name }} <i class="fi-rs-angle-down"></i></a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('profil.index') }}">Profil</a></li>
                                            <li><a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">Logout</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endauth

                            </ul>
                        </nav>
                    </div>
                    @auth
                        <div class="header-action-right">
                            <div class="header-action-2">

                                <div class="header-action-icon-2">
                                    <a class="mini-cart-icon" href="shop-cart.html">
                                        <img alt="Evara"
                                            src="{{ asset('frontend') }}/assets/imgs/theme/icons/icon-cart.svg">
                                            @php
                                                $carts = App\Cart::where('user_id',Auth::user()->id)->get()
                                            @endphp
                                        <span class="pro-count blue">{{ $carts->count() }}</span>
                                    </a>
                                    @if ($carts->isNotEmpty())
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                        <ul>
                                            @foreach ($carts as $cart)
                                            <li>
                                                <div class="shopping-cart-img">
                                                    <a href="shop-product-right.html"><img alt="Evara"
                                                            src="{{ asset(json_decode($cart->produk->gambar)[0]) }}"></a>
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4><a href="shop-product-right.html">{{ $cart->produk->nama_produk }}</a></h4>
                                                    <h4><span>{{ $cart->quantity }} × </span>Rp{{ number_format($cart->produk->harga) }}</h4>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <a href="{{ route('cart.delete', $cart->id) }}" onclick="return confirm('Yakin ?')"><i class="fi-rs-cross-small"></i></a>
                                                </div>
                                            </li>
                                            @endforeach

                                        </ul>
                                        <div class="shopping-cart-footer">
                                            <div class="shopping-cart-total">
                                                <h4>Total <span>Rp{{ number_format($carts->sum('harga')) }}</span></h4>
                                            </div>
                                            <div class="shopping-cart-button">
                                                <a href="{{ route('cart.index') }}" class="outline">Lihat Keranjang</a>
                                                <a href="{{ route('checkout.index') }}">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                       <div class="text-center">Belum Ada Data</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>

                <p class="mobile-promotion">Happy <span class="text-brand">Mother's Day</span>. Big Sale Up to 40%
                </p>
                <div class="header-action-right d-block d-lg-none">
                    <div class="header-action-2">

                        <div class="header-action-icon-2">
                            <a class="mini-cart-icon" href="shop-cart.html">
                                <img alt="Evara"
                                    src="{{ asset('frontend') }}/assets/imgs/theme/icons/icon-cart.svg">
                                <span class="pro-count white">2</span>
                            </a>
                            <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                <ul>
                                    <li>
                                        <div class="shopping-cart-img">
                                            <a href="shop-product-right.html"><img alt="Evara"
                                                    src="{{ asset('frontend') }}/assets/imgs/shop/thumbnail-3.jpg"></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="shop-product-right.html">Plain Striola Shirts</a></h4>
                                            <h3><span>1 × </span>$800.00</h3>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fi-rs-cross-small"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="shopping-cart-img">
                                            <a href="shop-product-right.html"><img alt="Evara"
                                                    src="{{ asset('frontend') }}/assets/imgs/shop/thumbnail-4.jpg"></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="shop-product-right.html">Macbook Pro 2022</a></h4>
                                            <h3><span>1 × </span>$3500.00</h3>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fi-rs-cross-small"></i></a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="shopping-cart-footer">
                                    <div class="shopping-cart-total">
                                        <h4>Total <span>$383.00</span></h4>
                                    </div>
                                    <div class="shopping-cart-button">
                                        <a href="shop-cart.html">View cart</a>
                                        <a href="shop-checkout.html">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header-action-icon-2 d-block d-lg-none">
                            <div class="burger-icon burger-icon-white">
                                <span class="burger-icon-top"></span>
                                <span class="burger-icon-mid"></span>
                                <span class="burger-icon-bottom"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</header>

<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo">
                <a href="index.html"><img src="{{ asset('frontend') }}/assets/imgs/theme/logo.svg"
                        alt="logo"></a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                </button>
            </div>
        </div>
        <div class="mobile-header-content-area">
            <div class="mobile-search search-style-3 mobile-header-border">
                <form action="#">
                    <input type="text" placeholder="Search for items…">
                    <button type="submit"><i class="fi-rs-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <div class="main-categori-wrap mobile-header-border">
                    <a class="categori-button-active-2" href="#">
                        <span class="fi-rs-apps"></span> Browse Categories
                    </a>
                </div>
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu">

                        <li><a class="active" href="index.html">Home</a>

                        </li>
                        <li>
                            <a href="page-about.html">Ikan</a>
                        </li>

                        <li>
                            <a href="page-contact.html">Masuk</a>
                        </li>
                        <li>
                            <a href="page-contact.html">Daftar Akun</a>
                        </li>
                        <li class="menu-item-has-children"><span class="menu-expand"></span><a href="index.html">Akun
                                Saya</a>
                            <ul class="dropdown">
                                <li><a href="#">Profil</a></li>
                                <li><a href="#">Transaksi</a></li>
                                <li><a href="#" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
        </div>
    </div>
</div>
