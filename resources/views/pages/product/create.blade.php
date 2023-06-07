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
              <div class="col-12 col-md-6 col-lg-6">
              <form method="post" action="{{route('product.store')}}">
                  @csrf
                <div class="card">
                  <div class="card-header">
                    <h4>Data {{$pageName}}</h4>
                    <div class="card-header-action">
                      <a href="{{url('product')}}" class="btn btn-success">Kembali</a>
                    </div>
                  </div>
                  <div class="card-body">
                      <x-alert></x-alert>
                    
                        <div class="form-group">
                            <label>Nama Produk</label>
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
                            <label>Kategori Produk</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-list-alt"></i>
                                    </div>
                                </div>
                                <select name="categoryId" class="form-control" onchange="javascript:getSubKategori()" id="kategori">
                                    <option value="">Pilih Kategori Produk</option>
                                    @foreach($kategori as $k)
                                        <option value="{{$k->id}}">{{$k->name}}</option>
                                    @endforeach
                                </select>
                                    
                            </div>
                            
                        </div>
                        <div class="form-group">
                          <label>Sub Kategori Produk</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="fa fa-list"></i>
                                  </div>
                              </div>
                              <select name="subCategoryId" class="form-control" id="subKategori">
                                  <option value="">Pilih Sub Kategori Produk</option>
                                  
                              </select>
                                  
                          </div>
                          
                      </div>
                        <div class="form-group">
                            <label>Deskripsi Produk</label>
                            <div class="input-group">
                               
                                <textarea cols="50" rows="8" name="description" class="form-control"></textarea>
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