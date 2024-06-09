<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use App\Traits\MediaTrait;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request,$id)
    {
        try {
            $request->validate([
                'image' => 'image|mimes:png,jpg,svg|max:2048',
            ]);
            $product = Product::find($id);
            $data = $request->all();
            if (!$product) {
                return ResponseTrait::responseSuccess([], 'Product doesn\'t find');
            }
            if ($request->hasFile('image')) {
                $photoName = MediaTrait::upload($request->file('image'), 'products');
                $photoNamePath = asset('/uploads/' . $photoName);
                $data['image'] = $photoNamePath;
            }
            $product->images()->create($data);
            return ResponseTrait::responseSuccess($data,'Product added successfully');
        }
        catch (\Exception $exception){
            return ResponseTrait::responseError($exception,'Error! Try To add Product again');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

//    public function update(Request $request,$id)
//    {
//        try {
//            $image = Image::find($id);
//            if (!$image) {
//                return ResponseTrait::responseError([], 'Image not found.');
//            }
//            $old_image = $image->image;
//            MediaTrait::delete($old_image);
//
//            $data = $request->all();
//            if ($request->hasFile('image') && $request->file('image')->isValid()) {
//                $newImage = MediaTrait::upload($request->file('image'), 'products');
//                $image->update(['image' => $newImage]);
//            }
//            return ResponseTrait::responseSuccess([], 'Image updated successfully.');
//        } catch (Exception $exception) {
//            return ResponseTrait::responseError($exception->getMessage(), 'Failed to update image.');
//        }
//
//    }
    public function update(Request $request, $productId,$id)
    {
        try {
            $request->validate([
                'image' => 'image|mimes:png,jpg,svg|max:2048',
            ]);

            // Find the product
            $product = Product::find($productId);

            if (!$product) {
                return ResponseTrait::responseError([], 'Product not found.');
            }

            // Find the image within the product
            $image = $product->images()->find($id);

            if (!$image) {
                return ResponseTrait::responseError([], 'Image not found.');
            }

            // Delete the old image
            MediaTrait::delete($image->image);

            // Upload and save the new image
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $newImage = MediaTrait::upload($request->file('image'), 'products');
                $image->update(['image' => $newImage]);
            }

            return ResponseTrait::responseSuccess([], 'Image updated successfully.');
        } catch (\Exception $exception) {
            return ResponseTrait::responseError($exception->getMessage(), 'Failed to update image.');
        }
    }

    public function destroy(Image $image)
    {
        try {
            if ($image->image) {
                MediaTrait::delete($image->image);
                $image->delete();
            }

            return ResponseTrait::responseSuccess([], 'Image deleted successfully.');
        } catch (Exception $exception) {
            return ResponseTrait::responseError($exception);
        }
    }

}
