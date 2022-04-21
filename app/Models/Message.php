<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Message extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'type',
        'description',
        'placed_by',
        'status'
    ];

    protected $table = 'messages';

    function asset_category(){
        return $this->belongsTo('App\Models\AssetCategory', 'category');
    }
    function customer(){
        return $this->belongsTo('App\Models\Customer', 'placed_by');
    }
}
