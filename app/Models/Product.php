<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(mixed $input)
 */
class Product extends Model
{
    use HasFactory;

    public mixed $id;


}
