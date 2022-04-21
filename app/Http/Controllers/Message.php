<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Message as MessageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mockery\Undefined;
use Throwable;

class Message extends Controller
{

    function createMessage(Request $request)
    {
        try{# code...
        $validator = Validator::make($request->all(), [
            'type'=>'required',
            'message'=>'required',
            'name'=>'required',
            'email'=>'required',
        ]);
        if ($validator->fails()) {
            # code...
            return response($validator->errors(), 400);
        }
        $message = new MessageModel();
        $customer = new Customer();
        $cstm = ['name'=>$request->name, 'email'=>$request->email, 'contact'=>($request->get('contact', null))];
        $customer->fill($cstm);
        $customerId = $customer->save()? $customer->id: null;
        $msg = ['type'=>$request->type, 'message'=>$request->message, 'customer_id'=>$customerId];
        $message->fill($msg);
        return $message->save()? response($message): response()->setStatusCode(400); 
        }
        catch(Throwable $th){
            return response($th->getMessage(), $th->getCode());
        }
    }

    function getMessages()
    {
        # code...
        return DB::table('messages')->get();
    }

    function genericGet(Request $request)
    {
        # code...
        $builder = DB::table('messages');
        if ($request->has('type')) {
            # code...
            $builder = $builder->where('type', '=', $request->type);
        }
        if ($request->has('customer_id')) {
            # code...
            $builder = $builder->where('customer_id', '=', $request->customer_id);
        }
        return $builder->get();
    }

    function getById(Request $request){
        return DB::table('messages')->find($request->id);
    }

    function setRead(Request $request){
        $msg = DB::table('messages')->find($request->id);
        $msg->status = true;
        $msg->update($msg);
    }

    function deleteMessage(Request $request)
    {
        # code...
        return DB::table('messages')->delete($request->id);
    }
}
