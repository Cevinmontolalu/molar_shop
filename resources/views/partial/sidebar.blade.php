<div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="/dashboard">Molar Thriftshop</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="/dashboard">Mt</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
              <li class="{{$pageName=='Molar Dashboard'?'active':''}}"><a class="nav-link active" href="{{url('/dashboard')}}"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
              <!-- <li class="nav-item dropdown active">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="index-0.html">General Dashboard</a></li>
                  <li class="active"><a class="nav-link" href="index.html">Ecommerce Dashboard</a></li>
                </ul>
              </li> -->
              
              <li class="menu-header">Master Data</li>
              <li class="{{$pageName=='Kategori Produk'?'active':''}}"><a class="nav-link" href="{{url('category/')}}"><i class="far fa-list-alt"></i><span>Kategori Produk</span></a></li>
              <li class="{{$pageName=='Sub Kategori'?'active':''}}"><a class="nav-link" href="{{url('subCategory/')}}"><i class="fas fa-list"></i><span>Sub Kategori Produk</span></a></li>
              <li class="{{request()->segment(1)=='customer'?'active':''}}"><a class="nav-link" href="{{url('/customer')}}"><i class="far fa-user"></i><span>Pelanggan</span></a></li>
              <li class="{{request()->segment(1)=='product'?'active':''}}"><a class="nav-link" href="{{url('/product')}}"><i class="far fa-bookmark"></i><span>Produk</span></a></li>
              
             
             
              <li class="menu-header">Transaksi</li>
              <li class="{{request()->segment(1)=="transaction"?'active':''}}"><a class="nav-link active" href="{{url('/transaction')}}"><i class="fas fa-fire"></i><span>Daftar Transaksi</span></a></li>
              {{-- <li class="{{$pageName=='Report'?'active':''}}"><a class="nav-link active" href="{{url('/pjp')}}"><i class="fas fa-fire"></i><span>Laporan Transaksi</span></a></li> --}}
           
              
              <li class="menu-header">Pengaturan</li>
              <li class="{{request()->segment(1)=='shop-profile'?'active':''}}"><a class="nav-link active" href="{{url('/shop-profile')}}"><i class="fas fa-fire"></i><span>Profil Toko</span></a></li>
              <li class="{{request()->segment(1)=="profile"?'active':''}}"><a class="nav-link active" href="{{url('/profile')}}"><i class="fas fa-fire"></i><span>Profil</span></a></li>
              <li class="{{$pageName=='Banner Toko'?'active':''}}"><a class="nav-link active" href="{{url('/banners')}}"><i class="fas fa-fire"></i><span>Banner Toko</span></a></li>
              <li class="{{$pageName=='Rekening Toko'?'active':''}}"><a class="nav-link active" href="{{url('/shop_rekening')}}"><i class="fas fa-credit-card"></i><span>Rekening Toko</span></a></li>
              <li class="{{request()->segment(1)=='biaya_pengiriman'?'active':''}}"><a class="nav-link" href="{{url('/biaya_pengiriman')}}"><i class="far fa-bookmark"></i><span>Biaya Pengiriman</span></a></li>
              <li class="{{request()->segment(1)=="user"?'active':''}}"><a class="nav-link active" href="{{url('/user')}}"><i class="fas fa-user"></i><span>Pengguna</span></a></li>
              
            </ul>

            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
              <a href="{{url('logout')}}" class="btn btn-molar btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
        </aside>
      </div>