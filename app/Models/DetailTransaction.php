<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = true;
    protected $table = "detail_transaction";
    protected $fillable = [
        'id','transactionId','productId','productName',
        'variantId','variantName','price','quantity','subtotal',
        'diskon','total','created_by','updated_by'
    ];
}
