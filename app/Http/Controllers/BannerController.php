<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Validator;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Banner::paginate(10);
        $pageName = "Banner Toko";
        return view('pages.banner.index',compact('data','pageName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageName = "Banner Toko";
        return view('pages.banner.create',compact('pageName'));
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
            'title'=>'required',
            'description'=>'required'
        ]);
        if(!$validate->fails()){
            if($file = $request->file('file')){
                $destination = 'banner/';
                $gambar = date('YmdHis').".".$file->getClientOriginalExtension();
                $file->move($destination,$gambar);
                $data = Banner::create([
                    'title'=>$request->title,
                    'description'=>$request->description,
                    'image'=>$gambar,
                    'link'=>$request->link,
                    'created_by'=>'System'
                ]);
                if($data){
                    Alert::toast("Banner berhasil di tambahkan","success");
                    return redirect('banners')->with('success','Banner berhasil di tambahkan');
                }else{
                    unlink($destination."/".$gambar);
                    Alert::error('Gagal','Banner Gagal di tambahkan');
                    return redirect()->back()->with('error','Banner gagal di tambahkan!')->withInput();
                }
            }else{
                Alert::warning('Gagal','Banner Gagal di upload!');
                return redirect()->back()->with('error','Gambar gagal di upload!')->withInput();
            }
        }else{
            Alert::error('Gagal','Tidak ada data gambar!');
            return redirect()->back()->with('error','Gambar tidak ada data')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageName = "Ubah Banner";
        $data = Banner::where('id',$id)->first();
        return view('pages.banner.edit',compact('pageName','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),[
            "title"=>"required",
            "description"=>"required",
            "link"=>"required"
        ]);
        if(!$validate->fails()){
            $data = Banner::where('id',$id)->update([
                'title'=>$request->title,
                'description'=>$request->description,
                'link'=>$request->link,
                'updated_by'=>Auth::user()->name
            ]);
            if($data){
                Alert::toast("Banner berhasil di ubahkan","success");
                return redirect('banners')->with('success','Banner berhasil di ubahkan');
            }else{
                unlink($destination."/".$gambar);
                Alert::error('Gagal','Banner Gagal di ubahkan');
                return redirect()->back()->with('error','Banner gagal di ubahkan!')->withInput();
            }
        }else{
            Alert::error('Gagal','Tidak ada data gambar!');
            return redirect()->back()->with('error','Gambar tidak ada data')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        unlink('banner/'.$banner->image);
        $data = Banner::where('id',$banner->id)->delete();
        if($data){
            Alert::toast('Data successfully removed!','success');
            return redirect('banners')->with('success','Data successfully removed!');
        }else{
            Alert::warning('Failed','Data failed to be removed!');
            return redirect('banners')->with('error','Data failed to be removed!');
        }
    }

    public function updateGambar(Request $req){
        $validate = Validator::make($req->all(),[
            'file'=>'required|mimes:jpg,png,jpeg,webpp|max:2048',
            'id'=>'required'
        ]);
        if(!$validate->fails()){
            if($file = $req->file('file')){
                $last = Banner::where('id',$req->id)->first();
                $destination = 'banner/';
                $gambar = date('YmdHis').".".$file->getClientOriginalExtension();
                $file->move($destination,$gambar);
                $data = Banner::where('id',$req->id)->update([
                    'image'=>$gambar,
                    'updated_by'=>Auth::user()->name
                ]);
                if($data){
                    Alert::toast("Banner berhasil di ubahkan","success");
                    return redirect('banner/edit/'.$req->id)->with('success','Banner berhasil di ubahkan');
                }else{
                    unlink($destination."/".$gambar);
                    Alert::error('Gagal','Banner Gagal di ubahkan');
                    return redirect()->back()->with('error','Banner gagal di ubahkan!')->withInput();
                }
            }else{
                Alert::warning('Gagal','Banner Gagal di upload!');
                return redirect()->back()->with('error','Gambar gagal di upload!')->withInput();
            }
        }else{
            Alert::error('Gagal','Tidak ada data gambar!');
            return redirect()->back()->with('error','Gambar tidak ada data '.$validate->errors())->withInput();
        }
    }
}
