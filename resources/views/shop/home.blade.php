@extends('shop.partial.layouts')
@section('content')
@if(count($banner)>0)
    <section class="hero-section">
        
        <div class="hero-items owl-carousel">
            @foreach($banner as $b)
            <div class="single-hero-items set-bg" data-setbg="{{asset('banner/'.$b->image)}}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <h1>{{$b->title}}</h1>
                            <p>{{$b->description}}</p>
                            <!-- @if(isset($b->link))
                                <a href="{{url($b->link)}}" class="primary-btn">Buka</a>
                            @endif -->
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
       
            <!-- <div class="single-hero-items set-bg" data-setbg="{{asset('fashi-master/img/hero-1.jpg')}}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span>Bag,kids</span>
                            <h1>Black friday</h1>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore</p>
                            <a href="#" class="primary-btn">Shop Now</a>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>50%</span></h2>
                    </div>
                </div>
            </div>
            <div class="single-hero-items set-bg" data-setbg="{{asset('fashi-master/img/hero-2.jpg')}}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span>Bag,kids</span>
                            <h1>Black friday</h1>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore</p>
                            <a href="#" class="primary-btn">Shop Now</a>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>50%</span></h2>
                    </div>
                </div>
            </div> -->
        </div>
    </section>
@endif
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <div class="banner-section spad">
        <div class="container-fluid">
            <div class="row">
                @if(count($highlightCategory)>0)
                    @foreach($highlightCategory as $hlC)
                        @if(count($highlightCategory)==1)
                        <div class="col-lg-12">
                            <div class="single-banner">
                                <img src="{{asset('gallery/'.$hlC->productId.'/'.$hlC->photo)}}" height="250px" alt="{{$hlC->name}}"/>
                                <div class="inner-text">
                                    <a href="{{url('shop/product/category/'.$hlC->id)}}"><h4>{{$hlC->name}}</h4></a>
                                </div>
                            </div>
                        </div>
                        @elseif(count($highlightCategory)==2)
                        <div class="col-lg-6">
                            <div class="single-banner">
                                <img src="{{asset('gallery/'.$hlC->productId.'/'.$hlC->photo)}}" height="250px" alt="{{$hlC->name}}"/>
                                <div class="inner-text">
                                    <a href="{{url('shop/product/category/'.$hlC->id)}}"><h4>{{$hlC->name}}</h4></a>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-lg-4">
                            <div class="single-banner">
                                <img src="{{asset('gallery/'.$hlC->productId.'/'.$hlC->photo)}}"height="250px" alt="{{$hlC->name}}"/>
                                <div class="inner-text">
                                    <a href="{{url('shop/product/category/'.$hlC->id)}}"><h4>{{$hlC->name}}</h4></a>
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- <div class="col-lg-4">
                            <div class="single-banner">
                                <img src="{{asset('fashi-master/img/banner-3.jpg')}}" alt="">
                                <div class="inner-text">
                                    <h4>Kid’s</h4>
                                </div>
                            </div>
                        </div> --}}
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- Banner Section End -->

    <!-- Women Banner Section Begin -->
    @if(isset($products['list1'][0]))
    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-large set-bg" data-setbg="{{asset('gallery/'.$products['list1'][0]->id.'/'.$products['list1'][0]->photo)}}">
                        <h2>{{$products['list1'][0]->kategori}}</h2>
                        <a href="{{url('/shop/product/category/'.$products['list1'][0]->categoryId)}}">Discover More</a>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    
                    <div class="product-slider owl-carousel">
                        @foreach($products['list1'] as $p)
                        <div class="product-item">
                            <div class="pi-pic">
                                @if($p->photo!="")
                                <img src="{{asset('gallery/'.$p->id.'/'.$p->photo)}}" alt="">
                                @else
                                <img src="{{asset('gallery/image-not-available.jpeg')}}" alt="">
                                @endif
                                <div class="sale">Sale</div>
                                <!-- <div class="icon">
                                    <i class="icon_heart_alt"></i>
                                </div> -->
                                <ul>
                                    <!-- <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li> -->
                                    <li class="quick-view"><a href="{{url('shop/product/detail/'.$p->id)}}">+ Lihat</a></li>
                                    <!-- <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li> -->
                                </ul>
                            </div>
                            <div class="pi-text">
                                <div class="catagory-name">{{$p->kategori}}</div>
                                <a href="{{url('shop/product/detail/'.$p->id)}}">
                                    <h5>{{$p->name}} - {{$p->variantName}}</h5>
                                </a>
                                <div class="product-price">
                                    Rp. {{number_format($p->price)}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- Women Banner Section End -->

    <!-- Deal Of The Week Section Begin-->
    {{-- <section class="deal-of-week set-bg spad" data-setbg="{{asset('fashi-master/img/time-bg.jpg')}}">
        <div class="container">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h2>Deal Of The Week</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed<br /> do ipsum dolor sit amet,
                        consectetur adipisicing elit </p>
                    <div class="product-price">
                        $35.00
                        <span>/ HanBag</span>
                    </div>
                </div>
                <div class="countdown-timer" id="countdown">
                    <div class="cd-item">
                        <span>56</span>
                        <p>Days</p>
                    </div>
                    <div class="cd-item">
                        <span>12</span>
                        <p>Hrs</p>
                    </div>
                    <div class="cd-item">
                        <span>40</span>
                        <p>Mins</p>
                    </div>
                    <div class="cd-item">
                        <span>52</span>
                        <p>Secs</p>
                    </div>
                </div>
                <a href="#" class="primary-btn">Shop Now</a>
            </div>
        </div>
    </section> --}}
    <!-- Deal Of The Week Section End -->

    <!-- Man Banner Section Begin -->
    @if(isset($products['list2'][0]))
    <section class="man-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    
                    <div class="product-slider owl-carousel">
                        @foreach($products['list2'] as $p)
                        <div class="product-item">
                            <div class="pi-pic">
                                @if($p->photo!="")
                                <img src="{{asset('gallery/'.$p->id.'/'.$p->photo)}}" alt="">
                                @else
                                <img src="{{asset('gallery/image-not-available.jpeg')}}" alt="">
                                @endif
                                <div class="sale">Sale</div>
                                <div class="icon">
                                    <i class="icon_heart_alt"></i>
                                </div>
                                <ul>
                                    <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                    <li class="quick-view"><a href="{{url('shop/product/detail/'.$p->id)}}">+ Quick View</a></li>
                                    <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                                </ul>
                            </div>
                            <div class="pi-text">
                                <div class="catagory-name">{{$p->kategori}}</div>
                                <a href="#">
                                    <h5>{{$p->name}} - {{$p->variantName}}</h5>
                                </a>
                                <div class="product-price">
                                    Rp. {{number_format($p->price)}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="product-large set-bg m-large" data-setbg="{{asset('gallery/'.$products['list2'][0]->id.'/'.$products['list2'][0]->photo)}}">
                        <h2>{{$products['list2'][0]->kategori}}</h2>
                        <a href="{{url('shop/product/category/'.$products['list2'][0]->categoryId)}}">Discover More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    @if(isset($products['list3'][0]))
    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-large set-bg" data-setbg="{{asset('gallery/'.$products['list3'][0]->id.'/'.$products['list3'][0]->photo)}}">
                        <h2>{{$products['list3'][0]->kategori}}</h2>
                        <a href="{{url('/shop/product/category/'.$products['list3'][0]->categoryId)}}">Discover More</a>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    
                    <div class="product-slider owl-carousel">
                        @foreach($products['list3'] as $p)
                        <div class="product-item">
                            <div class="pi-pic">
                                @if($p->photo!="")
                                <img src="{{asset('gallery/'.$p->id.'/'.$p->photo)}}" alt="">
                                @else
                                <img src="{{asset('gallery/image-not-available.jpeg')}}" alt="">
                                @endif
                                <div class="sale">Sale</div>
                                <div class="icon">
                                    <i class="icon_heart_alt"></i>
                                </div>
                                <ul>
                                    <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                    <li class="quick-view"><a href="{{url('shop/product/detail/'.$p->id)}}">+ Quick View</a></li>
                                    <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                                </ul>
                            </div>
                            <div class="pi-text">
                                <div class="catagory-name">{{$p->kategori}}</div>
                                <a href="{{url('shop/product/detail/'.$p->id)}}">
                                    <h5>{{$p->name}} - {{$p->variantName}}</h5>
                                </a>
                                <div class="product-price">
                                    Rp. {{number_format($p->price)}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- Man Banner Section End -->

    <!-- Instagram Section Begin -->
    {{-- <div class="instagram-photo">
        <div class="insta-item set-bg" data-setbg="{{asset('fashi-master/img/insta-1.jpg')}}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">colorlib_Collection</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{asset('fashi-master/img/insta-2.jpg')}}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">colorlib_Collection</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{asset('fashi-master/img/insta-3.jpg')}}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">colorlib_Collection</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{asset('fashi-master/img/insta-4.jpg')}}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">colorlib_Collection</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{asset('fashi-master/img/insta-5.jpg')}}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">colorlib_Collection</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{asset('fashi-master/img/insta-6.jpg')}}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">colorlib_Collection</a></h5>
            </div>
        </div>
    </div> --}}
    <!-- Instagram Section End -->

    <!-- Latest Blog Section Begin -->
    <section class="latest-blog spad">
        <div class="container">
            
            <div class="benefit-items">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="{{asset('fashi-master/img/icon-1.png')}}" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Harga Pengirman Murah</h6>
                                <p>Setiap Order dengan Pengiriman Termurah</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="{{asset('fashi-master/img/icon-2.png')}}" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Pengiriman tepat waktu</h6>
                                <p>Setiap pengiriman akan diatur agar bisa sampai dengan tepat waktu</p>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="{{asset('fashi-master/img/icon-1.png')}}" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Pemba</h6>
                                <p>100% secure payment</p>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Blog Section End -->

    <!-- Partner Logo Section Begin -->
    
@endsection