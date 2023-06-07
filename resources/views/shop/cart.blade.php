@extends('shop.partial.layouts')
@section('content')
    <!-- Header End -->
  
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="./home.html"><i class="fa fa-home"></i> Home</a>
                        <a href="./shop.html">Belanja</a>
                        <span>Keranjang</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th class="p-name">Nama</th>
                                    <th>Harga</th>
                                    <th>Kuantiti</th>
                                    <th>Total</th>
                                    <th><i class="ti-close"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart['detailCart'] as $dc)
                                <tr>
                                    <td class="cart-pic first-row">
                                        <input type="hidden" value="{{$dc->id}}" name="dcId[]"/>
                                        @if(isset($dc->photo))
                                        <img width="50px" height="50px" src="{{asset('gallery/'.$dc->productId.'/'.$dc->photo)}}" alt="{{$dc->productName}}"/>
                                        @else
                                        <img width="50px" height="50px" src="{{asset('gallery/image-not-available.jpeg')}}" alt="{{$dc->productName}}"/>
                                        @endif
                                    </td>
                                    <td class="cart-title first-row"><a href="{{url('shop/product/detail/'.$dc->productId)}}" >{{$dc->productName}}</a></td>
                                    <td class="p-price first-row">Rp.{{number_format($dc->price)}}</td>
                                    <td class="qua-col first-row">
                                        <div class="quantity">
                                            <div class="pro-qt">
                                                <form method="POST" action="{{url('shop/user/addToCart')}}" id="form-{{$dc->id}}">
                                                    @csrf
                                                    <input type="hidden" value="{{$dc->productId}}" name="productId"/>
                                                    <input type="hidden" value="{{$dc->variantId}}" name="variantId"/>
                                                    <input type="hidden" value="1" name="quantity"/>
                                                    <input type="hidden" value="/shop/cart" name="link"/>
                                                    <span class="qtybt dec" onclick="javascript:reduceCart({{$dc->id}})">-</span>
                                                    <input type="text" name="qty" value="{{$dc->quantity}}" id="qty-{{$dc->id}}"/>
                                                    <span class="inc qtybt" id="span-{{$dc->id}}" onclick="javascript:addToCart({{$dc->id}})">+</span>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="total-price first-row">Rp.{{number_format($dc->total)}}</td>
                                    <td class="close-td first-row"><i class="ti-close" onclick="javascript:deleteItem({{$dc->id}})"></i></td>
                                </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            {{-- <div class="cart-buttons">
                                <a href="#" class="primary-btn continue-shop">Continue shopping</a>
                                <a href="#" class="primary-btn up-cart">Update cart</a>
                            </div> --}}
                            {{-- <div class="discount-coupon">
                                <h6>Discount Codes</h6>
                                <form action="#" class="coupon-form">
                                    <input type="text" placeholder="Enter your codes">
                                    <button type="submit" class="site-btn coupon-btn">Apply</button>
                                </form>
                            </div> --}}
                        </div>
                        <div class="col-lg-4 offset-lg-4">
                            <div class="proceed-checkout">
                                <ul>
                                    <li class="subtotal">Subtotal <span>Rp.{{number_format($cart['cart']->subtotal)}}</span></li>
                                    <li class="cart-total">Total <span>Rp.{{number_format($cart['cart']->total)}}</span></li>
                                    
                                </ul>
                                <form method="POST" action="{{url('/shop/checkout')}}" id="form-checkout">
                                <div class="form-login">
                                    
                                        @csrf
                                    <div class="group-input">
                                        <select id="address" name="address">
                                            <option value="">Pilih alamat pengiriman</option>
                                            @foreach($address as $a)
                                                <option value="{{$a->id}}">{{$a->address}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <a href="#" onclick="javascript:prosesCheckout()" class="proceed-btn">CHECKOUT</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->

   
    <!-- Partner Logo Section End -->
    <script>
        function addToCart(id){
            // alert(id);
            var qty = $('#qty-'+id).val();
            qty = parseInt(qty)+1;
            $('#qty-'+id).val(qty);
            $('#form-'+id).submit();
           
            // alert("Quantity "+qty+", QTY INPUT : "+$('#qty-'+id).val());
        }
        function reduceCart(id){
            window.location = "{{url('shop/user/reduceCart/')}}/"+id+"/1";
        }
        function deleteItem(id){
            var qty = $('#qty-'+id).val();
            window.location="{{url('shop/user/reduceCart/')}}/"+id+"/"+qty;
        }
        function prosesCheckout(){
            var address = $('#address').val();
            if(address==="" || address===undefined){
                alert("Silhakan pilih alamat pengiriman terlebih dahulu!");
            }else{
               $('#form-checkout').submit();
            }
        }
    </script>
@endsection