@extends('shop.partial.layouts')
@section('content')
    <!-- Header End -->
  
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{url('/')}}"><i class="fa fa-home"></i> Beranda</a>
                        <a href="{{url('/shop/transaction/detail/'.$transaction->id)}}">Transaksi</a>
                        <span>Upload Bukti Transfer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Form Section Begin -->

    <!-- Register Section Begin -->
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="login-form">
                        <h2>Upload Bukti Transfer</h2>
                        <form action="{{url('shop/transaction/upload')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="transactionId" value="{{$transaction->id}}"/>
                            <div class="group-input">
                                <label for="username">Bank</label>
                                <select name="rekeningId">
                                    <option value="">Pilih bank tujuan</option>
                                    @foreach($shopRekening as $sr)
                                        <option value="{{$sr->id}}">{{$sr->name}} : {{$sr->nomor_rekening}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="group-input">
                                <input type='file' name="foto"/>
                            </div>
                            @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissable">
                                {{ Session::get('error') }}
                            </div>
                            @endif
                            {{-- <div class="group-input gi-check">
                                <div class="gi-more">
                                    <label for="save-pass">
                                        Save Password
                                        <input type="checkbox" id="save-pass">
                                        <span class="checkmark"></span>
                                    </label>
                                    <a href="#" class="forget-pass">Forget your Password</a>
                                </div>
                            </div> --}}
                            <button type="submit" class="site-btn login-btn">Submit Bukti Transfer</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Form Section End -->

    
@endsection