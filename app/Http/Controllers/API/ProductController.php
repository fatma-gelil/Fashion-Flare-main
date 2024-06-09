<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Color;
use App\Models\Image;
use App\Models\Product;
use App\Models\Style;
use App\Traits\MediaTrait;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::with('images')->get();
            return ResponseTrait::responseSuccess($products,);
        }
        catch (\Exception $exception){
            return ResponseTrait::responseError($exception,'No Products Found');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            $request->merge([
                'slug' => Str::slug($request->post('name')),
            ]);
            $data = $request->all();
            Product::create($data);
            return ResponseTrait::responseSuccess($data,'Product added successfully');
        } catch (Exception $exception) {
            return ResponseTrait::responseError($exception->getMessage(),'Error! Try To add Product again');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $product =  Product::find($id);
            $images = $product->images()->pluck('image');
            $product->images = $images->toArray();

            $colors = $product->colors()->pluck('name');
            $product->colors = $colors->toArray();
            return ResponseTrait::responseSuccess($product);
        }
        catch (\Exception $exception){
            return ResponseTrait::responseError($exception,'Product Not found');

        }    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        try{
            if(!$product){
                return ResponseTrait::responseError([],'Product Not found');
            }
            if ($request->has('name') && $request->input('name') !== $product->name) {
                $product->slug = Str::slug($request->input('name'));
            }
           $product->update($request->all());
            return ResponseTrait::responseSuccess($product,'Product updated successfully');
        }
        catch (\Exception $exception){
            return ResponseTrait::responseError($exception,'Failed to update product');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try
        {
            $product = Product::find($id);

            $images = Image::where('product_id',$product->id)->get();
            if(!$product){
                return ResponseTrait::responseError([],'Product Not found');
            }

            foreach ($images as $image) {
                if ($image->image) {
                    MediaTrait::delete($image->image);
                }
            }


                $product->images()->delete();
                $product->delete();
            return ResponseTrait::responseSuccess($product,'Product deleted successfully');
        }
        catch (\Exception $exception){
            return ResponseTrait::responseError($exception->getMessage(),'Failed to delete product');

        }

    }
    public function add_color(Request $request,$id)
    {
        try {
            $product = Product::find($id);
            $colorData = $request->all();

            $color = Color::create($colorData);

            $product->colors()->attach($color->id);

            return ResponseTrait::responseSuccess($color,'Color created successfully for the Product');

        } catch (Exception $exception) {
            return ResponseTrait::responseError($exception);
        }
    }

}
