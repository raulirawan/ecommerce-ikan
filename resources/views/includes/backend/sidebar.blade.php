<aside class="navbar-aside" id="offcanvas_aside">
    <div class="aside-top">
        <a href="index.html" class="brand-wrap">
            <img src="{{ asset('backend') }}/assets/imgs/theme/logo.svg" class="logo" alt="Evara Dashboard">
        </a>
        <div>
            <button class="btn btn-icon btn-aside-minimize"> <i class="text-muted material-icons md-menu_open"></i>
            </button>
        </div>
    </div>
    {{-- nav admin --}}
    @if (Auth::user()->roles == 'ADMIN')
        <nav>
            <ul class="menu-aside">
                <li class="menu-item active">
                    <a class="menu-link" href="{{ route('admin.dashboard.index') }}"> <i
                            class="icon material-icons md-home"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item has-submenu">
                    <a class="menu-link" href="page-orders-1.html"> <i class="icon material-icons md-person"></i>
                        <span class="text">User</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('admin.pembeli.index') }}">Pembeli</a>
                        <a href="{{ route('admin.penjual.index') }}">Penjual</a>
                    </div>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('admin.produk.index') }}"> <i
                            class="icon material-icons md-shopping_bag"></i>
                        <span class="text">Produk</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a class="menu-link" href="{{ route('admin.transaksi.index') }}"> <i
                            class="icon material-icons md-monetization_on"></i>
                        <span class="text">Transaksi</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('admin.withdraw.index') }}"> <i
                            class="icon material-icons md-monetization_on"></i>
                        <span class="text">Withdraw</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                        <i class="icon material-icons md-exit_to_app"></i>
                        <span class="text">Logout</span>
                    </a>
                </li>
            </ul>
            <br>
            <br>
        </nav>
    @else
        <nav>
            <ul class="menu-aside">
                <li class="menu-item active">
                    <a class="menu-link" href="{{ route('penjual.dashboard.index') }}"> <i
                            class="icon material-icons md-home"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('penjual.produk.index') }}"> <i
                            class="icon material-icons md-shopping_bag"></i>
                        <span class="text">Produk</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a class="menu-link" href="{{ route('penjual.transaksi.index') }}"> <i
                            class="icon material-icons md-monetization_on"></i>
                        <span class="text">Transaksi</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('penjual.withdraw.index') }}"> <i
                            class="icon material-icons md-monetization_on"></i>
                        <span class="text">Request Withdraw</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('penjual.bank.index') }}"> <i
                            class="icon material-icons md-monetization_on"></i>
                        <span class="text">Data Bank</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                        <i class="icon material-icons md-exit_to_app"></i>
                        <span class="text">Logout</span>
                    </a>
                </li>
            </ul>
            <br>
            <br>
        </nav>
    @endif
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    {{-- nav penjual --}}
</aside>
