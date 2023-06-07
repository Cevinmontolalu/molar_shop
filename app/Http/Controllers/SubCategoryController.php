<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use DB;
class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SubCategory::leftJoin('category','category.id','sub_category.categoryId')
                    ->select('sub_category.*','category.name as kategori')
                    ->paginate(10);
        $pageName = "Sub Kategori";
        return view('pages.sub_category.index',compact('data','pageName'));
    }

    public function getSubCategoryByCategoryId($categoryId){
        $data = SubCategory::where('categoryId',$categoryId)->get();
        if($data){
            return response()->json(['status'=>'success','data'=>$data],200);
        }
        return response()->json(['status'=>'empty'],500);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Category::get();
        $pageName= "Sub Kategori";
        return view('pages.sub_category.create',compact('kategori','pageName'));
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
            'categoryId'=>'required',
            'description'=>'required'
        ]);
        if(!$validate->fails()){
            try{
                DB::beginTransaction();
                $data = SubCategory::create([
                    'name'=>$req->name,
                    'categoryId'=>$req->categoryId,
                    'description'=>$req->description,
                    'created_by'=>auth()->user()->name
                ]);
                DB::commit();
                if($data){
                    Alert::toast('Data Successfully added','success');
                    return redirect('subCategory')->with('success','Data Stored successfully');
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
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  
        $data = SubCategory::where('id',$id)->first();
        $kategori = Category::get();
        $pageName = "Sub Kategori";
        return view('pages.sub_category.edit',compact('data','pageName','kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $validate = Validator::make($req->all(),[
            'name'=>'required',
            'categoryId'=>'required',
            'description'=>'required'
        ]);
        if(!$validate->fails()){
            try{
                DB::beginTransaction();
                $data = SubCategory::where('id',$id)->update([
                    'name'=>$req->name,
                    'categoryId'=>$req->categoryId,
                    'description'=>$req->description,
                    'updated_by'=>auth()->user()->name
                ]);
                DB::commit();
                if($data){
                    Alert::toast('Data Successfully added','success');
                    return redirect('subCategory')->with('success','Data Stored successfully');
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = SubCategory::where('id',$id)->delete();
        if($data){
            Alert::toast('Data Successfully removed!','success');
            return redirect('subCategory')->with('success','Data successfully removed!');
        }else{
            Alert::warning('Failed','Data failed to be removed!');
            return redirect('subCategory')->with('error','Data failed to be removed!')->withInput();
        }
    }
}
