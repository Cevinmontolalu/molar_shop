<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\VariantProduct;
use App\Models\ReviewProduct;
use App\Models\Customer;
use App\Models\Gallery;
use App\Models\ShopProfile;
use App\Models\CustomerAddress;
use App\Models\DetailTransaction;
use App\Models\Transaction;
use App\Models\ShopRekening;
use App\Models\BiayaPengiriman;
use Session;
use Validator;
use Alert;
use Auth;
use File;
use Hash;

class ShopController extends Controller
{
    public function pageRequirement(){
        $kategori = Category::get();
        // $user = Auth():
        // $cart = Transaction::where()
    }
    public function productIndex(){
        $product = Product::leftJoin('category','category.id','product.categoryId')
                            ->leftJoin('sub_category','sub_category.id','product.subCategoryId')
                            ->whereRaw('(SELECT count(id) FROM variant WHERE productId=product.id)>0')
                            ->select('product.*','category.name as kategori','sub_category.name as subKategori')
                            ->paginate(10);
        // $kategori = Category::get();
        foreach($product as $p){
            $p['galleries'] = Gallery::where('productId',$p->id)->get();
            $p['variants'] = VariantProduct::where("productId",$p->id)->get();
        }
        // dd($product);
        return view('shop.produk.index',compact('product'));
    }
    public function searchProduct(Request $req){
        $product = Product::leftJoin('category','category.id','product.categoryId')
                            ->leftJoin('sub_category','sub_category.id','product.subCategoryId')
                            ->whereRaw('(SELECT count(id) FROM variant WHERE productId=product.id)>0')
                            ->select('product.*','category.name as kategori','sub_category.name as subKategori')
                            ->where('product.name','LIKE','%'.$req->key.'%')
                            ->paginate(10);
        // $kategori = Category::get();
        foreach($product as $p){
            $p['galleries'] = Gallery::where('productId',$p->id)->get();
            $p['variants'] = VariantProduct::where("productId",$p->id)->get();
        }
        // dd($product);
        return view('shop.produk.index',compact('product'));
    }
    public function productPerKategori($category){
        $product = Product::leftJoin('category','category.id','product.categoryId')
                            ->leftJoin('sub_category','sub_category.id','product.subCategoryId')
                            ->select('product.*','category.name as kategori','sub_category.name as subKategori')
                            ->where('product.categoryId',$category)
                            ->whereRaw('(SELECT count(id) FROM variant WHERE productId=product.id)>0')
                            ->paginate(10);
        // $kategori = Category::get();
        $subKategori = SubCategory::where('categoryId',$category)->get();
        foreach($product as $p){
            $p['galleries'] = Gallery::where('productId',$p->id)->get();
            $p['variants'] = VariantProduct::where("productId",$p->id)->get();
        }
        // dd($product);
        return view('shop.produk.index',compact('product','category','subKategori'));
    }
    public function productPerSubKategori($category,$subCategory){
        $product = Product::leftJoin('category','category.id','product.categoryId')
                            ->leftJoin('sub_category','sub_category.id','product.subCategoryId')
                            ->select('product.*','category.name as kategori','sub_category.name as subKategori')
                            ->where('product.subCategoryId',$subCategory)
                            ->whereRaw('(SELECT count(id) FROM variant WHERE productId=product.id)>0')
                            ->paginate(10);
        // $kategori = Category::get();
        $subKategori = SubCategory::where('categoryId',$category)->get();
        foreach($product as $p){
            $p['galleries'] = Gallery::where('productId',$p->id)->get();
            $p['variants'] = VariantProduct::where("productId",$p->id)->get();
        }
        // dd($product);
        return view('shop.produk.index',compact('product','subKategori','category','subCategory'));
    }
    public function productDetail($id){
        $product = Product::leftJoin('category','category.id','product.categoryId')
                            ->leftJoin('sub_category','sub_category.id','product.subCategoryId')
                            ->select('product.*','category.name as kategori','sub_category.name as subKategori')
                            ->where('product.id',$id)->first();
        //  dd($id);
        $variant = VariantProduct::where('productId',$id)->get();
        // $kategori = Category::get();
        $related_product = Product::leftJoin('category','category.id','product.categoryId')
                                ->leftJoin('sub_category','sub_category.id','product.subCategoryId')
                                ->select('product.*','category.name as kategori','sub_category.name as subKategori')
                                ->whereRaw('(SELECT count(id) FROM variant WHERE productId=product.id)>0')
                                ->where('category.id',$product->categoryId)
                                ->inRandomOrder()
                                ->take(5)->skip(0)
                                ->get();
        foreach($related_product as $p){
            $p['galleries'] = Gallery::where('productId',$p->id)->get();
            $p['variants'] = VariantProduct::where("productId",$p->id)->get();
        }
        $subKategori = SubCategory::where('categoryId',$product->categoryId)->get();
        $galleries = Gallery::where('productId',$id)->get();
        $review = ReviewProduct::where('productId',$id)->get();
        return view('shop.produk.detail',compact('product','variant','galleries','related_product','review','subKategori'));
    }

    public function login(){
        // $kategori = Category::get();
        return view('shop.login');//,compact('kategori'));
    }
    public function tryLogin(Request $req){
        $validate = Validator::make($req->all(),[
            'email'=>'required',
            'password'=>'required'
        ]);
        // dd($validate);
        if(!$validate->fails()){
            
            if(Auth::guard('customer')->attempt(['email'=>$req->email,'password'=>$req->password])){
               $user = Auth::guard('customer')->user();
               Alert::toast('login success','success');
               return redirect('/')->with('success',"Login berhasil!");
            }else{
                
                return redirect()->back()->with('error','Login Gagal, Mohon periksa kembali email dan kata sandi anda!');
            }
        }else{
            Alert::warning('Gagal','Login Gagal, Mohon periksa kembali email dan kata sandi Anda!');
            return redirect()->back()->with('error','Login Gagal, Mohon periksa kembali email dan kata sandi anda!');
        }
    }
    public function tryLogout(){
        Auth::guard('customer')->logout();
        Session::flush();
        return redirect('/');
    }

    public function register(){
        // $kategori = Category::get();
        return view('shop.register');//,compact('kategori'));
    }
    public function tryRegister(Request $req){
        $validate = Validator::make($req->all(),[
            'email'=>'required|unique:customer|email',
            'name'=>'required',
            'phone_no'=>'required',
            'password'=>'required|confirmed|min:8'
        ]);
        if(!$validate->fails()){
            $user = Customer::create([
                'email'=>$req->email,
                'name'=>$req->name,
                'phone_no'=>$req->phone_no,
                'password'=>Hash::make($req->password),
                'gender'=>'Belum diisi',
                'dob'=>date('Y-m-d',strtotime('now')),
                'status'=>'Active',
                'created_by'=>'Customer',
                'updated_by'=>'-'
            ]);
            if($user){
                Alert::toast('Pendaftaran Berhasil, Silahkan Login','success');
                return redirect('/shop/login')->with('success','Anda bisa login dengan menggunakan email dan kata sandi yang ada masukan saat pendaftaran');
            }else{
                Alert::warning('Gagal','Pendaftaran Gagal, Silahkan Coba lagi');
                return redirect('/shop/register')->with('error','Pendaftaran Gagal!');
            }
        }else{
            Alert::warning('Gagal','Pendaftaran Gagal, Silahkan Coba lagi');
            return redirect('/shop/register')->with('error','Pendaftaran Gagal! '.$validate->errors());
        }
    }
    public function profile(){
        $user = Auth::guard('customer')->user();
        // $kategori = Category::get();
        return view('shop.profile',compact('user'));
    }
    public function updateProfile(Request $req){
        $validate = Validator::make($req->all(),[
            'email'=>'required',
            'name'=>'required',
            'phone_no'=>'required',
            'id'=>'required'
        ]);
        if(!$validate->fails()){
            $user = Customer::where('id',$req->id)->update([
                'name'=>$req->name,
                'phone_no'=>$req->phone_no,
                'gender'=>isset($req->gender)?$req->gender:'Belum diisi',
                'dob'=>isset($req->dob)?date('Y-m-d',strtotime($req->dob)):date('Y-m-d'),
                'updated_by'=>$req->email
            ]);
            if($user){
                Alert::toast('Update Profile Sukses','success');
                return redirect('/shop/profile')->with('success','Update profile sukses');
            }else{
                Alert::warning('Gagal','Update profil gagal');
                return redirect('/shop/profile')->with('error','update profile gagal');
            }
        }else{
            Alert::warning('Gagal','Data Tidak lengkap');
            return redirect('/shop/profile')->with('error','Date tidak lengkap : '.$validate->errors());
        }
    }
    public function updatePassword(Request $req){
        $validate = Validator::make($req->all(),[
            'oldpwd'=>'required',
            'id'=>'required',
            'password'=>'required|confirmed|min:8'
        ]);
        if(!$validate->fails()){
            $user = Customer::where('id',$req->id)->first();
            if($user && Hash::check($req->oldpwd,$user->password)){
                $user->password = Hash::make($req->newpwd);
                $user->save();
                Alert::toast('Update Kata Sandi Sukses','success');
                return redirect('/shop/profile')->with('success','Update Kata sandi berhasil!');
            }else{
                Alert::warning('Gagal',"Kata Sandi Lama Salah!, Silahkan periksa kembali!");
                return redirect('/shop/profile')->with('error','Kata sandi lama salah!');
            }
        }else{
            Alert::warning('Gagal','Data tidak lengkap');
            return redirect('/shop/profile')->with('error','Data Tidak lengkap '.$validate->errors());
        }
    }
    public function updateFoto(Request $req){
        $validate = Validator::make($req->all(),[
            'foto'=>'required|mimes:jpg,png,jpeg,webpp|max:2048'
        ]);
        if(!$validate->fails()){
            if($file = $req->file('foto')){
                $user = Customer::where('id',$req->id)->first();
                $lastPhoto = $user->profile_picture;
                $destination = 'profile_picture';
                $profilePicture = date('YmdHis').".".$file->getClientOriginalExtension();
                $file->move($destination,$profilePicture);
                $data = Customer::where('id',$req->id)->update([
                    'profile_picture'=>$profilePicture
                ]);
                if($data){
                    File::delete('profile_picture/'.$lastPhoto);
                    Alert::toast("Foto Profile berhasil di ubah","success");
                    return redirect('shop/profile')->with('success','Foto Profil berhasil di ubah');
                }else{
                    unlink($destination."/".$profilePicture);
                    Alert::error('Gagal','Foto Profile Gagal di ubah');
                    return redirect('shop/profile')->with('error','Foto profile gagal di ubah!');
                }
            }else{
                Alert::warning('Gagal','Foto Gagal di upload!');
                return redirect('shop/profile')->with('error','Foto profile gagal di upload!');
            }
        }else{
            Alert::error('Gagal','Tidak ada data gambar!');
            return redirect('shop/profile')->with('error','Foto profil tidak ada data');
        }
    }

    public function userAddress(){
        $user = Auth::guard('customer')->user();
        $address = CustomerAddress::leftJoin('biaya_pengiriman','biaya_pengiriman.id','customer_address.bpId')
                        ->select('customer_address.*','biaya_pengiriman.nama as desa','biaya_pengiriman.deskripsi as deskripsi_desa','biaya_pengiriman.harga as harga')
                        ->where('customerId',$user->id)->get();
        // $kategori = Category::get();
        return view('shop.address.index',compact('address'));
    }
    public function userFormAddress(){
        // $kategori = Category::get();
        $biaya = BiayaPengiriman::get();
        return view('shop.address.create',compact('biaya'));//,compact('kategori'));
    }
    public function userStoreAddress(Request $req){
        $validate = Validator::make($req->all(),[
            'alamat'=>'required',
            'default'=>'required',
            'bpId'=>'required'
        ]);
        if(!$validate->fails()){
            $user = Auth::guard('customer')->user();
            if($req->default=='True'){
                $this->resetDefaultAddress($user->id);
            }
            $data = CustomerAddress::create([
                'customerId'=>$user->id,
                'address'=>$req->alamat,
                'bpId'=>$req->bpId,
                'default'=>$req->default,
                'created_by'=>$user->name,
                'updated_by'=>$user->name
            ]);
            if($data){
                Alert::toast('Tambah Alamat Berhasil','success');
                return redirect('/shop/user/address')->with('success','Tambah alamat berhasil');
            }else{
                Alert::warning('Gagal','Tambah Alamat Gagal!');
                return back()->withInput()->with('error','Tambah alamat gagal');
            }
        }else{
            Alert::warning('Gagal','Tambah Alamat Gagal!');
            return back()->withInput()->with('error','Tambah Alamat gagal! '.$validate->errors());
        }
    }
    public function resetDefaultAddress($userId){
        $address = CustomerAddress::where('customerId',$userId)->update(['default'=>'False']);
        if($address){
            return true;
        }
        return false;
    }
    public function userEditAddress($id){
        // $kategori = Category::get();
        $address = CustomerAddress::leftJoin('biaya_pengiriman','biaya_pengiriman.id','customer_address.bpId')
                        ->select('customer_address.*','biaya_pengiriman.nama as desa')
                        ->where('customer_address.id',$id)->first();
        $biaya = BiayaPengiriman::get();
        return view('shop.address.edit',compact('address','biaya'));
    }
    public function userUpdateAddress(Request $req,$id){
        $validate = Validator::make($req->all(),[
            'alamat'=>'required',
            'default'=>'required',
            'bpId'=>'required'
        ]);
        if(!$validate->fails()){
            $user = Auth::guard('customer')->user();
            if($req->default=='True'){
                $this->resetDefaultAddress($user->id);
            }
            $data = CustomerAddress::where('id',$id)->update([
                'customerId'=>$user->id,
                'address'=>$req->alamat,
                'bpId'=>$req->bpId,
                'default'=>$req->default,
                'updated_by'=>$user->name
            ]);
            if($data){
                Alert::toast('Ubah Alamat Berhasil','success');
                return redirect('/shop/user/address')->with('success','Ubah alamat berhasil');
            }else{
                Alert::warning('Gagal','Ubah Alamat Gagal!');
                return back()->withInput()->with('error','Ubah alamat gagal');
            }
        }else{
            Alert::warning('Gagal','Ubah Alamat Gagal!');
            return back()->withInput()->with('error','Ubah Alamat gagal! '.$validate->errors());
        }
    }
    public function userDestroyAddress($id){
        $data = CustomerAddress::where('id',$id)->delete();
        if($data){
            Alert::toast('Data berhasil di hapus','success');
            return redirect('/shop/user/address')->with('success','data berhasil di hapus!');
        }else{
            Alert::warning('Gagal','Data gagal dihapus');
            return redirect('/shop/user/address')->with('error','data gagal di hapus');
        }
    }

    public function createNewCart(){
        $user = Auth::guard('customer')->user();
        $cart = Transaction::where('customerId',$user->id)->where('status','Cart')->get();
        if(count($cart)==0){
            $cart = Transaction::create([
                'tanggal'=>date('Y-m-d'),
                'jam'=>date('h:i:s'),
                'code'=>date('Ymdhis')."-cart",
                'customerId'=>$user->id,
                'addressId'=>0,
                'subtotal'=>0,
                'quantity'=>0,
                'diskon'=>0,
                'total'=>0,
                'status'=>'Cart',
                'transfer_prove'=>'',
                'created_by'=>$user->name,
                'updated_by'=>$user->name
            ]);
            if($cart){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
    public function addToCart(Request $req){
        $check = $this->createNewCart();
        // dd($req);
        $user = Auth::guard('customer')->user();
        if($check){
            $product = Product::where('id',$req->productId)->first();
            $variant = VariantProduct::where('id',$req->variantId)->first();
            $cart = Transaction::where('customerId',$user->id)->first();
            // dd($cart);
            $sukses = false;
            $checkItem = DetailTransaction::where('transactionId',$cart->id)->where('productId',$product->id)->where('variantId',$variant->id)->first();
            if($checkItem){
                $checkItem->quantity+=$req->quantity;
                $checkItem->subtotal = $checkItem->quantity * $checkItem->price;
                $checkItem->total = $checkItem->quantity * $checkItem->price;
                $checkItem->updated_by = $user->name;
                $checkItem->save();
                $sukses = true;
            }else{
                $item = DetailTransaction::create([
                    'transactionId'=>$cart->id,
                    'productId'=>$product->id,
                    'variantId'=>$variant->id,
                    'price'=>$variant->price,
                    'quantity'=>1,
                    'subtotal'=>$variant->price * $req->quantity,
                    'total'=>$variant->price * $req->quantity,
                    'diskon'=>0,
                    'productName'=>$product->name,
                    'variantName'=>$variant->name,
                    'created_by'=>$user->name,
                    'updated_by'=>'-'
                ]);
                if($item){
                    $sukses = true;
                }
            }

            $detailCart = DetailTransaction::where('transactionId',$cart->id)->get();
            $totalQty = 0;
            $subTotal = 0;
            $total=0;
            $diskon = 0;
            foreach($detailCart as $dc){
               $totalQty += $dc->quantity;
               $subTotal += $dc->subtotal;
               $total += $dc->total;
               $diskon += $dc->diskon;
            }
            $cart->total=$total;
            $cart->subtotal =$subTotal;
            $cart->quantity = $totalQty;
            $cart->save();
            if($sukses){
                Alert::toast('Berhasil ditambahkan di keranjang!',"success");
                return redirect($req->link)->with('success','Berhasil di tambahkan di keranjang!');
            }else{
                Alert::toast('Gagal ditambahkan di keranjang!','error');
                return redirect($req->link)->with('error','Gagal ditambahkan di keranjang!');
            }

        }else{
            Alert::warning('Gagal','Gagal Menambahkan Keranjang!');
            return redirect($req->link)->with('error','Gagal menambahkan keranjang');
        }
    }
    public function updateCartProperty($id){
        $cart = Transaction::where('id',$id)->first();
        $detail = DetailTransaction::where('transactionId',$id)->get();
        $cart->quantity = 0;
        $cart->subtotal = 0;
        $cart->total = 0;
        $cart->diskon = 0;
        foreach($detail as $d){
            $cart->quantity +=$d->quantity;
            $cart->subtotal += $d->quantity * $d->price;
            $cart->total += $d->quantity * $d->price;
            $cart->diskon += $d->diskon;
        }
        $cart->save();
    }
    public function reduceItemCart($id,$qty){
        $detail = DetailTransaction::where('id',$id)->first();
        $tmp = $detail->quantity;
        $tmp = $tmp-$qty;
        if($tmp<=0){
            DetailTransaction::where('id',$id)->delete();
            $this->updateCartProperty($detail->transactionId);
            Alert::toast($detail->productName.' Berhasil di hapus dari keranjang!','success');
            return back()->with('success',$detail->productName.' Berhasil di hapus dari keranjang!');
        }else{
            $detail->quantity -= $qty;
            $detail->subtotal = $detail->price * $detail->quantity;
            $detail->total = $detail->price * $detail->quantity;
            $detail->save();
            $this->updateCartProperty($detail->transactionId);
            Alert::toast($detail->productName.' Berhasil di kurangkan!','success');
            return back()->with('success',$detail->productName.' Berhasil di kurangkan!');
        }
    }

    public function viewShoppingCart(){
        $user = Auth::guard('customer')->user();
        $address = CustomerAddress::where('customerId',$user->id)->get();
        return view('shop.cart',compact('address'));
       
    }
    public function checkout(Request $req){
        $user = Auth::guard('customer')->user();
        $cart = Transaction::where('customerId',$user->id)->where('status','Cart')->first();
        $detailCart = DetailTransaction::where("transactionId",$cart->id)->get();
        $biayaPengiriman = BiayaPengiriman::leftJoin('customer_address','customer_address.bpId','biaya_pengiriman.id')
                                    ->select("biaya_pengiriman.*")
                                    ->where('customer_address.id',$req->address)->first();
        $total = $cart->total;
        if($biayaPengiriman){
            $total = $cart->total + $biayaPengiriman->harga;
        }
        $newTransaction = Transaction::create([
            'tanggal'=>date('Y-m-d'),
                'jam'=>date('h:i:s'),
                'code'=>date('Ymdhis'),
                'customerId'=>$user->id,
                'addressId'=>$req->address,
                'subtotal'=>$cart->subtotal,
                'quantity'=>$cart->quantity,
                'diskon'=>$cart->diskon,
                'total'=>$total,
                'status'=>'New',
                'transfer_prove'=>'',
                'created_by'=>$user->name,
                'updated_by'=>$user->name]);
        if($newTransaction){
            foreach($detailCart as $dc){
                $dTest = DetailTransaction::create([
                    'transactionId'=>$newTransaction->id,
                    'productId'=>$dc->productId,
                    'variantId'=>$dc->variantId,
                    'price'=>$dc->price,
                    'quantity'=>$dc->quantity,
                    'subtotal'=>$dc->subtotal,
                    'total'=>$dc->total,
                    'diskon'=>0,
                    'productName'=>$dc->productName,
                    'variantName'=>$dc->variantName,
                    'created_by'=>$user->name,
                    'updated_by'=>'-'
                ]);
                if($dTest){
                    $cart->quantity -=$dc->quantity;
                    $cart->total -= $dc->total;
                    $cart->subtotal -=$dc->subtotal;
                    DetailTransaction::where('id',$dc->id)->delete();
                    $cart->save();
                }
            }
            Alert::toast('Transaksi Berhasil di buat!','success');
            return redirect('shop/transaction/detail/'.$newTransaction->id);
        }else{
            Alert::warning('Gagal',"Gagal Membuat Transaksi, Silahkan coba lagi!");
            return back()->with('error','Gagal membuat transaksi');
        }
    }
    public function transactionDetail($id){
        $transaction = Transaction::where('id',$id)->first();
        $detailTransaction = DetailTransaction::leftJoin('gallery','gallery.productId','detail_transaction.productId')
                            ->select('detail_transaction.*','gallery.link as photo')
                            ->groupBy('detail_transaction.id')
                            ->where('transactionId',$transaction->id)->get();
        $address = CustomerAddress::leftJoin('biaya_pengiriman','biaya_pengiriman.id','customer_address.bpId')
                        ->select('customer_address.*','biaya_pengiriman.nama as desa','biaya_pengiriman.harga as harga','biaya_pengiriman.deskripsi as deskripsi_desa')
                        ->where('customer_address.id',$transaction->addressId)->first();
        $shopRekening = ShopRekening::where('status','Aktif')->get();
        return view('shop.transaction.detail',compact('transaction','detailTransaction','address','shopRekening'));
    }
    public function transactionList(){
        $user = Auth::guard('customer')->user();
        $data = Transaction::leftJoin('customer_address','customer_address.id','transaction.addressId')
                    ->select("transaction.*","customer_address.address as Address")
                    ->where('transaction.customerId',$user->id)->where('status','!=','Cart')->orderBy('transaction.created_at','DESC')->paginate(10);
        return view('shop.transaction.index',compact('data'));
    }
    public function transactionUploadForm($id){
        $shopRekening = ShopRekening::where('status','Aktif')->get();
        $transaction = Transaction::where('id',$id)->first();
        return view('shop.transaction.upload_form',compact('shopRekening','transaction'));
    }
    public function transactionUpload(Request $req){
        $validate = Validator::make($req->all(),[
            'foto'=>'required|mimes:jpg,png,jpeg,webpp|max:2048',
            'transactionId'=>'required',
            'rekeningId'=>'required'
        ]);
        if(!$validate->fails()){
            if($file = $req->file('foto')){
                $destination = 'transaksi/';
                $gambar = date('YmdHis').".".$file->getClientOriginalExtension();
                $file->move($destination,$gambar);
                $data = Transaction::where('id',$req->transactionId)->update([
                    'transfer_prove'=>$gambar,
                    'status'=>'On Process',
                    'rekeningId'=>$req->rekeningId
                ]);
                if($data){
                    Alert::toast("Bukti Transfer berhasil di upload!","success");
                    return redirect('shop/transactions')->with('success','Bukti transfer berhasil di upload');
                }else{
                    unlink($destination."/".$gambar);
                    Alert::error('Gagal',"Bukti transfer gagal di upload silahkan coba lagi!");
                    return redirect()->back()->with('error','Bukti transfer gagal di upload')->withInput();
                }
            }else{
                Alert::warning("Gagal","Gagal Upload bukti transfer!");
                return redirect()->back()->with('error','Gagal upload bukti transfer');
            }
        }else{
            Alert::error('Gagal','Data tidak lengkap!');
            return redirect()->back()->with('error','Data tidak lengkap! '.$validate->errors())->withInput();
        }
    }
    public function finishTransaction(Request $req){
        $validate = Validator::make($req->all(),[
            'id'=>'required',
            'status'=>'required'
        ]);
        if(!$validate->fails()){
            $update = Transaction::where('id',$req->id)->update([
                'status'=>$req->status,
                'updated_by'=>Auth::user()->email
            ]);
            if($update){
                Alert::toast('Status Transaksi Berhasil di rubah ke '.$req->status,'success');
                return redirect('shop/transaction/detail/'.$req->id)->with('success','Status Transaksi Berhasil di rubah ke '.$req->status);
            }else{
                Alert::warning("Gagal","Status Transaksi Gagal di rubah ke ".$req->status);
                return back()->withInput()->with('error','Status Transaksi Gagal di rubah ke '.$req->status);
            }
        }else{
            Alert::warning('Gagal','Validasi Gagal');
            return back()->withInput()->with('error','data tidak lengkap '.$validate->errors());
        }
    }

    public function searchTransaction($key){
        $query = Transaction::query();
        $user = Auth::guard('customer')->user();
        $query->leftJoin('customer_address','customer_address.id','transaction.addressId')
                    ->select("transaction.*","customer_address.address as Address")
                    ->where('transaction.customerId',$user->id)->where('status','!=','Cart')->orderBy('transaction.created_at','DESC');
        $query->where('code',$key)->orderBy('created_at','DESC');
        $data = $query->paginate(10);
        return view('shop.transaction.index',compact('data'));
    }
}
