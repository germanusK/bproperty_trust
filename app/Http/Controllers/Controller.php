<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use App\Models\AssetGrade;
use App\Models\AssetGroup;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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


    // SEARCH 
    function search(){}

    // Group management
    function getGroups(){
        return DB::table('asset_groups')->get(['id', 'group']);
    }
    function deleteGroup($id)
    {
        # code...
        return DB::table('asset_groups')->delete($id);
    }
    function createGroup(Request $request){
        $valid = Validator::make($request->all(), [
            'group'=>'required'
        ]);

        if ($valid->fails()) {
            # code...
            throw new Exception($valid->errors(), 400);
        }

        $instance = new AssetGroup($request->all());
        return $instance->saveOrFail();
    }

    function updateGroup($id, Request $request){
        $valid = Validator::make($request->all(), [
            'group'=>'required'
        ]);

        if ($valid->fails()) {
            # code...
            throw new Exception($valid->errors(), 400);
        }

        $instance = DB::table('asset_groups')->find($id)->updateOrInsert($request->all());
        return response($instance);
    }

    // Category management
    function getCategories()
    {
        # code...
        return DB::table('asset_categories')->get();
    }
    function getCategoriesByGroup(Request $request){
        return DB::table('asset_categories')->where('group', '=', $request->group)->get();
    }
    function createCategory(Request $request){
        // return request()->all();
        $valid = Validator::make($request->all(), [
            'group'=>'required',
            'category'=>'required'
        ]);
        if ($valid->fails()) {
            # code...
            return response($valid->errors(), 400);
        }

        $group = DB::table('asset_groups')->find($request->group);
        return (new AssetCategory(['group'=>$group->id, 'category'=>$request->category]))->saveOrFail();
    }
    function updateCategory($id, Request $request){
        $validator = Validator::make($request->all(), [
            'group'=>'required',
            'category'=>'required'
        ]);
        if ($validator->fails()) {
            # code...
            return response($validator->errors(), 400);
        }
        DB::table('asset_categories')->find($id)->update($request->all());
    }
    function deleteCategory($id){
        DB::table('asset_categories')->delete($id);
    }

    // Grade management
    function createGrade(Request $request){
        $validator = Validator::make($request->all(), [
            'grade'=>'required'
        ]);
        if ($validator->fails()) {
            # code...
            return response($validator->errors(), 400);
        }
        return (new AssetGrade($request->all()))->saveOrFail();
    }
    function getGrades(){
        return DB::table('asset_grades')->get(['id', 'grade']);
    }
    function updateGrade($id, Request $request){
        $valid = Validator::make($request->all(), [
            'grade'=>'required'
        ]);
        if ($valid->fails()) {
            # code...
            return response($valid->errors(), 400);
        }
        return DB::table('asset_grades')->find($id)->update($request->all());
    }
    function deleteGrade($id){
        return DB::table('asset_grades')->delete($id);
    }
}