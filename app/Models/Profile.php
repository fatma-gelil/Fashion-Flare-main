<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    public $primaryKey = 'user_id';
    protected $fillable = ['user_id','full_name','nickname',
        'phone_number','age','gender','country',
        'address','height','width','shoulder',
        'chest','waist','hips','thigh','inseam'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
