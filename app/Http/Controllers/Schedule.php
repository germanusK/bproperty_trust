<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Schedule as ModelsSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class Schedule extends Controller
{
    //store an schedule
    function store(Request $request){
        try {
            //code...
            // general check
            $validate = Validator::make($request->all(), [
                'asset_id'=>'required',
                'due_date'=>'required|format:Y-m-d H-i-s',
                'customer_id'=>'required|unsignedBigInteger',
            ]);
            $validator = Validator::make($request->all(), [
                'name'=>'required',
                'email'=>'required',
                'due_date'=>'required:timestamp',
                'asset_id'=>'required'
            ]);
            
            if ($validator->fails())
            return $validator->errors()->getMessages();

            // validate due_date
            $due_date = (new Date())->createFromTimestampUTC($request->get('due_date'));
            switch ($due_date->dayOfWeek) {
                case 0|1|2|3|4:
                    # code...
                    if ($due_date->hour <=8 || $due_date->hour >= 17) {
                        # code...
                        throw new Exception("Time not allowed. Schedules from Monday to Friday are only allowed between 8am and 5pm", 403);
                    }
                    break;

                case 5:
                    if ($due_date->hour <=8 || $due_date->hour >= 12) {
                        # code...
                        throw new Exception("Time not allowed. Schedules on Saturday are only allowed between 8am and 12pm", 403);
                    }
                    break;
                case 6:
                    throw new Exception("schedules not allowed on Sundays", 403);
                    break;
                default:
                    # code...
                    throw new Exception("Bad input. Invalid day", 403);
                    break;
            }
            // if data is valid, save schedule and notify user by email.
            // extract and create user
            $customerData = ['name'=>$request->name, 'email'=>$request->email, 'contact'=>$request->has('contact')?$request->contact:null];
            $customerInstance = new Customer($customerData);
            $customerInstance->saveOrFail();

            // construct and save schedule
            $scheduleData = ['asset_id'=>$request->asset_id, 'customer_id'=>$customerInstance->id, 'due_date'=>$request->due_date];
            $instance = new ModelsSchedule();
            $instance->fill($scheduleData);
            $instance->saveOrFail();

            // notify user
            Http::post('/api/notication/'.$customerInstance->email, [
                'heading'=>'Schedule Notification',
                'message'=>'You just booked a schedule with BPropertyTrust to view property on the'.$instance->due_date.'Click the link below to confirm schedule.
                    <br><a href="" style="margin-inline: auto; margin-block: 1rem; border: 1px solid black; border-radius: 3rem; padding: 1rem 3rem; background-color: rgba(0, 0, 0, 0.2); font-size: 2rem; font-weight: bold;">Confirm Schedule<a/>'
            ]);

            return [$instance, $customerInstance];
        } catch (\Throwable $th) {
            return response($th->getMessage(), $th->getCode());
        }
    }

    // get all schedules
    function getAll(){
        return DB::table('schedules')->get();
    }

    // get schedule by id
    function getById(Request $request){
        return DB::table('schedules')->find($request->get('id'));
    }

    // get schedule by any attribute(s)
    function customGet(Request $request){
        // initialise query builder;
        $builder = DB::table('schedules');

        $query_params_iterator = $request->query->getIterator();
        foreach ($query_params_iterator as $key => $value) {
            # code...
            $builder = $builder->where($key, '=', $value);
        }
        return $builder->get();
    }

    // update entire schedule
    // @request body format: {id, update{}}
    function update(Request $request){
         // general check
         $validate = Validator::make($request->all()['update'], [
            'asset_id'=>'required',
            'due_date'=>'required|format:Y-m-d H-i-s',
            'customer_id'=>'required|unsignedBigInteger',
            'status'=>'required'
        ]);
        
        if ($validate->fails())
        return $validate->errors()->getMessages();

        // validate due_date
        $due_date = (new Date())->createFromTimestampUTC($request->get('due_date'));
        switch ($due_date->dayOfWeek) {
            case 0|1|2|3|4:
                # code...
                if ($due_date->hour <=8 || $due_date->hour >= 17) {
                    # code...
                    throw new Exception("Time not allowed. Schedules from Monday to Friday are only allowed between 8am and 5pm", 403);
                }
                break;

            case 5:
                if ($due_date->hour <=8 || $due_date->hour >= 12) {
                    # code...
                    throw new Exception("Time not allowed. Schedules on Saturday are only allowed between 8am and 12pm", 403);
                }
                break;
            case 6:
                throw new Exception("schedules not allowed on Sundays", 403);
                break;
            default:
                # code...
                throw new Exception("Bad input. Invalid day", 403);
                break;
        }
        
        $instance = new ModelsSchedule();
        $instance->fill($request->all()['update']);
        $instance->id = $request->get('id');
        $instance->save();
        return $instance;
    }

    // patch up a schedule
    // @request body format: {id, patch{}}
    function patch(Request $request){

        // general check
        $validate = Validator::make($request->all()['patch'], [
            'due_date'=>'format:Y-m-d H-i-s',
            'customer_id'=>'unsignedBigInteger',
        ]);
        
        if ($validate->fails())
        return $validate->errors()->getMessages();

        // validate due_date
        if ($request->get('patch')['due_date'] != (null|"")) {
            # code...
            $due_date = (new Date())->createFromTimestampUTC($request->get('patch')['due_date']);
            switch ($due_date->dayOfWeek) {
                case 0|1|2|3|4:
                    # code...
                    if ($due_date->hour <=8 || $due_date->hour >= 17) {
                        # code...
                        throw new Exception("Time not allowed. Schedules from Monday to Friday are only allowed between 8am and 5pm", 403);
                    }
                    break;
    
                case 5:
                    if ($due_date->hour <=8 || $due_date->hour >= 12) {
                        # code...
                        throw new Exception("Time not allowed. Schedules on Saturday are only allowed between 8am and 12pm", 403);
                    }
                    break;
                case 6:
                    throw new Exception("schedules not allowed on Sundays", 403);
                    break;
                default:
                    # code...
                    throw new Exception("Bad input. Invalid day", 403);
                    break;
            }
        }

        $patch = $request->all()['patch'];
        $item = DB::table('schedules')->find($request->get('id'))->get();
        foreach ($patch as $key => $value) {
            # code...
            $item[$key] = $value;
        }

    }

    // delete schedule by id
    function deleteById(Request $request){
        $item = DB::table('schedules')->find($request->get('id'));
        $item->delete();
        return $item;
    }
}
