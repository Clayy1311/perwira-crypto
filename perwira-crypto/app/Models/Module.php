<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
     use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'price',
        'thumbnail'
    ];

    public function contents()
{
    return $this->hasMany(ModuleContent::class);
}

 
}
