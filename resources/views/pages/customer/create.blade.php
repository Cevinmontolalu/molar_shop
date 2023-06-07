@extends('layouts.layout')
@section('content')
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{$pageName}} Table</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Beranda</a></div>
              <div class="breadcrumb-item"><a href="#">Kategori</a></div>
              <div class="breadcrumb-item">Form</div>
            </div>
          </div>

          <div class="section-body">
            <!-- <h2 class="section-title">Table</h2>
            <p class="section-lead">Example of some Bootstrap table components.</p> -->

            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
              <form method="post" action="{{route('customer.store')}}">
                  @csrf
                <div class="card">
                  <div class="card-header">
                    <h4>Data {{$pageName}}</h4>
                    <div class="card-header-action">
                      <a href="{{url('customer')}}" class="btn btn-success">Kembali</a>
                    </div>
                  </div>
                  <div class="card-body">
                      <x-alert></x-alert>
                    
                        <div class="form-group">
                            <label>Nama</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-font"></i>
                                    </div>
                                </div>
                                <input type="text" name="name" id="name" class="form-control phone-number">
                            </div>
                            
                        </div>
                        <div class="form-group">
                          <label>Email</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="fa fa-envelope"></i>
                                  </div>
                              </div>
                              <input type="text" name="email" id="email" class="form-control phone-number">
                          </div>
                          
                        </div>
                        <div class="form-group">
                          <label>No. Telpon</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="fa fa-phone"></i>
                                  </div>
                              </div>
                              <input type="text" name="phone_no" id="phone_no" class="form-control phone-number">
                          </div>
                          
                        </div>
                        <div class="form-group">
                          <label>Jenis Kelamin</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="fa fa-transgender"></i>
                                  </div>
                              </div>
                              <select class="form-control" name="gender" id="gender">
                                <option value="Male">Laki-Laki</option>
                                <option value="Female">Perempuan</option>
                              </select> 
                          </div>
                          
                        </div>
                        <div class="form-group">
                          <label>Tanggal Lahir</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="fa fa-calendar"></i>
                                  </div>
                              </div>
                              <input type="date" name="dob" id="dob" class="form-control"/>
                          </div>
                          
                        </div>
                        <div class="form-group">
                          <label>Status</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="fa fa-check-circle"></i>
                                  </div>
                              </div>
                              <select class="form-control" name="status" id="status">
                                <option value="Active">Aktif</option>
                                <option value="Not Active">Tidak Aktif</option>
                              </select> 
                          </div>
                          
                        </div>
                        <div class="form-group">
                          <label>Kata Sandi</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="fa fa-lock"></i>
                                  </div>
                              </div>
                              <input type="password" name="password" id="password" value="--" class="form-control"/>
                          </div>
                          
                        </div>
                        <div class="form-group">
                          <label>Konfirmasi Kata Sandi</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="fa fa-lock"></i>
                                  </div>
                              </div>
                              <input type="password" name="password_confirmation" id="password_confirmation" value="--" class="form-control"/>
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