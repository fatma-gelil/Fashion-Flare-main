<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\App;

class CartController extends Controller
{
    protected CartRepository $cart;
    public function __construct(CartRepository $cart){
        $this->cart = $cart;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CartRepository $cart)
    {
        try{

            $items= $cart->get();
        }catch (Exception $exception){
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
                'data' => null,
            ]);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request , CartRepository $cart): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        try {
            $request->validate([
                'product_id'=>['required','int','exists:products,id'],
                'quantity'=>['nullable','int','min:1'],
            ]);
            $product = Product::findOrFail($request->input('product_id'));
            $this->cart->add($product,$request->post('quantity'));
            return redirect()->back()->with('succeeded','product added to cart');
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
                'data' => null,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartRepository $cart)
    {
        try {
            $request->validate([
                'product_id'=>['required','int','exists:products,id'],
                'quantity'=>['nullable','int','min:1'],
            ]);
            $product = Product::findOrFail($request->input('product_id'));
            $cart->update($product,$request->post('quantity'));
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
                'data' => null,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartRepository $cart , $id)
    {
        try {
            $cart->delete($id);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
                'data' => null,
            ]);
        }
    }
}
