<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SimpleAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$laravel = app();
		$version = $laravel::VERSION;
		echo 'Laravel: '.$version;
    	return view('general');
    }
}