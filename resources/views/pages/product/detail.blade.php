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
                                <input value="{{$data->name}}" type="text" readonly name="name" id="name" class="form-control phone-number">
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
                                <input type="text" readonly value="{{$data->kategori}}" name="kategori" id="name" class="form-control phone-number">
                                    
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label>Sub Kategori Produk</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-list-alt"></i>
                                    </div>
                                </div>
                                <input type="text" readonly value="{{$data->subKategori}}" name="kategori" id="name" class="form-control phone-number">
                                    
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Produk</label>
                            <div class="input-group">
                               
                                <textarea cols="50" rows="8" readonly name="description" class="form-control">{{$data->description}}</textarea>
                            </div>
                            
                        </div>
                       
                  </div>
             

                </div>
                </form>
              </div>
              {{-- <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="card card-warning" >
                    <div class='card-header'>
                        <h4>Review</h4>
                    </div>
                    <div class="card-body" style="max-height:380px;min-height:380px;overflow:auto">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>No.</th>
                                <th>Pelanggan</th>
                                <th>Rating</th>
                                <th>Notes</th>
                                <th>Tanggal</th>
                            </tr>
                            <?php $index=(($review->currentPage()-1)*$review->perPage())+1;?>
                            @foreach($review as $r)
                            <tr>
                                <td>{{$index}}</td>
                                <td>{{$r->pelanggan}}</td>
                                <td>{{$r->rating}}</td>
                                <td>{{$r->description}}</td>
                                <td>{{date('d F Y H:i:s',strtotime($r->created_at))}}</td>
                            </tr>
                            <?php $index+=1;?>
                            @endforeach
                        </table>
                            
                    </div>
                    <div class="card-footer">
                        {{$review->links()}}
                    </div>
                </div>
              </div> --}}
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card card-primary" >
                    <div class='card-header'>
                        <h4>Gallery</h4>
                        <div class="card-header-action">
                            <a href="{{url('gallery/create/'.$data->id)}}" class="btn btn-primary">Tambah Foto</a>
                          </div>
                    </div>
                    <div class="card-body" style="max-height:420px;min-height:420px;">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2" style="max-height:350px;overflow:auto">
                                <table class="table table-bordered table-striped">
                                    <tr><th>Daftar Gambar</th></tr>
                                    @foreach($galleries as $g)
                                    <tr>
                                        <td onclick="imageClick('{{asset('gallery/'.$g->productId.'/'.$g->link)}}','{{$g->id}}')"><img src="{{asset('gallery/'.$g->productId.'/'.$g->link)}}" width="100%" /></td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9" style="max-height:350px;max-width:100%;overflow:auto;background-size:contain;background-repeat:no-repeat;transition:1s" id="image_panel">
                                <form method="post" id="delete_gallery" style="float:right;display:none;">
                                    @csrf
                                    @method('delete')

                                    <button type="button" onclick="deleteGallery()" class="btn btn-danger show_confirm"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h4>Variant Produk</h4>
                        <div class="card-header-action">
                            <a href="{{url('variant_product/create/'.$data->id)}}" class="btn btn-primary">Tambah Variant</a>
                          </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-md data-table">
                              <tr>
                                <th>#</th>
                                <th>Aksi</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Stock</th>
                                <th>Harga</th>
                                <th>Dibuat oleh</th>
                                <th>Dibuat pada</th>
                                
                              </tr>
                              <?php $index=1;?>
                              @foreach($variant as $d)
                                  <tr>
                                      <td style="width:50px">{{$index}}</td>
                                      <td style="width:15%;">
                                          <form method="post" action="{{url('variant_product/destroy',$d->id)}}">
                                              <a href='{{url("/variant_product/edit/".$d->id)}}' class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                          
                                              @csrf
                                              @method('delete')
      
                                              <button type="submit" class="btn btn-danger show_confirm" data="{{$d->name}}"><i class="fa fa-trash"></i></button>
                                          </form>
                                      </td>
                                     
                                        
                                      <td>{{$d->name}}</td>
                                      <td>{{$d->description}}</td>
                                      <td>{{$d->stock}}</td>
                                      <td>{{number_format($d->price)}}</td>
                                      <td>{{$d->created_by}}</td>
                                      <td>{{date('l, d F Y h:i:s a',strtotime($d->created_at))}}</td>
                                  </tr>
                              <?php $index+=1;?>
                             @endforeach
                              
                            
                            </table>
                          </div>
                    </div>
                </div>
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
          var selectedGalleryId = "";
          function imageClick(path,id){
            selectedGalleryId = id;
            $('#delete_gallery').show();
            $('#image_panel').css("background-image","url("+path+")");
          }
          function deleteGallery(){
            $.ajax({
                url:"{{url('gallery/destroy/')}}/"+selectedGalleryId,
                type:'DELETE',
                data:{
                    "_token":"{{csrf_token()}}",
                    "id":selectedGalleryId
                },
                success:function(data){
                    window.location = "{{url('product/detail/'.$data->id)}}";
                }
          });
          }
          
    </script>
@endsection