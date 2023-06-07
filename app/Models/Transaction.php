<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = true;
    protected $table = "transaction";
    protected $fillable = [
        'id','tanggal','jam','code','customerId','addressId',
        'subtotal','quantity','diskon','total','status','transfer_prove',
        'created_by','updated_by','rekeningId'
    ];
}
