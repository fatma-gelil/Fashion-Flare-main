<?php

namespace App\Models;

use App\Observers\Cartobserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'cookie_id','user_id','product_id','quantity','options',
        ];

    //Events(observers)
    //creating,created,updating,updated,saving,saved
    //deleting,deleted,restoring,restored,retrieved
    public static function create(array $array)
    {
        //
    }

    protected static function booted(){
        static::observe(Cartobserver::class);
//        static::creating(function (cart $cart){
//            $cart->id = str::uuid();
//        });
    }
    public function user(){
        return $this->belongsTo(User::class)->withDefault([
            'name'=>'Anonymous',
        ]);
    }
    public function product(){
        return$this->belongsTo(Product::class);
    }
}
