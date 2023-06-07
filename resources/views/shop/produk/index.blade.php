@extends('shop.partial.layouts')
@section('content')

    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="#"><i class="fa fa-home"></i> Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                    <div class="filter-widget">
                        <h4 class="fw-title">Kategori</h4>
                        <ul class="filter-catagories">
                            {{-- <li><a href="#">Men</a></li>
                            <li><a href="#">Women</a></li>
                            <li><a href="#">Kids</a></li> --}}
                            @foreach($shared['kategori'] as $k)
                            <li class="active"><a class="@if((request()->segment(3)=="category" || request()->segment(3)=="sub_category") && $category==$k->id) active @endif" href="{{url('shop/product/category/'.$k->id)}}">{{$k->name}}</a></li>
                            @endforeach
                            <li><a href="{{url('shop/product')}}">SEMUA</a></li>
                        </ul>
                    </div>
                    @if(request()->segment(3)==="category" || request()->segment(3)=="sub_category")
                    <div class="filter-widget">
                        <h4 class="fw-title">Sub Kategori</h4>
                        <ul class="filter-catagories">
                            
                            @foreach($subKategori as $k)
                            <li class="active"><a class="@if(request()->segment(3)=="sub_category" && $subCategory==$k->id) active @endif" href="{{url('shop/product/sub_category/'.$category.'/'.$k->id)}}">{{$k->name}}</a></li>
                            @endforeach
                            
                        </ul>
                    </div>
                    
                    @endif
                    {{-- <div class="filter-widget">
                        <h4 class="fw-title">Price</h4>
                        <div class="filter-range-wrap">
                            <div class="range-slider">
                                <div class="price-input">
                                    <input type="text" id="minamount">
                                    <input type="text" id="maxamount">
                                </div>
                            </div>
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                data-min="33" data-max="98">
                                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                            </div>
                        </div>
                        <a href="#" class="filter-btn">Filter</a>
                    </div> --}}
                    
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="product-show-option">
                        <div class="row">
                            {{-- <div class="col-lg-7 col-md-7">
                                <div class="select-option">
                                    <select class="sorting">
                                        <option value="">Default Sorting</option>
                                    </select>
                                    <select class="p-show">
                                        <option value="">Show:</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-lg-5 col-md-5">
                                <p>{{$product->total()}} Product</p>
                            </div>
                        </div>
                    </div>
                    <div class="product-list">
                        <div class="row">
                            @foreach($product as $p)
                            @if(count($p->variants)>0)
                            <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                        @if(isset($p->galleries[0]))
                                        <img src="{{asset('gallery/'.$p->id.'/'.$p->galleries[0]->link)}}" height="250px" alt="">
                                        @else
                                        <div style="border:1px solid black">
                                        <img src="{{asset('gallery/image-not-available.jpeg')}}" height="250px" alt="No Image">
                                        </div>
                                        @endif
                                        <div class="sale pp-sale">Sale</div>
                                        {{-- <div class="icon">
                                            <i class="icon_heart_alt"></i>
                                        </div> --}}
                                        <ul>
                                            {{-- <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li> --}}
                                            <li class="quick-view"><a href="{{url('shop/product/detail/'.$p->id)}}">+Lihat Detil</a></li>
                                            {{-- <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li> --}}
                                        </ul>
                                    </div>
                                    <div class="pi-text">
                                        <div class="catagory-name">{{$p->kategori}} : {{$p->subKategori}}</div>
                                        <a href="{{url('shop/product/detail/'.$p->id)}}">
                                            <h5>{{$p->name}}</h5>
                                        </a>
                                        <div class="product-price">
                                            Rp. {{number_format($p->variants[0]->price)}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            
                            
                        </div>
                    </div>
                   
                    <div class="loading-more">
                        {{-- <i class="icon_loading"></i> --}}
                        {{$product->links()}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Blog Section End -->

@endsection