<?php

namespace App\Http\Controllers;

use App\User;
use App\City;
use DB;
use App\Http\Controllers\Controller;

class Paginations extends Controller
{
    public static function index(){
    	// return view('hello',array('ten'=>'hung'));
    	// var_dump(DB::connection()->getDatabaseName());
    	// $data = DB::select('select * from city')->paginate(10);
    	// echo '<pre>';
    	// print_r( $data );
    	// echo '</pre>';
    	//exit;
    	//   	$city = new City();
    	//   	$data = $city::all();
    	//   	echo '<pre>';
    	//   	var_dump( $data );
    	//   	echo '</pre>';
    	// die();
		$users = DB::table('city')->paginate(15);
		// $users = DB::table('users')->simplePaginate(15);
		$users = City::paginate(15);

        return view('paginations', ['users' => $users]);
    }
}