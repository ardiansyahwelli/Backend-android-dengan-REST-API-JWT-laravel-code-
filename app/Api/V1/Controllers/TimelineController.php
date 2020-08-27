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

class TimelineController extends Controller
{

    use Helpers;

    public function index(Request $request){

      $getTimeline = DB::table('0_timeline', '0_users_api', '0_hrm_employees')
                        ->join('0_users_api', '0_timeline.id', '=', '0_users_api.id')
                        ->join('0_hrm_employees', '0_timeline.id', '=', '0_hrm_employees.id')
                        /*
                         * Get tables per item
                         */
                        ->select('0_timeline.id', 
                                 '0_users_api.device_id', 
                                 '0_users_api.nik', 
                                 '0_users_api.emp_no', 
                                 '0_hrm_employees.emp_id',
                                 '0_hrm_employees.name')
                        ->get();

      if(!empty($getTimeline)){
        return $getTimeline;
      } else {
        return ('Please check againt data not found.?');
      }
    }
//------------------------------------------------------------------------------

    public function show(Request $request){

      $getTimelinecount = DB::table('0_timeline')
                        ->join('0_timeline_like', '0_timeline.id', '=', '0_timeline_like.id')
                        ->join('0_timeline_view', '0_timeline.id', '=', '0_timeline_view.id')
                        ->join('0_users_api', '0_timeline.id', '=', '0_users_api.id')
                        ->join('0_hrm_employees', '0_timeline.id', '=', '0_hrm_employees.id')
                        ->select('0_timeline.id', 
                                 '0_timeline_like.user_id', 
                                 '0_timeline_view.timeline_id', 
                                 '0_users_api.nik', 
                                 '0_hrm_employees.emp_id')
                        ->get();

      if(!empty($getTimelinecount)){
        return $getTimelinecount;
      } else {
        return ('Please check againt data not found.?');
      }
    }
//------------------------------------------------------------------------------


    public function post(Request $request){

      $assetValidations = [
        'timeline_id' => 'required',
        'user_id' => 'required',
      ];

      $assetMessages = [
          'required' => 'The :attribute field is required.'
      ];

      $this->validate($request, $assetValidations, $assetMessages);

      $getPost = DB::table('0_timeline_like')->insert(['timeline_id' => $request->input('timeline_id'), 
                                                       'user_id'=> $request->input('user_id')
                                                     ]);

      if($getPost == $getPost){
        return ('Your like successfull.!');
      } else {
        return ("Your don't get like this.?");
      }
    }
//------------------------------------------------------------------------------
}
