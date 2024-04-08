<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
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
        static::observe(CartObserver::class);
        static::addGlobalScope('cookie_id',function (Builder $builder){
            $builder->where('cookie_id','=' , Cart::getCookieId() );
        });
//        static::creating(function (cart $cart){
//            $cart->id = str::uuid();
//        });
    }
    public static function getCookieId(): \Ramsey\Uuid\UuidInterface|array|string|null
    {
        $cookie_id = \Illuminate\Support\Facades\Cookie::get('cart_id');
        if (!$cookie_id){
            $cookie_id = str::uuid();
            \Illuminate\Support\Facades\Cookie::queue('cart_id',$cookie_id,30*24*60);
        }
        return $cookie_id;
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name'=>'Anonymous',
        ]);
    }
    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return$this->belongsTo(Product::class);
    }
}

