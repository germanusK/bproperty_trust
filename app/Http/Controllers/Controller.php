<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function setSenderEmailAddress(Request $request){
        $path = base_path('.env');
        
        if ( file_exists($path) ) {
            # code...
            file_put_contents($path, str_replace('MAIL_FROM_ADDRESS='.$this->laravel['config']['mail.from.address'], 'MAIL_FROM_ADDRESS='.$request->get('email'), file_get_contents($path)));
        }
    }

    function configureMail(Request $request){
        
    }
}