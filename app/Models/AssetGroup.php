<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetGroup extends Model
{
    use HasFactory;

    protected $fillable = ['group'];

    protected $table = "asset_groups";

    function asset_category()
    {
        # code...
        return $this->hasMany('App\Models\AssetCategory', 'group');
    }
}
