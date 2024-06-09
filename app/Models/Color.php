<?php

namespace App\Models;

use App\Http\Controllers\API\User\ProfileController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $fillable =['name'];
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
