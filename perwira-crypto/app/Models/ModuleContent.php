<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleContent extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'content_type',
        'url',
        'duration',
        'order',
    ];

    // Relasi ke Module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
