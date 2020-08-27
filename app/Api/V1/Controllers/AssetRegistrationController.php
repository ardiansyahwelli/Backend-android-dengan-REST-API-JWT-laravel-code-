<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use validate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class AssetRegistrationController extends Controller
{

    use Helpers;

    
    public function index(Request $request){

      $id = $request->all('id');
      $assetRegistration = DB::table('0_asset_registration')
                        ->where('id', $request->id)
                        ->get();

      if(!empty($assetRegistration)){
        return $assetRegistration;
      } else {
        return ('Please check againt data not found.?');
      }
    }
//------------------------------------------------------------------------------

    public function show(Request $request){

      $id = $request->id;
      $assetRegistration = DB::table('0_asset_registration')
                           ->where('id', $request->id)
                           ->get();

      if(!empty($assetRegistration)){
        return $assetRegistration;
      } else {
        return ('Sorry data not found in system.?');
      }
    }
//------------------------------------------------------------------------------

    public function post(Request $request){

    /*
     * Get Validation Asset Registration
     */
    $assetValidations = [
        'asset_id' => 'required',
        'device_id' => 'required',
        'asset_type_name' => 'required',
        'asset_group_name' => 'required',
        'project_code' => 'required',
        'file_path' => 'required',
        'remark' => 'required',
        'lat' => 'required',
        'lng' => 'required',
    ];

    $assetMessages = [
        'required' => 'The :attribute field is required.'
    ];

    $this->validate($request, $assetValidations, $assetMessages);
    // END
    
    /*
     * Images Upload
     */
    if ($request->hasFile('file_path')) 
          {
            $file = array('file_path' =>  $request->file('file_path'));
            $destinationPath = 'upload';
            $extension =  $request->file('file_path')->getClientOriginalExtension();
            $get_idImages = rand(11111,99999).'.'.$extension;
            $request->file('file_path')->move($destinationPath, $get_idImages);
          }

    $request  = DB::table('0_asset_registration')
                ->insert(['asset_id' => $request->input('asset_id'),
                          'device_id' => $request->input('device_id'),
                          'asset_type_name' => $request->input('asset_type_name'),
                          'asset_group_name'=> $request->input('asset_group_name'),
                          'project_code' => $request->input('project_code'),
                          'file_path' => $get_idImages,
                          'remark' => $request->input('remark'),
                          'lat'=> $request->input('lat'),
                          'lng'=> $request->input('lng')
                         ]);

    if($request == $request){
      return ('Added new asset registration successfull.!');
    } else {
      return ('Added new asset registration failed.?');
    }
  }
//------------------------------------------------------------------------------

        public function approval_post(Request $request){

    $assetValidations = [
        'asset_type_name' => 'required',
        'device_id' => 'required',
        'approval_status' => 'required',
    ];

    $assetMessages = [
        'required' => 'The :attribute field is required.'
    ];

    $this->validate($request, $assetValidations, $assetMessages);

    $request  = DB::table('0_asset_registration')
                ->where('id', $request->id)
                ->update(['id' => $request->input('id'),
                          'asset_type_name' => $request->input('asset_type_name'),
                          'device_id' => $request->input('device_id'),
                          'approval_status' => $request->input('approval_status'),
                          'update_history' => $request->input('update_history')
                         ]);

    if($request == 1){
      return ('Approval asset successfull.!');
    } else {
      return ('Approval asset failed.?');
    }
  }
//------------------------------------------------------------------------------

    public function get_approval(Request $request){

      $approval_status = $request->all('approval_status');

      $getApproval = DB::table('0_asset_registration')
                     ->join('0_users_api', '0_asset_registration.id', '=', '0_users_api.id')
                     ->join('0_hrm_employees', '0_asset_registration.id', '=', '0_hrm_employees.id')
                     ->leftJoin('0_projects', '0_asset_registration.id', '=', '0_projects.project_no')
                     ->leftJoin('0_members', '0_asset_registration.id', '=', '0_members.person_id')
                     ->select('0_asset_registration.approval_status',
                              '0_users_api.device_id',
                              '0_hrm_employees.emp_id',
                              '0_hrm_employees.emp_new_id',
                              '0_hrm_employees.name',
                              '0_projects.project_no',
                              '0_projects.code',
                              '0_members.person_id')
                     ->where('approval_status', $request->approval_status)
                     ->get();

      if($getApproval == $getApproval){
        return $getApproval;
      } else {
        return ('Sorry data not found in system.?');
      }
    }
//------------------------------------------------------------------------------

    public function delete(Request $request){

      $delete = DB::table('0_asset_registration')
                ->where('id', $request->id)
                ->delete();

      if(!empty($delete)){
        return "Delete asset registration successfull.!";
      } else {
        return "Sorry data not found in system. ?";
      }
    }
//------------------------------------------------------------------------------
}

