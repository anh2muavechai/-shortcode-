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
    	$imageUrl = 'abcd.jpg';
    	$errorMsg = 'loi roi';
    	return view('testpackage::upload', ['imageUrl' => $imageUrl, 'errorMsg' => $errorMsg]);
    	//testpackage: tên package
    	//upload : tên view
    }
}