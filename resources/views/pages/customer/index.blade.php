@extends('layouts.layout')
@section('content')
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{$pageName}} Table</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="#">$pageName</a></div>
              <div class="breadcrumb-item">Table</div>
            </div>
          </div>

          <div class="section-body">
            <!-- <h2 class="section-title">Table</h2>
            <p class="section-lead">Example of some Bootstrap table components.</p> -->

            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                  <a href="{{url('/customer/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>&nbsp;
                    <h4>Data {{$pageName}}</h4>
                    <div class="card-header-action">
                        
                      <form>
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Search">
                          <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card-body">
                      <x-alert></x-alert>
                    <div class="row">
                      
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="table-responsive">
                          <table class="table table-bordered table-striped table-md data-table">
                            <tr>
                              <th>#</th>
                              <th>Aksi</th>
                              <th>..</th>
                              <th>Nama</th>
                              <th>Email</th>
                              <th>No. Telp</th>
                              <th>JK</th>
                              <th>TL</th>
                              <th>Status</th>
                              <th>Dibuat oleh</th>
                              <th>Dibuat pada</th>
                              
                            </tr>
                            <?php $index=(($data->currentPage()-1)*$data->perPage())+1;?>
                            @foreach($data as $d)
                                <tr>
                                    <td style="width:50px">{{$index}}</td>
                                    <td style="width:10%;">
                                        <form method="post" action="{{url('customer/destroy',$d->id)}}">
                                            <a href='{{url("/customer/edit/".$d->id)}}' class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                            <a href="{{url('/customer/detail/'.$d->id)}}" class="btn btn-info"><i class="fa fa-file"></i></a>
                                            @csrf
                                            @method('delete')
    
                                            <button type="submit" class="btn btn-danger show_confirm" data="{{$d->name}}"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                      @if($d->profile_picture!="")
                                        <img class="mr-3 rounded-circle" src="{{asset('profile_picture/'.$d->profile_picture)}}" width="50px" height="50px"/>
                                      @else
                                        <img class="mr-3 rounded-circle" src="{{asset('profile_picture/no_avatar.png')}}" width="50px" height="50px"/>
                                      @endif
                                    </td>
                                      
                                    <td>{{$d->name}}</td>
                                    <td>{{$d->email}}</td>
                                    <td>{{$d->phone_no}}</td>
                                    <td>{{$d->gender}}</td>
                                    <td>{{date('d F Y',strtotime($d->dob))}}</td>
                                    <td>
                                      <?php
                                        $badge = "success";
                                        if($d->status!='Active')
                                          $badge = "warning";
                                      ?>
                                      <div class="badge badge-{{$badge}}">{{$d->status}}</div></td>
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
                  <div class="card-footer text-right">
                    <nav class="d-inline-block">
                        {{$data->links()}}
                      <!-- <ul class="pagination mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                      </ul> -->
                    </nav>
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
          
    </script>
    
    <script type="text/javascript">
 
 $('.show_confirm').click(function(event) {
      var form =  $(this).closest("form");
      event.preventDefault();
      new swal({
            title: `Are you sure you want to delete this record?`,
            text: "If you delete it, it will be gone forever.",
            icon: "warning",
            
            buttons: ["Cancel","Yes!"],
            dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          form.submit();
            alert("Will Delete Value : "+JSONStringify(willDelete));
        }else{
            alert("Something");
        }
      });
  });

</script>
@endsection