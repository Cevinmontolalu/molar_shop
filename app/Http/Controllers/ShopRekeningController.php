<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopRekening;
use Validator;
use RealRashid\SweetAlert\Facades\Alert;
class ShopRekeningController extends Controller
{
    public function index(){
        $pageName = "Rekening Toko";
        $data = ShopRekening::paginate(15);
        return view('pages.shop_rekening.index',compact('pageName','data'));
    }
    public function create(){
        $pageName = "Form Rekening Toko";
        return view('pages.shop_rekening.create',compact('pageName'));
    }
    public function store(Request $req){
        $validate = Validator::make($req->all(),[
            'name'=>'required',
            'nomor_rekening'=>'required',
            'status'=>'required'
        ]);
        if(!$validate->fails()){
            $data = ShopRekening::create($req->all());
            if($data){
                Alert::toast('Data Rekening Berhasil di tambahkan','success');
                return redirect('shop_rekening')->with('success','Data Rekening berhasil di tambahkan!');
            }else{
                Alert::warning("Gagal","gagal menambahkan rekening toko!");
                return back()->withInput()->with('error','gagal menambahkan rekening toko');
            }
        }else{
            Alert::warning("Gagal","Data belum lengkap!");
            return back()->withInput()->with('error','Data belum lengkap '.$validate->errors());
        }
    }
    public function edit($id){
        $data = ShopRekening::where('id',$id)->first();
        $pageName = "Ubah Rekening Tokon";
        return view('pages.shop_rekening.edit',compact('data','pageName'));
    }
    public function update(Request $req){
        $validate = Validator::make($req->all(),[
            'name'=>'required',
            'nomor_rekening'=>'required',
            'status'=>'required'
        ]);
        if(!$validate->fails()){
            $data = ShopRekening::where('id',$req->id)->update(
                ['name'=>$req->name,'nomor_rekening'=>$req->nomor_rekening,'status'=>$req->status]
            );
            if($data){
                Alert::toast('Data Rekening Berhasil di ubahkan','success');
                return redirect('shop_rekening')->with('success','Data Rekening berhasil di ubahkan!');
            }else{
                Alert::warning("Gagal","gagal ubahkan rekening toko!");
                return back()->withInput()->with('error','gagal ubahkan rekening toko');
            }
        }else{
            Alert::warning("Gagal","Data belum lengkap!");
            return back()->withInput()->with('error','Data belum lengkap '.$validate->errors());
        }
    }
    public function destroy($id){
        $data = ShopRekening::where('id',$id)->delete();
        if($data){
            Alert::toast('Data rekening berhasil di hapus!','success');
            return redirect('shop_rekening')->with('success','Data rekening berhasil di hapus!');
        }else{
            Alert::warning("Gagal","Data rekening gagal di hapus!");
            return redirect('shop_rekening')->with('error','Data rekening gagal di hapus!');
        }
    }
}
