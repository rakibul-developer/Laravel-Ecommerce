<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    protected $guarded  = ['id'];

    public function userInfo()
    {
        return $this->belongsTo(User::class);
    }
}
