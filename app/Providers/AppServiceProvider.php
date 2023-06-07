<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\DetailTransaction;
use App\Models\ShopProfile;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $kategori = Category::get();
        view()->composer('*',function($view){
            $user = Auth::guard('customer')->user();
            if(isset($user)){
                $cart = Transaction::where('customerId',$user->id)->where('status','Cart')->first();
                $detailCart = [];
                if($cart){
                    $detailCart = DetailTransaction::leftJoin('gallery','gallery.productId','detail_transaction.productId')
                                    ->select('detail_transaction.*','gallery.link as photo')
                                    ->groupBy('detail_transaction.id')
                                    ->where('transactionId',$cart->id)->get();
                        // view()->share('detailCart',$detailCart);
                }
                $cartData = ['cart'=>$cart,'detailCart'=>$detailCart];
                $view->with('cart',$cartData);
            }
            
        });
        // dd($user);
        $shopProfile = ShopProfile::first();
        $shared = ['kategori'=>$kategori,'shop_profile'=>$shopProfile];
        // dd($shared);
        view()->share('shared',$shared);

        Paginator::useBootstrap();
    }
}
