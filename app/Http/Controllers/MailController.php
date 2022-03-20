<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyMail;
use Exception;
use Nette\Utils\Strings;

class MailController extends Controller
{
    //
    function notify(Request $request){
        
        // return $request->all()['message'];
        try {
            //code...
            Mail::to($request->all()['recipient'])->send(new NotifyMail($request->all()));
             if (Mail::failures()) {
                 # code...
                 return response("Sorry!Please try again later", 403);
             }else{
                 return response("Great! Notification sent");
             }
        } catch (\Throwable $e) {
            //throw $th;
            return response($e->getMessage(), $e->getCode());
        }
         
    }

    function configure(Request $request){
        $path = base_path(".env");
        if (file_exists($path)) {
            # get config data from request
            $envars = $request->all();
            foreach ($envars as $key => $value) {
                # save each key/value pair in turn. If key does not exist, it is created.
                if ( Strings::contains(file_get_contents($path), Strings::upper($key))) {
                    # code...
                    file_put_contents($path, str_replace(Strings::upper($key).'='.env(Strings::upper($key)), Strings::upper($key).'='.$value, file_get_contents($path)));
                } else {
                    # code...
                    file_put_contents($path,  Strings::upper($key).'='.$value);
                }
            }
            return response("Environment updated successfully");
        }
        return response("Sorry! Environment file not found.", 500);
    }
}
