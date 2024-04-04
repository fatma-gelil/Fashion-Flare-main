<?php
namespace App\Repositories\Cart;
use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use http\Cookie;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepository
{
    public function get():Collection{
        return Cart::with('product')
            ->where('cookie_id','=' , $this->getCookieId() )->get();
    }

    public function add(product $product, $quantity = 1)
    {
        $item=Cart::where('product_id','=',$product->id)
            ->where('cookie_id','=' , $this->getCookieId())
            ->first();
        if (!$item){
            /** @noinspection PhpVoidFunctionResultUsedInspection */
            return Cart::create([
                'cookie_id'=>$this->getCookieId(),
                'user_id'=>Auth::id(),
                'product_id'=>$product->id,
                'quantity'=>$quantity,
            ]);
        }
        return $item->increment('quantity',$quantity);
    }

    public function update(product $product, $quantity)
    {
        Cart::where('product_id','=',$product->id)
            ->where('cookie_id','=' , $this->getCookieId())
            ->update([
                'quantity'=>$quantity,
            ]);
    }

    public function delete($id)
    {
        Cart::where('id','=',$id)
            ->where('cookie_id','=' , $this->getCookieId() )
            ->delete();
    }

    public function empty()
    {
        Cart::Where('cookie_id',$this->getCookieId() )->destroy();
    }

    public function total() :float
    {
       return(float) Cart::Where('cookie_id',$this->getCookieId())
            ->join('products' , 'products.id' , '=' , 'carts.product_id')
            ->selectRaw('sum(products.price * carts.quantity) as total')
            ->value('total');
    }
    protected function getCookieId(){
        $cookie_id = \Illuminate\Support\Facades\Cookie::get('cart_id');
        if (!$cookie_id){
            $cookie_id = str::uuid();
            \Illuminate\Support\Facades\Cookie::queue('cart_id',$cookie_id,30*24*60);
        }
        return $cookie_id;
    }
}
