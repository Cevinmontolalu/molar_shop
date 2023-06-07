@extends('layouts.layout')
@section('content')
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{$pageName}} Table</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{url('/dashboard')}}">Dashboard</a></div>
            </div>
          </div>

          <div class="section-body">
            <!-- <h2 class="section-title">Table</h2>
            <p class="section-lead">Example of some Bootstrap table components.</p> -->

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                      <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                      </div>
                      <div class="card-wrap">
                        <div class="card-header">
                          <h4>Total Dalam Proses</h4>
                        </div>
                        <div class="card-body">
                          {{number_format($onProcess)}}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                      <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                      </div>
                      <div class="card-wrap">
                        <div class="card-header">
                          <h4>Total Ditolak</h4>
                        </div>
                        <div class="card-body">
                            {{number_format($rejected)}}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                      <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                      </div>
                      <div class="card-wrap">
                        <div class="card-header">
                          <h4>Total Finish</h4>
                        </div>
                        <div class="card-body">
                          {{number_format($finish)}}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                      <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                      </div>
                      <div class="card-wrap">
                        <div class="card-header">
                          <h4>Pelanggan Baru</h4>
                        </div>
                        <div class="card-body">
                          {{number_format($newCustomers)}}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                  {{-- <a href="{{url('/transaksi/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>&nbsp; --}}
                    <h4>Data Transaksi Baru</h4>
                    
                    </div>
                  <div class="card-body">
                     
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped table-md data-table">
                        <tr>
                          <th>#</th>
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
                        <?php $index=(($transaction->currentPage()-1)*$transaction->perPage())+1;?>
                        @foreach($transaction as $d)
                            <tr>
                                <td style="width:50px">{{$index}}</td>
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
                                    if($d->status=="On Process")
                                        $badge = "warning";
                                    else if($d->status=="Rejected")
                                        $badge = "danger";
                                    else if($d->status=="Delivery")
                                        $badge = "success";
                                    
                                ?>
                                 <span class="badge badge-{{$badge}}"> {{$d->status}}</span></td>
                                <td>{{date('l, d F Y h:i:s a',strtotime($d->created_at))}}</td>
                            </tr>
                        <?php $index+=1;?>
                       @endforeach
                        
                      
                      </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <nav class="d-inline-block">
                        {{$transaction->links()}}
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