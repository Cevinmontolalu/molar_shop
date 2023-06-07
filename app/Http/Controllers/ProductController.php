<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\VariantProduct;
use App\Models\ReviewProduct;
use App\Models\Gallery;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use DB;
use Hash;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageName="Produk";
        $query = Product::query();
        $query->leftJoin('category','category.id','product.categoryId')
                    ->leftJoin('sub_category','sub_category.id','product.subCategoryId')
                    ->select('product.*','category.name as kategori','sub_category.name as subKategori');
                    // ->paginate(10);
        $filter = session('filter-product');
        if(isset($filter)){
            if(isset($filter['key'])){
                $query->where('product.name','LIKE',$filter['key'].'%');
            }
            if(isset($filter['kategori'])){
                $query->where('product.categoryId',$filter['kategori']);
            }
        }
        $data = $query->paginate(10);
        $kategori = Category::get();
        return view('pages.product.index',compact('data','pageName','kategori'));
    }
    public function filter(Request $req){
        $filter = session('filter-product');
        if(isset($filter)){
            Session::forget('filter-product');
        }
        $filter = array();
        $filter['key'] = isset($req->key)?$req->key:null;
        $filter['kategori'] = isset($req->kategori)?$req->kategori:null;
        if(!empty($filter)){
            session(['filter-product'=>$filter]);
        }
        return redirect('product');
    }
    public function clearFilter(){
        $filter = session('filter-product');
        if(isset($filter)){
            Session::forget('filter-product');
        }
        return redirect('product');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Category::get();
        $pageName="Produk";
        return view('pages.product.create',compact('kategori','pageName'));
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
            'description'=>'required',
            'categoryId'=>'required',
        ]);
        if(!$validate->fails()){
            try{
                DB::beginTransaction();
                $data = Product::create([
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'categoryId'=>$request->categoryId,
                    'subCategoryId'=>$request->subCategoryId,
                    'created_by'=>'System'
                ]);
                DB::commit();
                if($data){
                    Alert::toast('Data Successfully Stored!','success');
                    return redirect('product')->with('success','Data Successfully Stored!');
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
        $data = Product::leftJoin('category','category.id','product.categoryId')
                    ->leftJoin('sub_category','sub_category.id','product.subCategoryId')
                    ->select('product.*','category.name as kategori','sub_category.name as subKategori')
                    ->where('product.id',$id)->first();
        $variant = VariantProduct::where('productId',$id)->get();
        $galleries = Gallery::Where('productId',$id)->get();
        $pageName = "Detail Produk";
        $review = ReviewProduct::leftJoin('customer','customer.id','review_product.customerId')
                    ->select('review_product.*','customer.name as pelanggan')
                    ->where('productId',$id)->paginate(10);
        return view('pages.product.detail',compact('data','pageName','variant','galleries','review'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = Category::get();
        $data = Product::where('id',$id)->first();
        $pageName = "Produk";
        $variants = VariantProduct::where('productId',$id)->get();
        $galleries = Gallery::where('productId',$id)->get();
        $subKategori = SubCategory::where('categoryId',$data->categoryId)->get();
        return view('pages.product.edit',compact('data','kategori','pageName','variants','galleries','subKategori'));
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
            'description'=>'required',
            'categoryId'=>'required',
        ]);
        if(!$validate->fails()){
            try{
                DB::beginTransaction();
                $data = Product::where('id',$id)->update([
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'subCategoryId'=>$request->subCategoryId,
                    'categoryId'=>$request->categoryId,
                    'updated_by'=>'System'
                ]);
                DB::commit();
                if($data){
                    Alert::toast('Data Successfully Stored!','success');
                    return redirect('product')->with('success','Data Successfully Stored!');
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
        $data = Product::where('id',$id)->delete();
        if($data){
            Alert::toast('Data successfully removed!','success');
            return redirect('product')->with('success','Data successfully removed!');
        }else{
            Alert::warning('Failed','Data failed to be removed!');
            return redirect()->back()->with('error','Data failed to be removed!');
        }
    }
}
