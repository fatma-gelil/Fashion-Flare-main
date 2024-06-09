<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','description','logo','status'];

    public static function rules($id = null)
    {
        $uniqueRule = ($id) ? ',id,' . $id : '';

        return [
            'name' => 'required|unique:categories,name' . $uniqueRule,
            'description' => 'nullable|string',
            'logo'=>
                [ 'image' , 'max:1048576' , 'dimensions:min_width=100,min_height=200' ],
            'status'=>'required|in:active,archived'        ];
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
