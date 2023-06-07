@extends('shop.partial.layouts')
@section('content')
    <!-- Header End -->
  
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="#"><i class="fa fa-home"></i> Home</a>
                        <a href="{{url('shop/profile')}}"><i class="fa fa-home"></i> Profil</a>
                        <span>Alamat</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Form Section Begin -->

    <!-- Register Section Begin -->
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                
                <div class="col-lg-12">
                    <h4>Daftar Alamat Pengguna</h4>
                    <hr>
                    <a href="{{url('shop/user/address/add')}}" class="site-btn">Tambah Alamat</a>
                    <hr>
                    @if(count($address)>0)
                    <div class="cart-table">
                        <table>
                            <tr>
                                <th>No.</th>
                                <th>Alamat</th>
                                <th>Desa / Daerah</th>
                                <th>Biaya Pengiriman</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <?php $no=0;?>
                            @foreach($address as $a)
                                <tr>
                                    <td>{{$no+=1}}</td>
                                    <td>{{$a->address}}</td>
                                    <td><p aling="justify">{{$a->desa}}</p></td><td><b>(Rp. {{number_format($a->harga)}})</b></td>
                                    <td>{{$a->default=='True'?'Default':'Cadangan'}}</td>
                                    <td> <form method="post" action="{{url('shop/user/address/destroy',$a->id)}}">
                                        <a href='{{url("/shop/user/address/edit/".$a->id)}}' class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    
                                        @csrf
                                        @method('delete')

                                        <button type="submit" class="btn btn-danger show_confirm" data="{{$a->alamat}}"><i class="fa fa-trash"></i></button>
                                    </form></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    @else
                    <h6>Belum ada Alamat</h6>
                    <hr>
                    <a href="{{url('shop/user/address/add')}}" class="site-btn">Tambah Alamat</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Register Form Section End -->

    
    <!-- Partner Logo Section End -->
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