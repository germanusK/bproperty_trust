<?php

namespace App\Http\Controllers;

use App\Models\Customer as ModelsCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;

class Customer extends Controller
{
    //store fresh submited customer
    public function store(Request $request){
        $validate = FacadesValidator::make($request->all(), [
            'name'=>'required|min:2',
            'email'=>'required|email',
        ]);

        if ($validate->fails()) {
            # code...
            return $validate->errors();
        }
        $instance = new ModelsCustomer();
        $instance->fill($request->all());
        if ($instance->save()) {
            # code...
            return $instance;
        }
        else{
            return response("Error registering user. Try again later.");
        }
    }

    // get all customer models
    function getAll(){
        return DB::table('customer')->get();
    }

    // get customer by id
    function getById(Request $request){
        return DB::table('customer')->find($request->id);
    }

    // get custom customer models
    function customGet(Request $request){
        $query_params = $request->query;
        $querybuilder = DB::table('customer');
        foreach ($query_params as $key => $value) {
            # code...
            $querybuilder = $querybuilder->where($key, '=', $value);
        }
        return $querybuilder->get();
    } 

}
