<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VariantProduct;
use App\Models\Product;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use DB;
use Hash;
use Validator;

class VariantProductController extends Controller
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
        $pageName = "Variant Product ".$product->name;
        return view('pages.variant.create',compact('product','pageName'));
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
            'name'=>'required',
            'productId'=>'required',
            'description'=>'required',
            'price'=>'required',
            'stock'=>'required|numeric'
        ]);
        if(!$validate->fails()){
            try{
                DB::beginTransaction();
                $data = VariantProduct::create([
                    'name'=>$request->name,
                    'productId'=>$request->productId,
                    'description'=>$request->description,
                    'price'=>$request->price,
                    'stock'=>$request->stock,
                    'created_by'=>'System'
                ]);
                DB::commit();
                if($data){
                    Alert::toast('Data Successfully Stored!','success');
                    return redirect('product/detail/'.$request->productId)->with('success','Data Successfully Stored!');
                }else{
                    Alert::warning('Failed','Data failed to be stored! '.$data);
                    return redirect()->back()->with('error','Data failed to be stored '.$data)->withInput();
                }
            }catch(\Exception $e){
                DB::rollBack();
                Alert::warning('Failed','Data failed to be stored! '.$e);
                return redirect()->back()->with('error','Data failed to be stored! '.$e)->withInput();
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
        $data = VariantProduct::where('id',$id)->first();
        $product = Product::where('id',$data->productId)->first();
        $pageName = "Edit Variant Produk";
        return view('pages.variant.edit',compact('data','product','pageName'));
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
            'name'=>'required',
            'productId'=>'required',
            'description'=>'required',
            'price'=>'required',
            'stock'=>'required|numeric'
        ]);
        if(!$validate->fails()){
            try{
                DB::beginTransaction();
                $data = VariantProduct::where('id',$id)->update([
                    'name'=>$request->name,
                    'productId'=>$request->productId,
                    'description'=>$request->description,
                    'price'=>$request->price,
                    'stock'=>$request->stock,
                    'created_by'=>'System'
                ]);
                DB::commit();
                if($data){
                    Alert::toast('Data Successfully Stored!','success');
                    return redirect('product/detail/'.$request->productId)->with('success','Data Successfully Stored!');
                }else{
                    Alert::warning('Failed','Data failed to be stored! '.$data);
                    return redirect()->back()->with('error','Data failed to be stored '.$data)->withInput();
                }
            }catch(\Exception $e){
                DB::rollBack();
                Alert::warning('Failed','Data failed to be stored! '.$e);
                return redirect()->back()->with('error','Data failed to be stored! '.$e)->withInput();
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
        $d = VariantProduct::where('id',$id)->first();
        $data = VariantProduct::where('id',$id)->delete();
        if($data){
            Alert::toast('Data successfully removed!','success');
            return redirect('product/detail/'.$d->productId)->with('success','Data successfully removed!');
        }else{
            Alert::warning('Failed','Data failed to be removed!');
            return redirect('product/detail/'.$d->productId)->with('error','Data failed to be removed!');
        }
    }
}
