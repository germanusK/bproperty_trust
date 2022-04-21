<?php

namespace App\Http\Controllers;

use App\Models\Property as PropertyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Strings;


class Property extends Controller
{
    //store an instance of a given property

    function store(Request $request){
        // try {
            //code...
            return $request->data;
            $validator = Validator::make($request->all(),
                [
                    'name'=>'required',
                    'category'=>'required',
                    'price'=>'required',
                    'grade'=>'required',
                    'images'=>'required',
                    'images[*]'=>'mimes:jpg,png,jpeg,gif'
                ]
                );    
            if($validator->fails()){
                return $validator->errors()->getMessages();}
            $images_array = [];
            // store or move images
            foreach ( $request->images as $key=>$file) {
                # code...
                $name = Strings::normalize(base64_encode($request->getClientIp()).time().random_int(100000, 999999).'.'.$file->getClientOriginalExtension());
                $file->move(storage_path().'/uploads/images', $name);
                array_push($images_array, str_replace("\\", "", '/uploads/images/'.$name, ));
            }
            
            $data = $request->all();
            $data['images'] = json_encode($images_array);
            
            $instance = new PropertyModel();
            $instance->fill($data);
            if($instance->save()){
                $arr = array();
                $instance->images = json_decode($instance->images);

                foreach ($instance->images as $key => $value) {
                    # code...
                    $arr[] = URL::to('/').'/api'.$value;
                }
                $instance->images = $arr;
                return response($instance);
            }
            return response('Failure saving data. Try again later.', 405);
        
    }

    // read all property instances
    function get(){
        $data = DB::table('properties')->get()->shuffle();
        foreach ($data as $key => $value) {
            # code...
            // $value->images = json_decode(str_replace(["\\", "\""], "", $value->images));
            $value->images = json_decode($value->images);
            foreach ($value->images as $key1 => $value1) {
                # code...
                $value->images[$key1] = URL::to('/').'/api'.$value->images[$key1];
            }

        }
        return $data;
    }

    // read by id
    function getById(Request $request){
        $data = DB::table('properties')->find($request->id);
       
        $data->images = json_decode($data->images);
        foreach ($data->images as $key => $value) {
            # code...
            $data->images[$key] = URL::to('/').'/api'.$data->images[$key];
        }
        return $data;
    }


    // load image
    function getImage(Request $request){
        // return "found image here";
        return response()->file(storage_path().'/uploads/images/'.$request->file_name);
    }

    // get latest trending property
    function getLatestTrending(){
        $data = DB::table('properties')->orderByDesc('grade')->orderByDesc('created_at');
        if (count($data->get())>=50) {
            # code...
            $data = $data->take(50);
        }

        $data = $data->inRandomOrder()->get();

        foreach ($data as $key => $value) {
            # code...
            // $value->images = json_decode(str_replace(["\\", "\""], "", $value->images));
            $value->images = json_decode($value->images);
            foreach ($value->images as $key1 => $value1) {
                # code...
                $value->images[$key1] = URL::to('/').'/api'.$value->images[$key1];
            }

        }
        return $data;
    }

    // get related property
    function getRelatedProperty(Request $request){
        $check = DB::table('properties')->where('id', '=', $request->id)->get();
        
        if ($check->isNotEmpty()) {
            # code...
            $data = DB::table('properties')->where('group', '=', $check[0]->group)
                    ->where('category', '=', $check[0]->category)
                    ->where('grade', '=', $check[0]->grade)
                    ->where('id', '!=', $request->id)
                    ->get();

            foreach ($data as $key => $value) {
                # code...
                // $value->images = json_decode(str_replace(["\\", "\""], "", $value->images));
                $value->images = json_decode($value->images);
                foreach ($value->images as $key1 => $value1) {
                    # code...
                    $value->images[$key1] = URL::to('/').'/api'.$value->images[$key1];
                }
    
            }
            return $data;
        }
    }

    // custom read query
    function customGet(Request $request){
        $query_params = $request->query->all();
        $querybuilder = DB::table('properties');
        foreach ($query_params as $key => $value) {
            # code...
            $querybuilder = $querybuilder->where($key, '=', $value);
        }
        $data = $querybuilder->get();
        foreach ($data as $key => $value) {
            # code...
            // $value->images = json_decode(str_replace(["\\", "\""], "", $value->images));
            $value->images = json_decode($value->images);
            foreach ($value->images as $key1 => $value1) {
                # code...
                $value->images[$key1] = URL::to('/').'/api'.$value->images[$key1];
            }

        }
        return $data;
    }

    function genericLatest(Request $request){
        $query_params = $request->query->all();
        $querybuilder = DB::table('properties');
        Log::alert($query_params);
        foreach ($query_params as $key => $value) {
            # code...
            $querybuilder = $querybuilder->where($key, '=', $value);
        }
        $querybuilder = $querybuilder->orderByDesc('grade')->orderByDesc('created_at');
        $data = $querybuilder->get();
        foreach ($data as $key => $value) {
            # code...
            // $value->images = json_decode(str_replace(["\\", "\""], "", $value->images));
            $value->images = json_decode($value->images);
            foreach ($value->images as $key1 => $value1) {
                # code...
                $value->images[$key1] = URL::to('/').'/api'.$value->images[$key1];
            }

        }
        return $data;
    }

    // get count for all
    function countAll(){
        return count(DB::table('properties')->get());
    }

    // get item count for particular item group
    function customCount(Request $request){
        $query_params = $request->query->all();
        $querybuilder = DB::table('properties');
        foreach ($query_params as $key => $value) {
            # code...
            $querybuilder = $querybuilder->where($key, '=', $value);
        }
        $data = $querybuilder->get();
        return count($data);
    }

    function update(Request $request){
        $validator = Validator::make($request->all(),
            [
                'name'=>'required',
                'category'=>'required',
                'images'=>'required',
                'grade'=>'required',
                'price'=>'required'
            ]
            );

        if($validator->fails())
            return $validator->errors()->getMessages();

        $instance = DB::table('properties')->find($request->id);
        if($instance->update($request->all())){
            foreach ($$instance->images as $key => $value) {
                # code...
                $value = URL::to('/').'/api'.$value;
            }
            return $instance;
        }
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
        $data = DB::table('properties')->where('id', '=', $request->id)->get(); 
        foreach ($data as $key => $value) {
            # code...
            Storage::delete(json_decode($value->images));
            DB::table('properties')->delete($value->id);
        }
        
        return response($data);
    }

}
