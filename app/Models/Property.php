<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Property extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'category',
        'description',
        'images',
        'grade',
        'price'
    ];

    protected $casts = [
        'created_at'=>'datetime',
        'updated_at'=>'datetime'
    ];

    protected $table = "properties";

    function asset_category(){
        return $this->belongsTo('App\Models\AssetCategory', 'category');
    }

    function schedule(){
        return $this->hasMany('App\Models\Schedule', 'asset_id');
    }

    function asset_grade(){
        return $this->belongsTo('App\Models\AssetGrade', 'grade');
    }
}
// 679542286