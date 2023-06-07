<?php

namespace App\Http\Controllers;

use App\Models\ShopProfile;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ShopProfileController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopProfile  $shopProfile
     * @return \Illuminate\Http\Response
     */
    public function show(ShopProfile $shopProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopProfile  $shopProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopProfile $shopProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShopProfile  $shopProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = ShopProfile::where('id',$request->id)->update([
            'email'=>$request->email,
            'phone_no'=>$request->phone_no,
            'address'=>$request->address
        ]);
        if($data){
            Alert::toast('Data Successfully Stored!','success');
            return redirect('shop-profile')->with('success','Data Successfully Stored!');
        }else{
            Alert::warning('Failed','Data failed to be stored!');
            return back()->with('error','Data Failed to be stored! '.$data)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopProfile  $shopProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopProfile $shopProfile)
    {
        //
    }

    public function profile(){
        $profile = ShopProfile::first();
        $pageName = "Profil Toko";
        return view('pages.shop_profile.index',compact('profile','pageName'));
    }
}
