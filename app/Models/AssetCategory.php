<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'group'];

    protected $table = "asset_categories";

    function asset_group()
    {
        # code...
        return $this->belongsTo('App\Models\AssetGroup', 'group');
    }

    function property(){
        return $this->hasMany('App\Models\Property', 'category');
    }
    
}
