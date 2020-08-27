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

class AssetController extends Controller
{

    use Helpers;

    public function index(Request $request){

      $group_id = $request->all('group_id');
      
      $Asset = DB::table('0_am_groups')
                        ->select('group_id', 'name')
                        ->get();

      if(!empty($Asset)){
        return $Asset;
      } else {
        return ('Please check againt data not found.?');
      }
    }
//------------------------------------------------------------------------------
}
