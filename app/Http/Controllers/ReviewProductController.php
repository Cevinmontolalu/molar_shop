<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Modes\ReviewProduct;
use Session;
use DB;
use Hash;
use Validator;

class ReviewProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ReviewProductController::paginate(10);
        return view('pages.review_product.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.review_product.create');
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
            'productId'=>'required',
            'transactionId'=>'required',
            'customerId'=>'required',
            'rating'=>'required|numeric',
            'description'=>'required'
        ]);
        if($validate->fails()){
            try{
                DB::beginTransaction();
                $data = ReviewProduct::create([
                    'productId'=>$request->productId,
                    'transactionId'=>$request->transactionId,
                    'customerId'=>$request->customerId,
                    'rating'=>$request->rating,
                    'description'=>$request->description,
                    'created_by'=>'System'
                ]);
                DB::commit();
                if($data){
                    Alert::toast('Data successfully stored!','success');
                    return redirect()->route('review_product.index')->with('success','Data successfully Stored!');
                }else{
                    Alert::warning('Failed','Data failed to be stored! '.$data);
                    return redirect()->back()->with('error','Data failed to be stored!')->withInput();
                }
            }catch(\Exception $e){
                DB::rollBack();
                Alert::warning('Failed','Data failed to be stored '.$e);
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
        $data = ReviewProduct::where('id',$id)->first();
        return view('pages.review_product.edit',compact('data'));
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
            'productId'=>'required',
            'transactionId'=>'required',
            'customerId'=>'required',
            'rating'=>'required|numeric',
            'description'=>'required'
        ]);
        if($validate->fails()){
            try{
                DB::beginTransaction();
                $data = ReviewProduct::where('id',$id)->update([
                    'productId'=>$request->productId,
                    'transactionId'=>$request->transactionId,
                    'customerId'=>$request->customerId,
                    'rating'=>$request->rating,
                    'description'=>$request->description,
                    'updated_by'=>'System'
                ]);
                DB::commit();
                if($data){
                    Alert::toast('Data successfully stored!','success');
                    return redirect()->route('review_product.index')->with('success','Data successfully Stored!');
                }else{
                    Alert::warning('Failed','Data failed to be stored! '.$data);
                    return redirect()->back()->with('error','Data failed to be stored!')->withInput();
                }
            }catch(\Exception $e){
                DB::rollBack();
                Alert::warning('Failed','Data failed to be stored '.$e);
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
        $data = ReviewProduct::where('id',$id)->delete();
        if($data){
            Alert::toast('Data successfully removed!','success');
            return redirect()->route('review_product.index')->with('success','Data successfully removed!');
        }else{
            Alert::warning('Failed','Data failed to be removed!');
            return redirect()->back()->with('error','Data failed to be removed!')->withInput();
        }
    }
}
