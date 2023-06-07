@extends('layouts.layout')
@section('content')
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{$pageName}} Table</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Beranda</a></div>
              <div class="breadcrumb-item"><a href="#">Pengguna</a></div>
              <div class="breadcrumb-item">Form</div>
            </div>
          </div>

          <div class="section-body">
            <!-- <h2 class="section-title">Table</h2>
            <p class="section-lead">Example of some Bootstrap table components.</p> -->

            <div class="row">
              <div class="col-12"><x-alert></x-alert></div>
              <div class="col-12 col-md-6 col-lg-6">
              <form method="post" action="{{url('user/update/'.$data->id)}}">
                @method('put')
                  @csrf
                <div class="card">
                  <div class="card-header">
                    <h4>Data {{$pageName}}</h4>
                    <div class="card-header-action">
                      <a href="{{url('user')}}" class="btn btn-success">Kembali</a>
                    </div>
                  </div>
                  <div class="card-body">
                      
                      <input type="hidden" name="email" value="{{$data->email}}"/>
                      <input type="hidden" name="page" value="{{$page}}"/>
                      <div class="form-group">
                        <label>Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-font"></i>
                                </div>
                            </div>
                            <input type="text" name="nams" id="name" value="{{$data->email}}" readonly class="form-control phone-number">
                        </div>
                        
                    </div>
                      <div class="form-group">
                        <label>Nama</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-font"></i>
                                </div>
                            </div>
                            <input type="text" name="name" id="name" value="{{$data->name}}" class="form-control phone-number">
                        </div>
                        
                    </div>
                   
                  
                    
                  </div>
                  <div class="card-footer text-right">
                    <nav class="d-inline-block">
                      <button type="submit" class="btn btn-molar">Submit</button>
                    </nav>
                  </div>

                </div>
                </form>
              </div>
              @if(request()->segment(1)=="profile")
              <div class="col-12 col-md-6 col-lg-6">
                <form method="post" action="{{url('profile/update-password')}}">
                  @method('put')
                    @csrf
                  <div class="card">
                    <div class="card-header">
                      <h4>Kata Sandi {{$pageName}}</h4>
                      
                    </div>
                    <div class="card-body">
                        
                        <input type="hidden" name="id" value="{{$data->id}}"/>
                        <div class="form-group">
                          <label>Kata Sandi Lama</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="fa fa-font"></i>
                                  </div>
                              </div>
                              <input type="password" name="oldpwd" id="name" class="form-control phone-number">
                          </div>
                          
                      </div>
                        <div class="form-group">
                          <label>Kata Sandi Baru</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="fa fa-lock"></i>
                                  </div>
                              </div>
                              <input type="password" name="password" id="name"  class="form-control phone-number">
                          </div>
                          
                      </div>
                      <div class="form-group">
                        <label>Konfirmasi Kata Sandi Baru</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                </div>
                            </div>
                            <input type="password" name="password_confirmation" id="name"  class="form-control phone-number">
                        </div>
                        
                    </div>
                    
                      
                    </div>
                    <div class="card-footer text-right">
                      <nav class="d-inline-block">
                        <button type="submit" class="btn btn-molar">Submit</button>
                      </nav>
                    </div>
  
                  </div>
                  </form>
                </div>
                @endif
            
           
          </div>
        </section>
      </div>
      <script>
          document.onreadystatechange = ()=>{
              if(document.readyState==='complete'){
                  $('#alert').fadeOut(5000);
              }
          }
          
    </script>
@endsection