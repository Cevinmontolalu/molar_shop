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
                        <span>Login</span>
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
                        <h2>Mendaftar</h2>
                        <form action="{{url('shop/try-register')}}" method="POST">
                            @csrf
                            <div class="group-input">
                                <label for="username">Email *</label>
                                <input type="email" required id="username" name="email">
                            </div>
                            <div class="group-input">
                                <label for="pass">Nama *</label>
                                <input type="text" name="name" id="pass">
                            </div>
                            <div class="group-input">
                                <label for="pass">No. Telp</label>
                                <input type="text" name="phone_no" id="pass">
                            </div>
                            <hr>
                            <div class="group-input">
                                <label for="pass">Kata Sandi *</label>
                                <input type="password" name="password" id="pass">
                            </div>
                            <div class="group-input">
                                <label for="pass">Konfirmasi Kata Sandi *</label>
                                <input type="password" name="password_confirmation" id="pass">
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
                            <button type="submit" class="site-btn login-btn">Mendaftar</button>
                        </form>
                        <div class="switch-login">
                            <a href="{{url('shop/login')}}" class="or-login">Atau Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Form Section End -->

    
@endsection