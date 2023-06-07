<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Gallery;
use App\Models\Product;
use Validator;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {   
        $product = Product::where('id',$id)->first();
        $pageName = "Form Gallery Produk";
        return view('pages.gallery.create',compact('product','pageName'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'file'=>'required|mimes:jpg,png,jpeg,webpp|max:2048',
            'name'=>'required',
            'productId'=>'required'
        ]);
        if(!$validate->fails()){
            if($file = $request->file('file')){
                $destination = 'gallery/'.$request->productId.'/';
                $gambar = date('YmdHis').".".$file->getClientOriginalExtension();
                $file->move($destination,$gambar);
                $data = Gallery::create([
                    'name'=>$request->name,
                    'productId'=>$request->productId,
                    'link'=>$gambar,
                    'created_by'=>'System'
                ]);
                if($data){
                    Alert::toast("Gambar berhasil di tambahkan","success");
                    return redirect('product/detail/'.$request->productId)->with('success','Gambar berhasil di tambahkan');
                }else{
                    unlink($destination."/".$gambar);
                    Alert::error('Gagal','Gambar Gagal di tambahkan');
                    return redirect('product/detail/'.$request->productId)->with('error','Gambar gagal di tambahkan!');
                }
            }else{
                Alert::warning('Gagal','Gambar Gagal di upload!');
                return redirect('product/detail/'.$request->productId)->with('error','Gambar gagal di upload!');
            }
        }else{
            Alert::error('Gagal','Tidak ada data gambar!');
            return redirect('product/detail/'.$request->productId)->with('error','Gambar tidak ada data');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Gallery::where('id',$id)->first();
        unlink('gallery/'.$data->productId.'/'.$data->link);
        $data = Gallery::where('id',$id)->forceDelete();
        if($data){
            return response()->json(['status'=>'success'],200);
        }
        return response()->json(['status'=>'failed'],502);
    }
}
