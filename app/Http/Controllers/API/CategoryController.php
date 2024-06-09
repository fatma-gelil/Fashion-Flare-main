<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;
use App\Traits\MediaTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\ResponseTrait;

class CategoryController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Category::with(['products'])->get();
            return ResponseTrait::responseSuccess($categories);
        } catch (Exception $exception) {
            return ResponseTrait::responseError($exception);
        }
    }
    public function store(CategoryRequest $request)
    {
        try {
            $request->merge([
                'slug' => Str::slug($request->post('name')),
            ]);
            $data = $request->all();

            if ($request->hasFile('logo')) {
                $photoName = MediaTrait::upload($request->file('logo'), 'logos');
                $photoNamePath = asset('/uploads/' . $photoName);
                $data['logo'] = $photoNamePath;
            }


            Category::create($data);
            return ResponseTrait::responseSuccess($data,'Category added successfully');
        } catch (Exception $exception) {
            return ResponseTrait::responseError($exception,'Error! Try To add Category again');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        try{
        $products = Product::with('category')->where('category_id','=',$category->id)->get();
//            $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
//                ->select('products.*')
//                ->where('categories.id', '=', $category->id)
//                ->get();
        return ResponseTrait::responseSuccess($products);
        }
        catch (Exception $exception) {
        return ResponseTrait::responseError($exception,'Error! Try again');
}
    }

    public function update(Request $request,$id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return ResponseTrait::responseError(null, 'Category not found');
            }

            if ($request->hasFile('logo')) {
                $photoName = MediaTrait::upload($request->file('logo'), 'logos');
                $photoNamePath = asset('/uploads/' . $photoName);
                $category->logo = $photoNamePath;
            }
            if ($request->has('name') && $request->input('name') !== $category->name) {
                $category->slug = Str::slug($request->input('name'));
            }
            // Update other fields
            $category->update($request->except('logo'));

            return ResponseTrait::responseSuccess($category, 'Category updated successfully');
        } catch (Exception $exception) {
            return ResponseTrait::responseError($exception, 'Error! Try to update Category');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
