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

class ProjectController extends Controller
{

    use Helpers;

    public function index(Request $request){

      $project_no = $request->all('project_no');

      $projectMain = DB::table('0_projects')
                   ->select('project_no', 'code', 'name')
                   ->where('project_no', $request->project_no)
                   ->get();

      if(!empty($projectMain)){
        return $projectMain;
      } else {
        return "Sorry project code not found in system.?";
      }
    }
//------------------------------------------------------------------------------


    public function show(Request $request){

      $client_id = $request->all('client_id');

      $getProject = DB::table('0_projects')
                        ->select('client_id', 
                                 'division_id', 
                                 'project_no', 
                                 'code', 
                                 'name', 
                                 'name_external', 
                                 'description')
                        ->get();

      if(!empty($getProject)){
        return $getProject;
      } else {
        return ('Please check againt data not found.?');
      }
    }
//------------------------------------------------------------------------------


/*
    public function delete(Request $request){

      $delete = DB::table('0_projects')
                ->select('project_no')
                ->where('project_no', $request->project_no)
                ->delete();

      if(!empty($delete)){
        return "Delete project successfull.!";
      } else {
        return "Delete Project unsuccessfull.?";
      }
    }
*/
//------------------------------------------------------------------------------
}
