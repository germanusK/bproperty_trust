<?php

namespace App\Http\Controllers;

use App\Models\Property as PropertyModel;
use Error;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Strings;
use Prophecy\Util\StringUtil;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile as FileUploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\Mime\Encoder\Base64Encoder;

class Property extends Controller
{
    //store an instance of a given property

    function store(Request $request){
        // try {
            //code...
            $validator = Validator::make($request->all(),
                [
                    'name'=>'required',
                    'group'=>'required',
                    'category'=>'required',
                    'images'=>'required|array',
                    'grade'=>'required',
                    'price'=>'required'
                ]
                );
            $image_validator = Validator::make($request->all()['images'], ['image'=>'mimes:jpg,png,jpeg,gif']);
    
            if($validator->fails())
                return $validator->errors()->getMessages();
            if($image_validator->fails())
                return $image_validator->errors()->getMessages();
            
            $images_array = [];
            // store or move images
            foreach ( $request->file('images') as $file) {
                # code...
                $name = Strings::normalize(base64_encode($request->getClientIp()).time().pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).random_int(100000, 999999).'.'.$file->getClientOriginalExtension());
                $file->move(storage_path().'/uploads/images', $name);
                array_push($images_array, str_replace("\\", "", URL::to('/').'/api/uploads/images/'.$name, ));
            }
    
            $data = $request->all();
            $data['images'] = json_encode($images_array);
    
            $instance = new PropertyModel();
            $instance->fill($data);
            if($instance->save())
                return $instance;
            return response('Failure saving data. Try again later.', 405);
        // } catch (\Throwable $th) {
        //     response($th->__toString());
        // }
    }

    // read all property instances
    function get(){
        return DB::table('property')->get();
    }

    // read by id
    function getById(Request $request){
        return DB::table('property')->find($request->id);
    }


    // load image
    function getImahge(Request $request){
        return file(storage_path().'/uploads/images/'.$request->file_name);
    }

    // custom read query
    function customGet(Request $request){
        $query_params = $request->query;
        $querybuilder = DB::table('property');
        foreach ($query_params as $key => $value) {
            # code...
            $querybuilder = $querybuilder->where($key, '=', $value);
        }
        return $querybuilder->get();
    }

    // get count for all
    function countAll(){
        return count(DB::table('property')->get());
    }

    // get item count for particular item group
    function customCount(Request $request){
        $query_params = $request->query();
        $querybuilder = DB::table('property');
        foreach ($query_params as $key => $value) {
            # code...
            @$querybuilder = $querybuilder->where($key, '=', $value);
        }
        return count($querybuilder->get());
    }

    function update(Request $request){
        $validator = Validator::make($request->all(),
            [
                'name'=>'required',
                'group'=>'required',
                'category'=>'required',
                'images'=>'required',
                'grade'=>'required',
                'price'=>'required'
            ]
            );

        if($validator->fails())
            return $validator->errors()->getMessages();

        $instance = DB::table('property')->find($request->id);
        if($instance->update($request->all()))
            return $instance;
        return response('Failure updating item. Try again later.', 405);
    }

   
    function patch(Request $request){
        $item = DB::table('property')->find($request->get('id'));
        $update = $request->all();
        // return $update;
        foreach ($update as $key => $value) {
            # code...
            $item[$key] = $value;
        }
        $new_item = (new PropertyModel())->fill($item);
        $new_item->save();
        return $new_item;
    }

    // delete item by id
    function delete(Request $request){
        DB::table('property')->delete($request->id);
    }

}
