@extends('shop.partial.layouts')
@section('content')

    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a>
                        <a href="{{url('shop/product')}}">Produk</a>
                        <span>Detail</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad page-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="filter-widget">
                        <h4 class="fw-title">Kategori</h4>
                        <ul class="filter-catagories">
                            {{-- <li><a href="#">Men</a></li>
                            <li><a href="#">Women</a></li>
                            <li><a href="#">Kids</a></li> --}}
                            @foreach($shared['kategori'] as $k)
                            <li class="active"><a class="@if($product->categoryId==$k->id) active @endif" href="{{url('shop/product/category/'.$k->id)}}">{{$k->name}}</a></li>
                            @endforeach
                            <li><a href="{{url('shop/product')}}">SEMUA</a></li>
                        </ul>
                    </div>
                    <div class="filter-widget">
                        <h4 class="fw-title">Sub Kategori</h4>
                        <ul class="filter-catagories">
                            {{-- <li><a href="#">Men</a></li>
                            <li><a href="#">Women</a></li>
                            <li><a href="#">Kids</a></li> --}}
                            @foreach($subKategori as $k)
                            <li class="active"><a class="@if($product->subCategoryId==$k->id) active @endif" href="{{url('shop/product/category/'.$k->id)}}">{{$k->name}}</a></li>
                            @endforeach
                            
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6">
                            @if(count($galleries)>0)
                            <div class="product-pic-zoom">
                                
                                    <img class="product-big-img" src="{{asset('gallery/'.$product->id.'/'.$galleries[0]->link)}}" alt="{{$galleries[0]->name}}">
                                    <div class="zoom-icon">
                                        <i class="fa fa-search-plus"></i>
                                </div>
                                
                            </div>
                            <div class="product-thumbs">
                                <div class="product-thumbs-track ps-slider owl-carousel">
                                    @foreach($galleries as $g)
                                            <div class="pt active" data-imgbigurl="{{asset('gallery/'.$product->id.'/'.$g->link)}}"><img
                                                    src="{{asset('gallery/'.$product->id.'/'.$g->link)}}" alt="{{$g->name}}"></div>
                                            
                                        @endforeach
                                    
                                </div>
                            </div>
                            @else
                            <div style="border:1px solid black">
                                <img src="{{asset('gallery/image-not-available.jpeg')}}" height="250px" alt="No Image">
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <div class="product-details">
                                <div class="pd-title">
                                    <span>{{$product->kategori}} -> {{$product->subKategori}}</span>
                                    <h3>{{$product->name}}</h3>
                                    {{-- <a href="#" class="heart-icon"><i class="icon_heart_alt"></i></a> --}}
                                </div>
                                {{-- <div class="pd-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <span>(5)</span>
                                </div> --}}
                                <div class="pd-desc" >
                                    <p id="pd-desc">{{$variant[0]->description}}</p>
                                    <h4 id="price">Rp. {{number_format($variant[0]->price)}}</h4>
                                </div>
                                <div class="pd-size-choose">
                                    <h6>Variant</h6>
                                    @foreach($variant as $v)
                                        <div class="sc-item">
                                            <input type="radio" id="{{$v->id}}" name="variant" value="{{$v->id}}" onchange="javascript:changeVariant('{{$v->description}}','{{number_format($v->price)}}',{{$v->stock}},{{$v->id}});"/>
                                            <label for="{{$v->id}}">{{$v->name}}</label>
                                        </div>
                                        {{-- <div class="sc-item">
                                            <input type="radio" id="{{$v->id}}">
                                            <label for="cc-black">{{$v->name}}</label>
                                        </div> --}}
                                        {{-- <div class="cc-item">
                                            <input type="radio" id="cc-yellow">
                                            <label for="cc-yellow" class="cc-yellow"></label>
                                        </div>
                                        <div class="cc-item">
                                            <input type="radio" id="cc-violet">
                                            <label for="cc-violet" class="cc-violet"></label>
                                        </div> --}}
                                    @endforeach
                                   
                                </div>
                                {{-- <div class="pd-size-choose">
                                    
                                    <div class="sc-item">
                                        <input type="radio" id="sm-size">
                                        <label for="sm-size">s</label>
                                    </div>
                                    <div class="sc-item">
                                        <input type="radio" id="md-size">
                                        <label for="md-size">m</label>
                                    </div>
                                    <div class="sc-item">
                                        <input type="radio" id="lg-size">
                                        <label for="lg-size">l</label>
                                    </div>
                                    <div class="sc-item">
                                        <input type="radio" id="xl-size">
                                        <label for="xl-size">xs</label>
                                    </div>
                                </div> --}}
                                <form method="POST" action="{{url('shop/user/addToCart')}}" id="form-add">
                                    @csrf
                                    <!-- <div class="quantity">
                                        <div class="pro-qty"> -->
                                            <input type="hidden" value="1" name="quantity">
                                            <input type="hidden" value="{{$product->id}}" name="productId"/>
                                            <input type="hidden" value="-1" name="variantId" id="variantId"/> 
                                            <input type="hidden" value="/shop/product/detail/{{$product->id}}" name="link"/>
                                        <!-- </div> -->
                                        <button type="button" onclick="javascript:addToCart()" class="primary-btn pd-cart">+ Keranjang</button>
                                    <!-- </div> -->
                                </form>
                                {{-- <ul class="pd-tags">
                                    <li><span>CATEGORIES</span>: More Accessories, Wallets & Cases</li>
                                    <li><span>TAGS</span>: Clothing, T-shirt, Woman</li>
                                </ul>
                                <div class="pd-share">
                                    <div class="p-code">Sku : 00012</div>
                                    <div class="pd-social">
                                        <a href="#"><i class="ti-facebook"></i></a>
                                        <a href="#"><i class="ti-twitter-alt"></i></a>
                                        <a href="#"><i class="ti-linkedin"></i></a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-table">
                                <table>
                                    <tr><th style="text-align: left;padding-left:25px">Deskripsi</th></tr>
                                    <tr><td style="text-align: left;padding-left:25px"><p>{{$product->description}}</p></td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    {{-- <div class="product-tab">
                        <div class="tab-item">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#tab-1" role="tab">DESKRIPSI</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab-2" role="tab">SPECIFICATIONS</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab-3" role="tab">Customer Reviews (02)</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-item-content">
                            <div class="tab-content">
                                <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
                                    <div class="product-content">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                 <p>{{$product->description}}</p>
                                               
                                            </div>
                                            <div class="col-lg-5">
                                                <img src="img/product-single/tab-desc.jpg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                    <div class="customer-review-option">
                                        <h4>2 Comments</h4>
                                        <div class="comment-option">
                                            <div class="co-item">
                                                <div class="avatar-pic">
                                                    <img src="img/product-single/avatar-1.png" alt="">
                                                </div>
                                                <div class="avatar-text">
                                                    <div class="at-rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <h5>Brandon Kelley <span>27 Aug 2019</span></h5>
                                                    <div class="at-reply">Nice !</div>
                                                </div>
                                            </div>
                                            <div class="co-item">
                                                <div class="avatar-pic">
                                                    <img src="img/product-single/avatar-2.png" alt="">
                                                </div>
                                                <div class="avatar-text">
                                                    <div class="at-rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <h5>Roy Banks <span>27 Aug 2019</span></h5>
                                                    <div class="at-reply">Nice !</div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Blog Section End -->

    <div class="related-products spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Produk Terkait</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(count($related_product)>0)
                    @foreach($related_product as $rp)
                <div class="col-lg-3 col-sm-6">
                    
                    <div class="product-item">
                        <div class="pi-pic">
                            @if(isset($rp->galleries[0]))
                                <img src="{{asset('gallery/'.$rp->id.'/'.$rp->galleries[0]->link)}}" height="250px" alt="">
                            @else
                                <div style="border:1px solid black">
                                    <img src="{{asset('gallery/image-not-available.jpeg')}}" height="250px" alt="No Image">
                                </div>
                            @endif
                            <div class="sale">Sale</div>
                            <div class="icon">
                                <i class="icon_heart_alt"></i>
                            </div>
                            <ul>
                                <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                <li class="quick-view"><a href="{{url('shop/product/detail/'.$rp->id)}}">+ Quick View</a></li>
                                <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="catagory-name">{{$rp->kategori}}</div>
                            <a href="{{url('shop/product/detail/'.$rp->id)}}">
                                <h5>{{$rp->name}}</h5>
                            </a>
                            <div class="product-price">
                                Rp. {{number_format($rp->variants[0]->price)}}
                                {{-- <span>$35.00</span> --}}
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach
                @endif
                
                
            </div>
        </div>
    </div>

    
<script>
    function changeVariant(deskripsi,price,stock,id){
        document.getElementById('pd-desc').innerHTML = deskripsi;
        // alert("PRice : "+price);
        document.getElementById('variantId').value = id;
        document.getElementById('price').innerHTML = "Rp. "+price;
    }
    
    function addToCart(){
        var variant = $('#variantId').val();
        if(variant=="-1"){
            alert("Silahkan pilih variant terlebih dahulu!");
        }else{
            $('#form-add').submit();
        }
    }
</script>
@endsection