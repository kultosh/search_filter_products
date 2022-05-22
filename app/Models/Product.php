<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'descrption', 'price', 'image'];

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_id', 'id');
    }
    
}
