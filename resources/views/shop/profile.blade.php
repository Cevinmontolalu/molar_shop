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
                        <span>Profile</span>
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
                <div class="col-lg-6 offset-3">
                    <div class="profile-picture">
                        <img src="{{asset('profile_picture/'.$user->profile_picture)}}" alt="">
                    </div>
                    <div class="login-form">
                        <h4 style="text-align: center">Foto Profil</h4>
                        <form action="{{url('shop/update-foto')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <input type="hidden" value="{{$user->id}}" name="id"/>
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
                            <button type="submit" class="site-btn login-btn">Ubah Foto Profil</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    <hr>
                </div>
                <div class="col-lg-6">
                    <div class="login-form">
                        <h2>Profil Pelanggan</h2>
                        <form action="{{url('shop/update-profile')}}" method="POST">
                            @csrf
                            @method('put')
                            <div class="group-input">
                                <label for="username">Email *</label>
                                <input type="hidden" value="{{$user->id}}" name="id"/>
                                <input type="email" required id="username" name="email" value="{{$user->email}}" readonly="readonly">
                            </div>
                            <div class="group-input">
                                <label for="pass">Nama *</label>
                                <input type="text" name="name" id="pass" value="{{$user->name}}">
                            </div>
                            <div class="group-input">
                                <label for="pass">No. Telp</label>
                                <input type="text" name="phone_no" id="pass" value="{{$user->phone_no}}">
                            </div>
                            <div class="group-input">
                                <label for="gender">Jenis Kelamin</label>
                                <?php $options = ["Belum diisi","Male","Female"];?>
                                <select name="gender" id="gender">
                                    @foreach($options as $opt)
                                        <?php $selected = "";
                                            if($opt ==$user->gender)
                                                $selected = "selected";
                                        ?>
                                        <option {{$selected}} value="{{$opt}}">{{$opt}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="group-input">
                                <label for="dob">Tanggal Lahir</label>
                                <input type="date" name="dob" id="dob" value="{{$user->dob}}">
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
                            <button type="submit" class="site-btn login-btn">Ubah Profil</button>
                        </form>
                        
                    </div>
                </div>
                <div class="offset-lg-2 col-lg-4 ">
                    <div class="login-form">
                        <h2>Ubah Kata Sandi</h2>
                        <form action="{{url('shop/update-password')}}" method="POST">
                            @csrf
                            @method('put')
                            <div class="group-input">
                                <input type="hidden" value="{{$user->id}}" name="id"/>
                                <label for="oldpwd">Kata Sandi Lama*</label>
                                <input type="password" required id="oldpwd" name="oldpwd">
                            </div>
                            <div class="group-input">
                                <label for="newpwd">Kata Sandi Baru * </label>
                                <input type="password" name="password" id="newpwd">
                            </div>
                            <div class="group-input">
                                <label for="cnewpwd">Konfirmasi Kata Sandi Baru * </label>
                                <input type="password" name="password_confirmation" id="cnewpwd">
                            </div>
                            
                            <hr>
                           
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
                            <button type="submit" class="site-btn login-btn">Ubah Kata Sandi</button>
                            <hr>
                            <a href="{{url('shop/user/address')}}" style="width:100%" class='btn btn-lg btn-success'>Daftar Alamat Pengiriman</a>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Form Section End -->

   
@endsection