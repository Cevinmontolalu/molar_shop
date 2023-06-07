<header class="header-section">
    <div class="header-top">
        <div class="container">
            <div class="ht-left">
                <div class="mail-service">
                    <i class=" fa fa-envelope"></i>
                    {{$shared['shop_profile']->email}}
                </div>
                <div class="phone-service">
                    <i class=" fa fa-phone"></i>
                    {{$shared['shop_profile']->phone_no}}
                </div>
            </div>
            <div class="ht-right">
                <?php
                    $tmp = Auth::guard('customer')->user();
                    
                ?>
                
                @if(isset($tmp))
                <a href="{{url('/shop/user-logout')}}" class="login-panel"><i class="fa fa-sign-out"></i>Logout</a>
                <a href="{{url('/shop/profile')}}" class="login-panel"><i class="fa fa-user"></i>{{$tmp->name}}</a>
                
                @else
                <a href="{{url('shop/login')}}" class="login-panel"><i class="fa fa-user"></i>Login</a>
                <a href="{{url('/shop/register')}}" class="login-panel"><i class="fa fa-user-plus"></i>Mendaftar</a>
                @endif
                {{-- <div class="lan-selector">
                    <select class="language_drop" name="countries" id="countries" style="width:300px;">
                        <option value='yt' data-image="img/flag-1.jpg" data-imagecss="flag yt"
                            data-title="English">English</option>
                        <option value='yu' data-image="img/flag-2.jpg" data-imagecss="flag yu"
                            data-title="Bangladesh">German </option>
                    </select>
                </div> --}}
                {{-- <div class="top-social">
                    <a href="#"><i class="ti-facebook"></i></a>
                    <a href="#"><i class="ti-twitter-alt"></i></a>
                    <a href="#"><i class="ti-linkedin"></i></a>
                    <a href="#"><i class="ti-pinterest"></i></a>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="container">
        <div class="inner-header">
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <div class="logo">
                        <a href="{{url('/')}}">
                            <img src="{{asset('logo.png')}}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                    <form method="POST" action="{{url('shop/product/search')}}">
                        <div class="advanced-search">
                        
                                @csrf
                                <button type="button" class="category-btn">Cari Produk</button>
                                <div class="input-group">
                                    <input type="text" name="key" placeholder="Apa yang ada cari?">
                                    <button type="submit"><i class="ti-search"></i></button>
                                </div>
                            
                        </div>
                    </form>
                </div>
               
                <?php $user = Auth::guard('customer')->user();?>
                 @if(isset($user) && isset($cart['cart']) && isset($cart['detailCart']))
                <div class="col-lg-3 text-right col-md-3">
                    <ul class="nav-right">
                        {{-- <li class="heart-icon">
                            <a href="#">
                                <i class="icon_heart_alt"></i>
                                <span>1</span>
                            </a>
                        </li> --}}
                            
                        <li class="cart-icon">
                            <a href="#">
                                <i class="icon_bag_alt"></i>
                                <span>{{$cart['cart']->quantity}}</span>
                            </a>
                            @if(count($cart['detailCart'])>0)
                            <div class="cart-hover">
                                <div class="select-items">
                                    <table>
                                        <tbody>
                                            @foreach($cart['detailCart'] as $dc)
                                            <tr>
                                                @if(isset($dc->photo))
                                                <td class="si-pic"><img width="50px" height="50px" src="{{asset('gallery/'.$dc->productId.'/'.$dc->photo)}}" alt="{{$dc->productName}}"/></td>
                                                @else
                                                <td class="si-pic"><img width="50px" height="50px" src="{{asset('gallery/image-not-available.jpeg')}}" alt="{{$dc->productName}}"/></td>
                                                @endif
                                                <td class="si-text">
                                                    <div class="product-selected">
                                                        <p>Rp. {{number_format($dc->price)}} x {{$dc->quantity}}</p>
                                                        <h6><a href="{{url('shop/product/detail/'.$dc->productId)}}">{{$dc->productName}} -> {{$dc->variantName}}</a></h6>
                                                    </div>
                                                </td>
                                                <td class="si-close">
                                                    <a href="{{url('shop/user/reduceCart/'.$dc->id.'/1')}}"><i class="ti-close"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="select-total">
                                    <span>total:</span>
                                    <h5>Rp. {{number_format($cart['cart']->total)}}</h5>
                                </div>
                                <div class="select-button">
                                    <a href="{{url('shop/cart')}}" class="primary-btn view-card">Lihat Keranjang</a>
                                    {{-- <a href="#" class="primary-btn checkout-btn">CHECK OUT</a> --}}
                                </div>
                            </div>
                            @endif
                        </li>
                        <li class="cart-price">{{number_format($cart['cart']->total)}}</li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="nav-item">
        <div class="container">
            <div class="nav-depart">
                <div class="depart-btn">
                    <i class="ti-menu"></i>
                    <span>Kategori Produk</span>
                    <ul class="depart-hover">
                        {{-- <li class="active"><a href="#">Women’s Clothing</a></li>
                        <li><a href="#">Men’s Clothing</a></li>
                        <li><a href="#">Underwear</a></li>
                        <li><a href="#">Kid's Clothing</a></li>
                        <li><a href="#">Brand Fashion</a></li>
                        <li><a href="#">Accessories/Shoes</a></li>
                        <li><a href="#">Luxury Brands</a></li>
                        <li><a href="#">Brand Outdoor Apparel</a></li> --}}
                        @foreach($shared['kategori'] as $k)
                            <li><a href="{{url('shop/product/category/'.$k->id)}}">{{$k->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <nav class="nav-menu mobile-menu">
                <ul>
                    <li class="@if(request()->segment(2)=='' || request()->segment(1)=='') active @endif"><a href="{{url('/')}}">Beranda</a></li>
                    <li @if(request()->segment(2)=='product') class=" active"  @endif><a href="{{url('shop/product')}}">Produk</a></li>
                    {{-- <li><a href="#">Collection</a>
                        <ul class="dropdown">
                            <li><a href="#">Men's</a></li>
                            <li><a href="#">Women's</a></li>
                            <li><a href="#">Kid's</a></li>
                        </ul>
                    </li>
                    <li><a href="./blog.html">Blog</a></li> --}}
                    <?php $user = Auth::guard('customer')->user();?>
                    @if(isset($user))
                    <li class="@if(request()->segment(2)=='transactions') active @endif"><a href="{{url('shop/transactions')}}">Riwayat Transaksi</a></li>
                    @endif
                    {{-- <li><a href="#">Pages</a>
                        <ul class="dropdown">
                            <li><a href="./blog-details.html">Blog Details</a></li>
                            <li><a href="./shopping-cart.html">Shopping Cart</a></li>
                            <li><a href="./check-out.html">Checkout</a></li>
                            <li><a href="./faq.html">Faq</a></li>
                            <li><a href="./register.html">Register</a></li>
                            <li><a href="{{url('shop/login')}}">Login</a></li>
                        </ul>
                    </li> --}}
                </ul>
            </nav>
            <div id="mobile-menu-wrap"></div>
        </div>
    </div>
</header>