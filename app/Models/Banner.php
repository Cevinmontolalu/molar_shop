<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Banner extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = true;
    protected $table="banner";
    protected $fillable = [
        'id','title','description',
        'image','link','created_by','updated_by'
    ];
}
