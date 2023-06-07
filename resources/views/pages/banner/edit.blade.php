@extends('layouts.layout')
@section('content')
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{$pageName}} Table</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Beranda</a></div>
              <div class="breadcrumb-item"><a href="#">{{$pageName}}</a></div>
              <div class="breadcrumb-item">Form</div>
            </div>
          </div>

          <div class="section-body">
            <!-- <h2 class="section-title">Table</h2>
            <p class="section-lead">Example of some Bootstrap table components.</p> -->

            <div class="row">
                <div class="col-lg-12">
                    <x-alert></x-alert>
                </div>
              <div class="col-12 col-md-6 col-lg-6">
              <form method="post" action="{{route('banner.update',$data->id)}}">
                  @csrf
                  @method('put')
                <div class="card">
                  <div class="card-header">
                    <h4>Data {{$pageName}}</h4>
                    <div class="card-header-action">
                      <a href="{{url('banners')}}" class="btn btn-success">Kembali</a>
                    </div>
                  </div>
                  <div class="card-body">
                      
                    
                        <div class="form-group">
                            <label>Judul</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-font"></i>
                                    </div>
                                </div>
                                <input type="text" name="title" id="title" value="{{$data->title}}" class="form-control phone-number">
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-list-alt"></i>
                                    </div>
                                </div>
                                <input type="text" name="description" id="description" value="{{$data->description}}" class="form-control phone-number">
                                    
                            </div>
                            
                        </div>
                        <div class="form-group">
                          <label>LINK</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="fa fa-list"></i>
                                  </div>
                              </div>
                              <input type="text" name="link" id="link" value="{{$data->link}}" class="form-control phone-number">
                                  
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
              <div class="col-12 col-md-6 col-lg-6">
                <form method="post" action="{{url('banner/update-gambar')}}" enctype="multipart/form-data">
                    @csrf
                    {{-- @method('put') --}}
                    <input type="hidden" value="{{$data->id}}" name="id"/>
                  <div class="card">
                    <div class="card-header">
                      <h4>Data {{$pageName}} : Update Gambar</h4>
                      <div class="card-header-action">
                        <a href="{{url('banner')}}" class="btn btn-success">Kembali</a>
                      </div>
                    </div>
                    <div class="card-body">
                        <img src="{{asset('banner/'.$data->image)}}" width="100%"/>
                          
                        <div class="form-group">
                          <label>Ganti Gambar</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="far fa-file-image"></i>
                                  </div>
                              </div>
                              <input type="file" name="file" id="file"  class="form-control phone-number">
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
          function getSubKategori(){
            let categoryId = $('#kategori').val();
            $.ajax({
              url:"{{url('sub-category/category/')}}/"+categoryId,
              type:'GET',
              success:function(data){
                if(data["data"].length>0){
                  $('#subKategori').find('option').remove().end().append(`<option value="">Pilih Sub Kategori</option>`);
                  let subKategori = data['data'];
                  subKategori.forEach(function(element){
                    $('#subKategori').append(`<option value="${element.id}">${element.name}</option>`);
                  });
                  $('#subKategori').prop('disabled',false);
                }else{
                  $('#subKategori').find('option').remove().end().append(`<option value="">Tidak ada sub kategori</option>`);
                }
              }
            });
          }
    </script>
@endsection