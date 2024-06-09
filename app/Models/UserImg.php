<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImg extends Model
{
    use HasFactory;
    protected $fillable =['user_id','img'];
    protected $table = 'user_imgs';
    public $timestamps = false;
    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
