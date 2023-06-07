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
            <?php
            $badge="info";
            if($transaction->status=="On Process")
                $badge = "warning";
            else if($transaction->status=="Rejected")
                $badge = "danger";
            else if($transaction->status=="Delivery")
                $badge = "success";
        ?>
            <div class="row">
                <div class="col-lg-12">
                    <x-alert></x-alert>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-{{$badge}}">
                        <div class="card-header"><h4>Data Transaksi</h4></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-md data-table">
                                  <tr>
                                    <th>Tanggal Transaksi</th><td>{{date('d, F Y h:i:s',strtotime($transaction->tanggal." ".$transaction->jam))}}</td></tr>
                                    <tr><th>Kode</th><td>{{$transaction->code}}</td>
                                  </tr>
                                  
                                  <tr>
                                    <th>Status</th><td >
                                      <?php
                                      $badge="info";
                                      $info = "Baru";
                                      if($transaction->status=="On Process"){
                                          $badge = "warning";
                                          $info = "Di proses";
                                      }else if($transaction->status=="Rejected"){
                                          $badge = "danger";
                                          $info="Ditolak";
                                      }else if($transaction->status=="Delivery"){
                                          $badge = "success";
                                          $info = "Pengiriman";
                                      }else if($transaction->status=="Cart"){
                                        $badge = "secondary";
                                        $info = "Keranjang";
                                      }else if($transaction->status=="Finish"){
                                        $badge = "warning";
                                        $info = "SELESAI";
                                      }
                                      
                                  ?>
                                   <span class="badge badge-{{$badge}}"> {{$info}}</span></td>
                                  </tr>
                                  <tr>
                                    <th>Alamat Pengiriman</th><td>{{$transaction->address}}</td>
                                  </tr>
                                  <tr>
                                    <th>Subtotal</th><td style="text-align: right">Rp.{{number_format($transaction->subtotal)}}</td></tr>
                                    <tr><th>Quantity</th><td style="text-align: right">{{number_format($transaction->quantity)}}</td>
                                  </tr>
                                  <tr>
                                    <th><h5>Total</h5></th><td style="text-align: right" colspan="3"><h5>Rp.{{number_format($transaction->total)}}</h5></td>
                                  </tr>
                                </table>
                              </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card  card-{{$badge}}">
                        <div class="card-header"><h4>Data Pelanggan</h4></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-md data-table">
                                    <tr>
                                        <td colspan="4" style="text-align: center">
                                            @if($customer->profile_picture!="")
                                            <img width="18%" src="{{asset('profile_picture/'.$customer->profile_picture)}}"/>
                                          @else
                                            <img width="18%" src="{{asset('profile_picture/no_avatar.png')}}"/>
                                          @endif
                                        </td>
                                    </tr>
                                  <tr>
                                    <th>Nama</th><td>{{$customer->name}}</td>
                                    <th>Email</th><td>{{$customer->email}}</td>
                                  </tr>
                                  <tr>
                                    <th>Jenis Kelamin</th><td>{{$customer->gender=="Male"?"Laki-Laki":"Perempuan"}}</td>
                                    <th>Tanggal Lahir</th><td>{{date('d, F Y',strtotime($customer->phone_no))}}</td>
                                  </tr>
                                  <tr>
                                    <th><b>No. Telp</b></th><td colspan="3"><h5>{{$customer->phone_no}}</h5></td>
                                  </tr>
                                  <tr>
                                    <th>Status</th><td colspan="3">{{$customer->status}}</td>
                                  </tr>
                                  
                                </table>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-{{$badge}}">
                        <div class="card-header"><h4>Data Bukti Transfer</h4></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-md data-table">
                                    <tr>
                                        <td colspan="4" style="text-align: center">
                                            @if($transaction->transfer_prove!="")
                                            <img width="45%" src="{{asset('transaksi/'.$transaction->transfer_prove)}}"/>
                                          @else
                                            <img width="45%" src="{{asset('profile_picture/no_avatar.png')}}"/>
                                          @endif
                                        </td>
                                    </tr>
                                  <tr>
                                    <th>Bank</th><td>{{$transaction->bank??'Belum Ada'}}</td>
                                    <th>Nomor Rekening</th><td>{{$transaction->nomor_rekening??'Belum Ada'}}</td>
                                  </tr>
                                  <tr><th>Pada</th><td colspan="3">{{date('d F Y H:i:s a',strtotime($transaction->updated_at))}}</td></tr>
                                  
                                </table>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-12 col-lg-12">
                    <div class="card card-{{$badge}}">
                      <div class="card-header">
                      {{-- <a href="{{url('/transaksi/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>&nbsp; --}}
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
                          
                        <div class="table-responsive">
                          <table class="table table-bordered table-striped table-md data-table">
                            <tr>
                              <th>#</th>
                              <th>Produk</th>
                              <th>Variant</th>
                             <th>Subtotal</th>
                              <th>Qty</th>
                              <th>Total</th>
                              <th>Dibuat pada</th>
                              
                            </tr>
                            <?php $index=1;?>
                            @foreach($detailTransaksi as $d)
                                <tr>
                                    <td style="width:50px">{{$index}}</td>
                                    <td>{{$d->productId}}:{{$d->productName}}</td>
                                    <td>{{$d->variantId}}:{{$d->variantName}}</td>
                                    <td align="right">{{number_format($d->subtotal)}}</td>
                                    <td align="right">{{number_format($d->quantity)}}</td>
                                    <td align="right"><b>{{number_format($d->total)}}</b></td>
                                    <td>{{date('l, d F Y h:i:s a',strtotime($d->created_at))}}</td>
                                </tr>
                            <?php $index+=1;?>
                           @endforeach
                            
                          
                          </table>
                        </div>
                      </div>
                      <div class="card-footer text-right">
                        <nav class="d-inline-block">
                           
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
              @if($transaction->status!="New" && $transaction->status!="Finish" && $transaction->status!="Cart")
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card card-{{$badge}}">
                    <div class="card-header"><h4>Ubah Status</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tr>
                                    @if($transaction->status=="On Process")
                                    <td>
                                    <form method="POST" action="{{url('transaction/update-status')}}">
                                        @csrf
                                        <input type="hidden" value="{{$transaction->id}}" name="id"/>
                                        <input type="hidden" value="Rejected" name="status"/>
                                        <button type="submit" class="btn btn-danger" style="width:100% !important">Tolak Transaksi</button>
                                    </form>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{url('transaction/update-status')}}">
                                            @csrf
                                            <input type="hidden" value="{{$transaction->id}}" name="id"/>
                                            <input type="hidden" value="Delivery" name="status"/>
                                            <button type="submit" class="btn btn-success" style="width:100% !important">Proses Ke Pengiriman</button>
                                        </form>
                                        </td>
                                    @else
                                    <td>
                                        <form method="POST" action="{{url('transaction/update-status')}}">
                                            @csrf
                                            <input type="hidden" value="{{$transaction->id}}" name="id"/>
                                            <input type="hidden" value="On Process" name="status"/>
                                            <button type="submit" class="btn btn-warning" style="width:100% !important">Kembalikan ke Di proses</button>
                                        </form>
                                        </td>
                                    @endif
                                    
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
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