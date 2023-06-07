<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Category::paginate(10);
        $pageName = "Kategori Produk";
        return view('pages.category.index',compact('data','pageName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageName = "Kategori Produk";
        return view('pages.category.create',compact('pageName'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $validate = Validator::make($req->all(),[
            'name'=>'required',
            'description'=>'required'
        ]);
        if(!$validate->fails()){
            try{
                DB::beginTransaction();
                $data = Category::create([
                    'name'=>$req->name,
                    'description'=>$req->description,
                    'created_by'=>auth()->user()->name
                ]);
                DB::commit();
                if($data){
                    Alert::toast('Data Successfully added','success');
                    return redirect('category')->with('success','Data Stored successfully');
                }else{
                    Alert::warning('Failed','Data Failed to be stored!');
                    return back()->with('error','Data failed to be stored! '.$data)->withInput();
                }
            }catch(\Exception $e){
                DB::rollBack();
                Alert::error('Error Storing Data','Data Error while storing data! '.$e);
                return redirect()->back()
                    ->with('error','Error during storing '.$e)->withInput();
            }
            
        }else{

            // dd($validate->errors());
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
        $data = Category::where('id',$id)->first();
        $pageName = "Kategori Produk";
        return view('pages.category.edit',compact('data','pageName'));
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
            'description'=>'required'
        ]);
        if(!$validate->fails()){
            try{
                DB::beginTransaction();
                $data = Category::where('id',$id)->update([
                    'name'=>$req->name,
                    'description'=>$req->description,
                    'created_by'=>'System'
                ]);
                DB::commit();
                if($data){
                    Alert::toast('Data Successfully updated','success');
                    return redirect('category')->with('success','Data Stored successfully');
                }else{
                    Alert::warning('Failed','Data Failed to be stored!');
                    return back()->with('error','Data failed to be stored! '.$data)->withInput();
                }
            }catch(\Exception $e){
                DB::rollBack();
                Alert::error('Error Storing Data','Data Error while storing data!');
                return redirect()->back()
                    ->with('error','Error during storing '.$e)->withInput();
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
        $data = Category::where('id',$id)->delete();
        if($data){
            Alert::toast('Data Successfully removed!','success');
            return redirect('category')->with('success','Data successfully removed!');
        }else{
            Alert::warning('Failed','Data failed to be removed!');
            return redirect('category')->with('error','Data failed to be removed!')->withInput();
        }
    }
}
