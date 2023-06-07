@extends('layouts.layout')
@section('content')
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{$pageName}} Table</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="#">{{$pageName}}</a></div>
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
                  {{-- <a href="{{url('/transaksi/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>&nbsp; --}}
                    <h4>Data {{$pageName}}</h4>
                    <div class="card-header-action">
                     
                        
                        <a class="btn btn-molar" data-toggle="collapse" href="#collapseExample" role="button"
                        aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa fa-filter"></i> Filter
                    </a>
                    @php $filter = session('filter-transaction');@endphp
                    @if(isset($filter))
                    <a href="{{url('/transaction/clear-filter')}}" class="btn btn-danger"><i class="fa fa-trash"></i> Clear</a>
                    @endif
                      </div>
                    </div>
                  <div class="card-body">
                      <x-alert></x-alert>
                      <div class="filter">
                        <div class="collapse" id="collapseExample">
                          <form action="{{url('transaction/filter')}}" method="POST">
                          <div class="card card-primary">
                              <div class="card-header">
                                  <h4 class="title">Filter</h4>
                              </div>
                              
                              <div class="card-body">
                                  
                                      @csrf
                                     
                                      <div class="row">
                                          <div class="col-12 col-md-4 col-lg-3">
                                              <div class="form-group">
                                                  <label>Start Date</label>
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <div class="input-group-text">
                                                              <i class="fa fa-calendar"></i>
                                                          </div>
                                                      </div>
                                                      <input type="date"
                                                          class="form-control @error('startDate') is-invalid @enderror"
                                                          name="startDate" value="{{isset($filter['startDate'])?$filter['startDate']:''}}"/>

                                                      @error('startDate')
                                                      <div class="invalid-feedback">
                                                          {{$message}}

                                                      </div>
                                                      @enderror

                                                  </div>

                                              </div>
                                          </div>
                                          <div class="col-12 col-md-4 col-lg-3">
                                              <div class="form-group">
                                                  <label>End Date</label>
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <div class="input-group-text">
                                                              <i class="fa fa-calendar"></i>
                                                          </div>
                                                      </div>
                                                      <input type="date"
                                                          class="form-control @error('endDate') is-invalid @enderror"
                                                          name="endDate" value="{{isset($filter['endDate'])?$filter['endDate']:''}}" />

                                                      @error('endDate')
                                                      <div class="invalid-feedback">
                                                          {{$message}}

                                                      </div>
                                                      @enderror

                                                  </div>

                                              </div>
                                          </div>
                                          <div class="col-12 col-md-6 col-lg-3">
                                              <div class="form-group">
                                                  <label>Status</label>
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <div class="input-group-text">
                                                              <i class="fa fa-object-group"></i>
                                                          </div>
                                                      </div>
                                                      <?php 
                                                        $status = ["New","On Process","Cart","Delivery","Finish","Rejected"];
                                                        $indo =["Baru","Di proses","Keranjang","Pengiriman","Selesai","Ditolak"];
                                                        ?>
                                                      <select
                                                          class="form-control @error('tipe') is-invalid @enderror"
                                                          name="status">
                                                          <option value="">Pilih Status </option>
                                                          <?php $index = 0;?>
                                                          @foreach($status as $s)
                                                            <?php
                                                              $selected = "";
                                                              if(isset($filter['status']) && $filter['status']==$s)
                                                                $selected = "selected";
                                                            ?>
                                                            <option {{$selected}} value="{{$s}}">{{$indo[$index]}}</option>
                                                            <?php $index+=1;?>
                                                          @endforeach
                                                      </select>
                                                      @error('status')
                                                      <div class="invalid-feedback">{{$message}}</div>
                                                      @enderror
                                                  </div>

                                              </div>
                                          </div>
                                          
                                          <div class="col-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                              <label for="action">Terapkan</label><br>
                                              <button type="submit" class="btn btn-primary">Terapkan</button>
                                              @if(isset($filter))
                                                  <a href="{{url('/transaction/clear-filter')}}" class="btn btn-danger">Clear</a>
                                              @endif
                                            </div>
                                          </div>
                                          
                                 
                              </div>
                             
                          </div>
                      </form>
                      </div>
                      </div>
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped table-md data-table">
                        <tr>
                          <th>#</th>
                          <th>Aksi</th>
                          <th>Tanggal</th>
                          <th>Pelanggan</th>
                          <th>Alamat</th>
                          <th>Subtotal</th>
                          <th>Qty</th>
                          <th>Total</th>
                          <th>Bank Tujuan</th>
                          <th>Status</th>
                          <th>Dibuat pada</th>
                          
                        </tr>
                        <?php $index=(($data->currentPage()-1)*$data->perPage())+1;?>
                        @foreach($data as $d)
                            <tr>
                                <td style="width:50px">{{$index}}</td>
                                <td style="width:10%;">
                                    <a href="{{url('transaction/detail/'.$d->id)}}" class="btn btn-info"><i class="fa fa-file"></i> Detail</a>
                                </td>
                                <td>{{date('d F Y',strtotime($d->tanggal))}} {{date('H:i:s',strtotime($d->jam))}}</td>
                                <td>{{$d->pelanggan}}</td>
                                <td>{{$d->alamat}}</td>
                                <td align="right">{{number_format($d->subtotal)}}</td>
                                <td align="right">{{number_format($d->quantity)}}</td>
                                <td align="right"><b>{{number_format($d->total)}}</b></td>
                                <td>{{$d->bank}}</td>
                                <td>
                                  <?php
                                    $badge="info";
                                    $info = "Baru";
                                    if($d->status=="On Process"){
                                        $badge = "warning";
                                        $info = "Di proses";
                                    }else if($d->status=="Rejected"){
                                        $badge = "danger";
                                        $info="Ditolak";
                                    }else if($d->status=="Delivery"){
                                        $badge = "success";
                                        $info = "Pengiriman";
                                    }else if($d->status=="Cart"){
                                      $badge = "secondary";
                                      $info = "Keranjang";
                                    }else if($d->status=="Finish"){
                                      $badge = "warning";
                                      $info = "SELESAI";
                                    }
                                    
                                ?>
                                 <span class="badge badge-{{$badge}}"> {{$info}}</span></td>
                                <td>{{date('l, d F Y h:i:s a',strtotime($d->created_at))}}</td>
                            </tr>
                        <?php $index+=1;?>
                       @endforeach
                        
                      
                      </table>
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