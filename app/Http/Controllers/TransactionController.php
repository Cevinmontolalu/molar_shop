<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\DetailTransaction;
use App\Models\Customer;
use Validator;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Session;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = date('Y-m-d',strtotime('now'));
        $query = Transaction::query();
        $query->leftJoin('customer','customer.id','transaction.customerId')
                    ->leftJoin('customer_address','customer_address.id','transaction.addressId')
                    ->leftJoin('shop_rekening','shop_rekening.id','transaction.rekeningId')
                    ->select('transaction.*','customer.name AS pelanggan','customer_address.address AS alamat','shop_rekening.name as bank');
        $filter = session('filter-transaction');
        if(isset($filter)){
            if($filter["date"]=="0"){
                if(isset($filter['startDate'])){
                    $query->where('tanggal',$filter['startDate']);
                }else if(isset($filter['endDate'])){
                    $query->where('tanggal',$filter['endDate']);
                }
            }else{
                $query->where('tanggal','<=',$filter['endDate']);
                $query->where('tanggal','>=',$filter['startDate']);
            }
            if(isset($filter['status'])){
                $query->where('status',$filter['status']);
            }
        }
        $data = $query->paginate(10);
        $sql = $query->toSql();
        dd($sql);
        $pageName = "Transaksi";
        return view('pages.transaksi.index',compact('data','pageName','sql'));
    }

    public function filter(Request $req){
        $filter = session('filter-transaction');
        if(isset($filter)){
            Session::forget('filter-transaction');
        }
        $filter = array();
        $filter["startDate"] = isset($req->startDate)?$req->startDate:null;
        $filter['endDate'] = isset($req->endDate)?$req->endDate:null;
        $filter['status']=isset($req->status)?$req->status:null;
        if(isset($filter['startDate']) && isset($filter['endDate'])){
            $filter['date'] = "1";
        }else{
            $filter["date"] = "0";
        }
        if(!empty($filter)){
            session(['filter-transaction'=>$filter]);
        }
        return redirect('transaction');
    }
    public function clearFilter(){
        $filter = session('filter-transaction');
        if(isset($filter)){
            Session::forget('filter-transaction');
        }
        return redirect('transaction');
    }

    public function getData()
    {
        $date = date('Y-m-d',strtotime('now'));
        $query = Transaction::query();
        $query->leftJoin('customer','customer.id','transaction.customerId')
                    ->leftJoin('customer_address','customer_address.id','transaction.addressId')
                    ->leftJoin('shop_rekening','shop_rekening.id','transaction.rekeningId')
                    ->select('transaction.*','customer.name AS pelanggan','customer_address.address AS alamat','shop_rekening.name as bank');
        $filter = session('filter-transaction');
        if(isset($filter)){
            if($filter["date"]=="0"){
                if(isset($filter['startDate'])){
                    $query->where('tanggal',$filter['startDate']);
                }else if(isset($filter['endDate'])){
                    $query->where('tanggal',$filter['endDate']);
                }
            }else{
                $query->where('tanggal','<=',$filter['endDate']);
                $query->where('tanggal','>=',$filter['startDate']);
            }
            if(isset($filter['status'])){
                $query->where('transaction.status',$filter['status']);
            }
        }
        $data = $query->paginate(10);
        $sql = $query->toSql();
        // dd($sql);
        $pageName = "Transaksi";
        return view('pages.transaksi.index',compact('data','pageName','sql'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageName = "Detail Transaksi";
        $transaction = Transaction::leftJoin('customer_address','customer_address.id','transaction.addressId')
                    ->leftJoin('shop_rekening','shop_rekening.id','transaction.rekeningId')
                    ->select('transaction.*','customer_address.address as address','shop_rekening.nomor_rekening as nomor_rekening','shop_rekening.name as bank')
                    ->where('transaction.id',$id)->first();
        $customer = Customer::where('id',$transaction->customerId)->first();
        $detailTransaksi = DetailTransaction::where('transactionId',$id)->get();
        return view('pages.transaksi.detail',compact('transaction','customer','detailTransaksi','pageName'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function updateStatus(Request $req){
        $validate = Validator::make($req->all(),[
            'id'=>'required',
            'status'=>'required'
        ]);
        if(!$validate->fails()){
            $update = Transaction::where('id',$req->id)->update([
                'status'=>$req->status,
                'updated_by'=>Auth::user()->email
            ]);
            if($update){
                Alert::toast('Status Transaksi Berhasil di rubah ke '.$req->status,'success');
                return redirect('transaction/detail/'.$req->id)->with('success','Status Transaksi Berhasil di rubah ke '.$req->status);
            }else{
                Alert::warning("Gagal","Status Transaksi Gagal di rubah ke ".$req->status);
                return back()->withInput()->with('error','Status Transaksi Gagal di rubah ke '.$req->status);
            }
        }else{
            Alert::warning('Gagal','Validasi Gagal');
            return back()->withInput()->with('error','data tidak lengkap '.$validate->errors());
        }
    }
}
