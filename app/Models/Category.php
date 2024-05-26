<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded  = ['id'];

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->whereNotNull('parent_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }
    // public function parentCategories()
    // {
    //     return $this->hasOne(Category::class, 'parent_id')->where('parent_id', null);
    // }
}
