<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use Session;
use DB;
use Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::paginate(10);
        $pageName = "Daftar Admin";
        return view('pages.user.index',compact('data','pageName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageName = "Form Admin";
        return view('pages.user.create',compact('pageName'));
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
            'email'=>'required|unique:users,email',
            'name'=>'required',
            'password'=>'required|min:8|confirmed'
        ]);
        if(!$validate->fails()){
            try{
                DB::beginTransaction();
                $data = User::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password)
                ]);
                DB::commit();
                if($data){
                    Alert::toast("Data berhasil di tambahkan!","success");
                    return redirect('user')->with('success','Data berhasil di tambahkan');
                }else{
                    Alert::warning('Gagal',"Data gagal di tambahkan!");
                    return back()->with("error","Data gagal ditambahkan")->withInput();
                }
            }catch(\Exception $e){
                DB::rollBack();
                Alert::error("Error Database","Data gagal di tambahkan ".$e);
                return back()->with('error','Data gagal di tambahkan '.$e)->withInput();
            }
        }else{
            $html = "<ul style='list-style:none;'>";
            foreach(session('errorForm') as $error){
                $html.="<li>$error[0]</li>";
            }
            $html .="</ul>";
            Alert::html("Error Validation Data",$html,'error');
            return redirect()->back()
                ->with('error','Error Validation')->withInput();
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
        $data = User::where('id',$id)->first();
        $pageName = "Ubah Data Admin";
        $page = "user";
        return view('pages.user.edit',compact('data','pageName','page'));
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
        $validate = Validator::make($request->all(),[
            'email'=>'required',
            'name'=>'required'
        ]);
        if(!$validate->fails()){
            try{
                DB::beginTransaction();
                $data = User::where('id',$id)->update([
                    'name'=>$request->name
                ]);
                DB::commit();
                if($data){
                    Alert::toast("Data berhasil di ubahkan!","success");
                    return redirect($request->page)->with('success','Data berhasil di ubahkan');
                }else{
                    Alert::warning('Gagal',"Data gagal di ubahkan!");
                    return back()->with("error","Data gagal ubahkan")->withInput();
                }
            }catch(\Exception $e){
                DB::rollBack();
                Alert::error("Error Database","Data gagal di ubahkan ".$e);
                return back()->with('error','Data gagal di ubahkan '.$e)->withInput();
            }
        }else{
            $html = "<ul style='list-style:none;'>";
            foreach($validate->errors() as $error){
                $html.="<li>$error</li>";
            }
            $html .="</ul>";
            Alert::html("Error Validation Data",$html,'error');
            return redirect()->back()
                ->with('error','Error Validation '.$validate->errors())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::where('id',$id)->delete();
        if($data){
            Alert::toast('Data successfully removed!','success');
            return redirect('user')->with('success','Data successfully removed!');
        }else{
            Alert::warning('Failed','Data failed to be removed!');
            return redirect('user')->with('error','Data Failed to be removed');
        }
    }
    public function profile(){
        $data = Auth::user();
        $pageName = "Profile Admin";
        $page ="profile";
        return view('pages.user.edit',compact('data','pageName','page'));
    }
    public function updatePassword(Request $req){
        $validate = Validator::make($req->all(),[
            "oldpwd"=>'required',
            'id'=>'required',
            'password'=>'required|confirmed|min:8'
        ]);
        if(!$validate->fails()){
            $user = User::where('id',$req->id)->first();
            // dd($user && Hash::check($req->oldpwd,$user->password));
            if($user && Hash::check($req->oldpwd,$user->password)){
                try{
                    DB::beginTransaction();
                    $update = User::where('id',$req->id)->update([
                        'password'=>Hash::make($req->password)
                    ]);
                    if($update){
                        Alert::toast("Data berhasil di ubahkan!","success");
                        return redirect('profile')->with('success','Data berhasil di ubahkan');
                    }else{
                        Alert::warning('Gagal',"Data gagal di ubahkan!");
                        return back()->with("error","Data gagal ubahkan")->withInput();
                    }
                }catch(\Exception $e){
                    DB::rollBack();
                    Alert::error("Error Database","Data gagal di ubahkan ".$e);
                    return back()->with('error','Data gagal di ubahkan '.$e)->withInput();
                }
            }else{
                Alert::warning('Gagal',"Kata Sandi Salah!");
                return back()->with("error","Kata Sandi Salah")->withInput();
            }
        }else{
            $html = "<ul style='list-style:none;'>";
            foreach($validate->errors() as $error){
                $html.="<li>$error</li>";
            }
            $html .="</ul>";
            Alert::html("Error Validation Data",$html,'error');
            return redirect()->back()
                ->with('error','Error Validation '.$validate->errors())->withInput();
        }
    }
}
