<?php
	
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

/*
 * This Auth
 */
	$api->post('auth/login', 'App\Api\V1\Controllers\AuthController@login');
	$api->post('auth/signup', 'App\Api\V1\Controllers\AuthController@signup');
	$api->post('auth/recovery', 'App\Api\V1\Controllers\AuthController@recovery');
	$api->post('auth/reset', 'App\Api\V1\Controllers\AuthController@reset');
//------------------------------------------------------------------------------

/*
 * This Asset Registrations Controller Master
 */
  $api->get('asset_req/{id}', 'App\Api\V1\Controllers\AssetRegistrationController@index');
  $api->get('asset_req/show/{id}', 'App\Api\V1\Controllers\AssetRegistrationController@show');
  $api->get('asset_req/get_approval/{approval_status}', 'App\Api\V1\Controllers\AssetRegistrationController@get_approval');

  $api->post('asset_req/post', 'App\Api\V1\Controllers\AssetRegistrationController@post');
  $api->post('asset_req/approval_post', 'App\Api\V1\Controllers\AssetRegistrationController@approval_post');
  
  /*
   * get delete data per ID
   */
  $api->delete('asset_req/delete/{id}', 'App\Api\V1\Controllers\AssetRegistrationController@delete');
//------------------------------------------------------------------------------


/*
 * This Project Controller Master
 */
  $api->get('project/{project_no}', 'App\Api\V1\Controllers\ProjectController@index');
  $api->get('project/show/{id}', 'App\Api\V1\Controllers\ProjectController@show');

  $api->delete('project/delete/{id}', 'App\Api\V1\Controllers\ProjectController@delete');
//------------------------------------------------------------------------------


/*
 * This Asset Controller Master
 */
  $api->get('asset/{id}', 'App\Api\V1\Controllers\AssetController@index');
//------------------------------------------------------------------------------


/*
 * This Activity Controller Master
 */
  $api->get('activity/{device_id}', 'App\Api\V1\Controllers\ActivityController@index');
  $api->get('activity/show/{device_id}', 'App\Api\V1\Controllers\ActivityController@show');

  $api->post('activity/postactivity', 'App\Api\V1\Controllers\ActivityController@postactivity');
//------------------------------------------------------------------------------


/*
 * This Timeline Controller Master
 */
  $api->get('timeline/{id}', 'App\Api\V1\Controllers\TimelineController@index');
  $api->get('timeline/show/{user_id}', 'App\Api\V1\Controllers\TimelineController@show');

  $api->post('timeline/post', 'App\Api\V1\Controllers\TimelineController@post');
//------------------------------------------------------------------------------


	/*
	// example of protected route
	$api->get('protected', ['middleware' => ['api.auth'], function () {		
		return \App\User::all();
    }]);

	// example of free route
	$api->get('free', function() {
		return \App\User::all();
	});
	*/

});
