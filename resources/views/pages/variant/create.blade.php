@extends('layouts.layout')
@section('content')
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{$pageName}} Table</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="#">Beranda</a></div>
              <div class="breadcrumb-item"><a href="{{url('product/detail/'.$product->id)}}">Produk</a></div>
              <div class="breadcrumb-item active"><a href="#">{{$pageName}}</a></div>
              <div class="breadcrumb-item">Form</div>
            </div>
          </div>

          <div class="section-body">
            <!-- <h2 class="section-title">Table</h2>
            <p class="section-lead">Example of some Bootstrap table components.</p> -->

            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
              <form method="post" action="{{url('variant_product/store')}}">
                  @csrf
                <div class="card">
                  <div class="card-header">
                    <h4>Data {{$pageName}}</h4>
                    <div class="card-header-action">
                      <a href="{{url('product/detail/'.$product->id)}}" class="btn btn-success">Kembali</a>
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
                                <input type="text" readonly name="product_name" id="product_name" class="form-control phone-number" value="{{$product->name}}">
                                <input type="hidden" name="productId" value="{{$product->id}}"/>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label>Nama Variant</label>
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
                            <label>Stok</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-book"></i>
                                    </div>
                                </div>
                                <input type="number" name="stock" id="stock" class="form-control phone-number">
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-money-bill"></i>
                                    </div>
                                </div>
                                <input type="number" name="price" id="price" class="form-control phone-number">
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Variant</label>
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
          
    </script>
@endsection