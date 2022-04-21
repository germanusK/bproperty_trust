<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetGrade extends Model
{
    use HasFactory;

    protected $fillable = ['grade', 'rank'];

    protected $table = "asset_grades";
}
