<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\VariantProduct;
use App\Models\ReviewProduct;
use App\Models\ShopProfile;
use App\Models\Banner;
use App\Models\Gallery;
use App\Models\SubCategory;
use App\Models\Customer;
use App\Models\Transaction;

class HomeController extends Controller
{
    
    public function index(){
        $kategori = Category::get();
        $banner = Banner::get();
        $highlightCategory = Category::leftJoin('product','product.categoryId','category.id')
                                ->leftJoin('gallery','gallery.productId','product.id')
                                ->select('category.*','gallery.link as photo','product.id as productId')
                                ->where('gallery.link','!=','NULL')
                                ->groupBy('category.id')
                                ->inRandomOrder()->limit(3)->get();
        $products = array();
        $count = 1;
        foreach($highlightCategory as $hlc){
            $products['list'.$count] = Product::leftJoin('gallery','gallery.productId','product.id')
                                    ->leftJoin('variant','variant.productId','product.id')
                                    ->leftJoin('category','category.id','product.categoryId')
                                    ->select('product.*','gallery.link as photo','category.name as kategori','variant.name as variantName','variant.price as price')
                                    ->where('product.categoryId',$hlc->id)
                                    ->whereRaw('(SELECT count(id) FROM variant WHERE productId=product.id)>0')
                                    ->distinct()//->groupBy('product.id')
                                    ->inRandomOrder()->limit(5)->get();
            $count+=1;
        }
        return view('shop.home',compact('kategori','banner','highlightCategory','products'));
    }
    public function adminDashboard(){
        $date = date('Y-m-d');
        $transaction = Transaction::leftJoin('customer','customer.id','transaction.customerId')
        ->leftJoin('customer_address','customer_address.id','transaction.addressId')
        ->leftJoin('shop_rekening','shop_rekening.id','transaction.rekeningId')
        ->select('transaction.*','customer.name AS pelanggan','customer_address.address AS alamat','shop_rekening.name as bank')
            ->where('tanggal',$date)->paginate(10);
        $onProcess = Transaction::where('status','On Process')->where('tanggal',$date)->count();
        $finish = Transaction::where('status','Finish')->where('tanggal',$date)->count();
        $rejected = Transaction::where('status','Rejected')->where('tanggal',$date)->count();
        $customers = Customer::count();
        $newCustomers = Customer::where('created_at','<=',$date." 23:59:59")->where('created_at','>=',$date." 00:00:00")->count();
        $pageName = "Molar Dashboard";
        return view('pages.dashboard',compact('transaction','onProcess','finish','rejected','customers','newCustomers','pageName'));
    }
}
