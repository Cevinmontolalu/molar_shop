@extends('shop.partial.layouts')
@section('content')
    <!-- Header End -->
  
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="#"><i class="fa fa-home"></i> Home</a>
                        <a href="{{url('shop/user/address')}}"><i class="fa fa-home"></i> Daftar Alamat</a>
                        <span>Form Alamat</span>
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
                        <h2>Alamat</h2>
                        <form action="{{url('shop/user/address/store')}}" method="POST">
                            @csrf
                            <div class="group-input">
                                <label for="pass">Desa / Daerah : Biaya Pengiriman</label>
                                <select required name="bpId">
                                   <option value="">Pilih Desa / Daerah : Biaya Pengiriman</option>
                                   @foreach($biaya as $b)
                                        <option value="{{$b->id}}">{{$b->nama}} ->Biaya (Rp. {{number_format($b->harga)}}) -> {{$b->deskripsi}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="group-input">
                                <label for="alamat">Alamat</label>
                                <textarea required name="alamat" cols="60" rows="6"></textarea>
                            </div>
                            <div class="group-input">
                                <label for="pass">Atur Sebagai Default</label>
                                <select required name="default">
                                    <option value="True">Default</option>
                                    <option value="False">Cadangan</option>
                                </select>
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
                            <button type="submit" class="site-btn login-btn">Tambah</button>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Form Section End -->

  
@endsection