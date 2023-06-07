<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Session;
use DB;
use Hash;
use Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageName = "Pelanggan";
        $data = Customer::paginate(10);
        return view('pages.customer.index',compact('pageName','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageName = "Pelanggan";
        return view('pages.customer.create',compact('pageName'));
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
            'email'=>'required|email',
            'name'=>'required',
            'gender'=>'required',
            'phone_no'=>'required',
            'password'=>'required|confirmed|min:8',
            'status'=>'required'
        ]);
        if(!$validate->fails()){
            try{
                DB::beginTransaction();
                $data = Customer::create([
                    'email'=>$request->email,
                    'name'=>$request->name,
                    'phone_no'=>$request->phone_no,
                    'gender'=>$request->gender,
                    'dob'=>isset($request->dob)?$request->dob:null,
                    'password'=>Hash::make($request->password),
                    'status'=>$request->status,
                    'created_by'=>'System'
                ]);

                DB::commit();
                if($data){
                    Alert::toast('Data Successfully Stored!','success');
                    return redirect('customer')->with('success','Data Successfully Stored!');
                }else{
                    Alert::warning('Failed','Data failed to be stored!');
                    return back()->with('error','Data Failed to be stored! '.$data)->withInput();
                }
            }catch(\Exception $e){
                DB::rollBack();
                Alert::error('Error Database','Data failed while being stored! '.$e);
                return back()->with('error','Data failed to be stored!')->withInput();
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
        $pageName = "Data Pelanggan";
        $data = Customer::where('id',$id)->first();
        $address = CustomerAddress::where('customerId',$id)->get();
        return view('pages.customer.detail',compact('pageName','data','address'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Customer::where('id',$id)->first();
        $pageName = "Pelanggan";
        return view('pages.customer.edit',compact('data','pageName'));
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
            'email'=>'required|email',
            'name'=>'required',
            'gender'=>'required',
            'phone_no'=>'required',
            // 'password'=>'required|password_confirmation|min:8',
            'status'=>'required'
        ]);
        if(!$validate->fails()){
            try{
                DB::beginTransaction();
                $data = Customer::where('id',$id)->update([
                    'email'=>$request->email,
                    'name'=>$request->name,
                    'phone_no'=>$request->phone_no,
                    'gender'=>$request->gender,
                    'dob'=>isset($request->dob)?$request->dob:null,
                    'password'=>Hash::make($request->password),
                    'status'=>$request->status,
                    'created_by'=>'System'
                ]);

                DB::commit();
                if($data){
                    Alert::toast('Data Successfully Stored!','success');
                    return redirect('customer')->with('success','Data Successfully Stored!');
                }else{
                    Alert::warning('Failed','Data failed to be stored!');
                    return back()->with('error','Data Failed to be stored! '.$data)->withInput();
                }
            }catch(\Exception $e){
                DB::rollBack();
                Alert::error('Error Database','Data failed while being stored! '.$e);
                return back()->with('error','Data failed to be stored!')->withInput();
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Customer::where('id',$id)->delete();
        if($data){
            Alert::toast('Data successfully removed!','success');
            return redirect('customer')->with('success','Data successfully removed!');
        }else{
            Alert::warning('Failed','Data failed to be removed!');
            return redirect('customer')->with('error','Data Failed to be removed');
        }
    }

    public function reset_password($id){
        $data = Customer::where('id',$id)->update([
            'password'=>Hash::make("1234567890")
        ]);
        if($data){
            Alert::toast('Kata Sandi berhasil di reset','success');
            return redirect('customer/edit/'.$id)->with('success','Kata sandi berhasil di reset');
        }else{
            Alert::warning('Gagal','Gagal me-reset kata sandi, silahkan coba lagi');
            return redirect('custoemr/edit/'.$id)->with('error','Gagal me-reset kata sandi');
        }
    }
    
    public function upload_picture(Request $req,$id){
        $validate = Validator::make($req->all(),[
            'file'=>'required|mimes:jpg,png,jpeg,webpp|max:2048'
        ]);
        if(!$validate->fails()){
            if($file = $req->file('file')){
                $destination = 'profile_picture/';
                $profilePicture = date('YmdHis').".".$file->getClientOriginalExtension();
                $file->move($destination,$profilePicture);
                $data = Customer::where('id',$id)->update([
                    'profile_picture'=>$profilePicture
                ]);
                if($data){
                    Alert::toast("Foto Profile berhasil di ubah","success");
                    return redirect('customer/edit/'.$id)->with('success','Foto Profil berhasil di ubah');
                }else{
                    unlink($destination."/".$profilePicture);
                    Alert::error('Gagal','Foto Profile Gagal di ubah');
                    return redirect('customer/edit/'.$id)->with('error','Foto profile gagal di ubah!');
                }
            }else{
                Alert::warning('Gagal','Foto Gagal di upload!');
                return redirect('customer/edit/'.$id)->with('error','Foto profile gagal di upload!');
            }
        }else{
            Alert::error('Gagal','Tidak ada data gambar!');
            return redirect('customer/edit/'.$id)->with('error','Foto profil tidak ada data');
        }
    }
    
}
