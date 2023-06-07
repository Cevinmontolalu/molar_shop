@extends('shop.partial.layouts')
@section('content')
    <!-- Header End -->
  
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="{{url('/')}}"><i class="fa fa-home"></i> Beranda</a>
                        <a href="{{url('shop/transactions')}}">Daftar Transaksi</a>
                        <span>Kode Transaksi : {{$transaction->code}}</span>
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
                @if($transaction->status=='New')
                <div class="col-lg-6">
                    <h4>Silahkan melakukan pembayaran melalui rekening di bawah ini : </h4>
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama Bank</th>
                                    <th>Nomor Rekening</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shopRekening as $sr)
                                <tr>
                                    <td class="cart-pic first-row">
                                        <h4><b>{{$sr->name}}</b></h4>
                                    </td>
                                    <td class="cart-title first-row" style="text-align: center"><h4><b><i>{{$sr->nomor_rekening}}</i></b></h4></td>
                                    
                                </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h4>Pastikan saat melakukan Transfer anda memberikan keterangan : <hr>
                        <b>{{$transaction->code}}</b><hr>
                        Agar dapat mempermudah admin kami dalam pengecekan pembayaran</h4>
                        <p><h2>Terima Kasih</h2></p>

                </div>
                @elseif($transaction->status=="On Process")
                <div class="col-lg-12">
                    <h4>Transaksi Anda sendang diperiksa oleh admin kami, mohon menunggu</h4>
                    <h3>Terima Kasih atas perhatiannya</h3>
                    <hr>
                </div>
                @elseif($transaction->status=="Delivery")
                <div class="col-lg-12">
                    <h4>Barang anda sedang dalam pengiriman, pastikan nomor telp anda aktif, agar kurir kami dapat menghubungi anda</h4>
                    <h3>Terima Kasih atas perhatiannya</h3>
                    <hr>
                </div>
                @elseif($transaction->status=="Rejected")
                <div class="col-lg-12" style="background-color:#cf4a4a;color:white !important;padding:10px;border-radius:10px;margin-bottom:20px">
                    <p style="color: white">Mohon Maaf, transaksi anda diTolak, silahkan hubungi <b>{{$shared['shop_profile']->phone_no}}</b> atau kirim email ke <b>{{$shared['shop_profile']->email}}</b>, untuk mendapatkan informasi lebih lanjut</h4>
                    <h3 style="color: white">Terima Kasih atas perhatiannya</h3>
                    <hr>
                </div>
                @elseif($transaction->status=="Finish")
                <div class="col-lg-12" style="margin-bottom:25px">
                    <h4>Terima Kasih telah berbelanja</h4>
                    <hr>
                </div>
                
                @endif
                <br>
                <div class="col-lg-12">
                    <h4>Daftar Belanjaan</h4>
                    <hr>
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th class="p-name">Nama</th>
                                    <th>Harga</th>
                                    <th>Kuantiti</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detailTransaction as $dc)
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
                                        {{number_format($dc->quantity)}} items
                                    </td>
                                    <td class="total-price first-row">Rp.{{number_format($dc->total)}}</td>
                                </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <h4>Di Kirim Ke : </h4>
                            <p><b>Desa / Daerah : {{$address->desa}}</b> {{$address->deskripsi_desa}}</p>

                            <p>{{$address->address}}</p>
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
                        @if($transaction->status=='New')
                        <div class="col-lg-4 offset-lg-4">
                            <div class="proceed-checkout">
                                <ul>
                                    <li class="subtotal">Subtotal <span>Rp.{{number_format($transaction->subtotal)}}</span></li>
                                    <li class="subtotal">Biaya Pengiriman <span>Rp.{{number_format($address->harga)}}</span></li>
                                    <li class="cart-total">Total <span>Rp.{{number_format($transaction->total)}}</span></li>
                                    
                                </ul>
                                
                                <a href="{{url('shop/transaction/upload/'.$transaction->id)}}" class="proceed-btn">UPLOAD BUKTI TRANSFER</a>
                            </div>
                        </div>
                        @elseif($transaction->status=='Delivery')
                        <div class="col-lg-4 offset-lg-4">
                            <form method="POST" action="{{url('shop/finishTransaction')}}">
                            <div class="proceed-checkout">
                                @csrf
                                <input type="hidden" name="id" value="{{$transaction->id}}"/>
                                <input type="hidden" name="status" value="Finish"/>
                                <button type="submit" class="proceed-btn">Barang di Terima</button>
                            </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->

   
@endsection