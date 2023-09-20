<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 text-center" href="" target="_blank">
            <img src="{{ asset('argon') }}/assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">InventoryKu</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('barang_masuk.index') }}">
                    <div
                        class="fa-solid fa-cart-flatbed text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pembelian</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('barang_keluar.index') }}">
                    <div class="fa-solid fa-sleigh text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Penjualan</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Menu</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="{{ route('produk.index') }}">
                    <div
                        class="fa-solid fa-drumstick-bite text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-app text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Produk</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="{{ route('satuan.index') }}">
                    <div
                        class="fa-solid fa-cubes-stacked text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Satuan Produk</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="{{ route('kategori_produk.index') }}">
                    <div
                        class="fa-solid fa-chart-simple text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-app text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Kategori Produk</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="{{ route('supplier.index') }}">
                    <div
                        class="fa-solid fa-person-shelter border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Supplier</span>
                </a>
            </li>
            `
        </ul>
    </div>
</aside>
