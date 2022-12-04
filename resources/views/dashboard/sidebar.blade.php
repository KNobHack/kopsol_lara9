<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon">
      <i class="fas fa-tree"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Koperasi Online</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMenuAnggota"
      aria-expanded="true" aria-controls="collapseMenuAnggota">
      <i class="fas fa-fw fa-user"></i>
      <span>Anggota</span>
    </a>
    <div id="collapseMenuAnggota" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
        <a class="collapse-item" href="{{ route('anggota.index') }}">Data anggota</a>
        {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
      </div>
    </div>
  </li>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMenuMerchant"
      aria-expanded="true" aria-controls="collapseMenuMerchant">
      <i class="fas fa-fw fa-shopping-bag"></i>
      <span>Merchant</span>
    </a>
    <div id="collapseMenuMerchant" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
        <a class="collapse-item" href="{{ route('produk.index') }}">Data produk</a>
        {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
      </div>
    </div>
  </li>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMenuSimpanan"
      aria-expanded="true" aria-controls="collapseMenuSimpanan">
      <i class="fas fa-fw fa-wallet"></i>
      <span>Simpanan</span>
    </a>
    <div id="collapseMenuSimpanan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('simpanan.pokok') }}">Pokok</a>
        <a class="collapse-item" href="{{ route('simpanan.wajib') }}">Wajib</a>
        <a class="collapse-item" href="{{ route('simpanan.sukarela') }}">Sukarela</a>
        <a class="collapse-item" href="{{ route('simpanan.index') }}">Semua Simpanan</a>
      </div>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMenuTrabsaksi"
      aria-expanded="true" aria-controls="collapseMenuTrabsaksi">
      <i class="fas fa-fw fa-money-check-alt"></i>
      <span>Transaksi</span>
    </a>
    <div id="collapseMenuTrabsaksi" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        {{-- <h6 class="collapse-header">Simpanan</h6> --}}
        {{-- <a class="collapse-item" href="buttons.html">Pinjaman</a> --}}
        <a class="collapse-item" href="{{ route('transaksi.index') }}">Transaksi</a>
        <a class="collapse-item" href="buttons.html">Penarikan</a>
        <a class="collapse-item" href="buttons.html">Tunggakan</a>
        {{-- <a class="collapse-item" href="buttons.html">Angsuran</a> --}}
        {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

  {{--
  <!-- Sidebar Message -->
  <div class="sidebar-card d-none d-lg-flex">
    <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
    <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and
    more!</p>
    <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
  </div>
	--}}

</ul>
