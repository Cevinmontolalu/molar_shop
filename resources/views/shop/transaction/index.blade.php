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
                        <span>Daftar Riwayat Transaksi</span>
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
                <div class="col-lg-7 col-md-7">
                    <div class="inner-header">
                        <div class="advanced-search">
                            <button type="button" class="category-btn">Kode Transaksi</button>
                            <div class="input-group">
                                <input type="text" placeholder="Masukan kode transaksi..." id="key">
                                <button type="button" onclick="javascript:search()"><i class="ti-search"></i></button>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-lg-12">
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <th>Alamat</th>
                                    <th>Kuantiti</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $dc)
                                <tr>
                                    <td class="cart-pic first-row">
                                        <a href="{{url('shop/transaction/detail/'.$dc->id)}}">{{$dc->code}}</a>
                                    </td>
                                    <td class="cart-title first-row">{{date('d, F Y h:i:s',strtotime($dc->tanggal." ".$dc->jam))}}</td>
                                    <td class="cart-title first-row">{{$dc->Address}}</td>
                                    <td class="qua-col first-row">
                                        {{number_format($dc->quantity)}} items
                                    </td>
                                    <td class="total-price first-row">Rp.{{number_format($dc->total)}}</td>
                                    <td class="close-td first-row">{{$dc->status}}</td>
                                </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
                        <div>
                            {{$data->links()}}
                        </div>
                    </div>
                    <div class="row">
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->
    <script>
        function search(){
            var key = $('#key').val();
            if(key!==undefined && key!==""){
                window.location = "{{url('shop/transaction/search/')}}/"+key;
            }
        }
    </script>
    <!-- Partner Logo Section Begin -->
   
@endsection