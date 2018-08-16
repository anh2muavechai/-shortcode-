<?php
namespace testpackage\test\Controllers;

use App\Http\Controllers\Controller;

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