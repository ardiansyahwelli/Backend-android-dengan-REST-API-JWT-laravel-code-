<?php

namespace App\Api\V1\Controllers;

use JWTAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;

class ActivityController extends Controller
{

    use Helpers;

    public function index(Request $request){

      $device_id = $request->all('device_id');

      $getActivity = DB::table('0_project_activities_vehicle_used')
                        ->select('device_id')
                        ->where('device_id', $request->device_id)
                        ->get();

      if(!empty($getActivity)){
        return $getActivity;
      } else {
        return ('Please check againt data not found.?');
      }
    }
//------------------------------------------------------------------------------


/*
 * Post Activity with file upload
 */
    public function postactivity (Request $request) {

        /*
         * Get validations Activity
         */
        $activityValidation = ['device_id' => 'required',
                               'asset_id' => 'required',
                               'file_path' => 'required',
                             ];

        $activityMessages = [
            'required' => 'The :attribute field is required.'
        ];

        $this->validate($request, $activityValidation, $activityMessages);
        // End

        if ($request->hasFile('file_path')) 
          {
            $file = array('file_path' =>  $request->file('file_path'));
            $destinationPath = 'upload';
            $extension =  $request->file('file_path')->getClientOriginalExtension();
            $get_idImages = rand(11111,99999).'.'.$extension;
            $request->file('file_path')->move($destinationPath, $get_idImages);
          }
                
            $request  = DB::table('0_project_activities_vehicle_used')
                        ->insert(['device_id' => $request->input('device_id'),
                                  'asset_id' => $request->input('asset_id'),
                                  'description' => $request->input('description'),
                                  'lat' => $request->input('lat'),
                                  'lng' => $request->input('lng'),
                                  'file_path' => $get_idImages
                                ]);

            if($request == $request){
                return ('Added new activity successfull.!');
              } else {
                return ('Added new activity failed.?');
              }
          }
//------------------------------------------------------------------------------
/*

    public function post(Request $request){

    $activityValidation = ['device_id' => 'required',
                             'asset_id' => 'required',
                            ];

    $activityMessages = [
        'required' => 'The :attribute field is required.'
    ];

    $this->validate($request, $activityValidation, $activityMessages);

    $request  = DB::table('0_project_activities_vehicle_used')
                    ->insert(['device_id' => $request->input('device_id'),
                              'asset_id' => $request->input('asset_id'),
                              'description' => $request->input('description'),
                              'lat' => $request->input('lat'),
                              'lng' => $request->input('lng'),
                              'file_path' => $request->input('file_path')
                              ]);

    if($request == $request){
      return ('Added new activity successfull.!');
    } else {
      return ('Added new activity failed.?');
    }
  }
  */
//------------------------------------------------------------------------------


    public function show(Request $request){

      $device_id = $request->all('device_id');

      $getActivity = DB::table('0_project_activities_vehicle_used')
                        ->select('device_id', 'tran_date', 'asset_id', 'description', 'lat', 'lng', 'file_path')
                        ->where('device_id', $request->device_id)
                        ->get();

      if(!empty($getActivity)){
        return $getActivity;
      } else {
        return ('Please check againt data not found.?');
      }
    }
//------------------------------------------------------------------------------
}
