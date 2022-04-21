<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'contact'
    ];

    protected $table = "customers";

    function order(){
        return $this->hasMany('App\Models\Message', 'placed_id');
    }
    function schedule(){
        return $this->hasMany('App\Models\Schedule', 'customer_id');
    }
    
}
