<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    public $primaryKey = 'user_id';
    protected $fillable = ['user_id','first_name','last_name','nickname',
        'phone_number','age','gender','country',
        'address','height','width','shoulder',
        'chest','waist','hips','thigh','inseam','fav_brand','user_img'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
