<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    const IS_DELETED = 1;
    
    use HasFactory;
    protected $fillable = [
        'title',
        'url',
        'id_new',
        'id_user',
        'is_deleted'
    ];
}
