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
              <form method="post" action="{{route('subCategory.update',$data->id)}}">
                @method('put')
                  @csrf
                <div class="card">
                  <div class="card-header">
                    <h4>Data {{$pageName}}</h4>
                    <div class="card-header-action">
                      <a href="{{url('subCategory')}}" class="btn btn-success">Kembali</a>
                    </div>
                  </div>
                  <div class="card-body">
                      <x-alert></x-alert>
                    
                        <div class="form-group">
                            <label>Nama Sub Kategori</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-font"></i>
                                    </div>
                                </div>
                                <input type="text" name="name" id="name" value="{{$data->name}}" class="form-control phone-number">
                            </div>
                            
                        </div>
                        <div class="form-group">
                          <label>Kategori</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="fa fa-list-alt"></i>
                                  </div>
                              </div>
                              <select name="categoryId" class="form-control" >
                                  <option value="">Pilih Kategori</option>
                                  @foreach($kategori as $k)
                                      <?php $selected="";
                                      if($k->id==$data->categoryId)
                                        $selected = "selected";
                                      ?>
                                      <option {{$selected}} value="{{$k->id}}">{{$k->name}}</option>
                                  @endforeach
                              </select>
                                  
                          </div>
                          
                      </div>
                        <div class="form-group">
                            <label>Deskripsi Kategori</label>
                            <div class="input-group">
                               
                                <textarea cols="50" rows="8" name="description" class="form-control">{{$data->description}}</textarea>
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