<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get nhận resquest với phương thức GET.
// Route::post nhận resquest với phương thức POST.
// Route::put nhận resquest với phương thức PUT.
// Route::delete nhận resquest với phương thức DELETE.
// Route::match kết hợp nhiều phương phức như POST,GET,PUT,..
// Route::any nhận tất cả các phương thức.
// Route::group tạo ra các nhóm route.
// Route::controller gọi đến controller tương ứng mà chúng ta tự định.
// Route::resource sử dụng với resource controller.

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return view('hello');
});


//Call controller
Route::get('general','general@index'); //hướng dẫn sử dụng blade template
Route::get('/data', 'data@index'); //demo cách lấy data bằng model
Route::get('pagination','Paginations@index'); //cách sử dụng phân trang

// Route::get('/general', function () {
//     return view('general');
// });

//Truyền dữ liệu qua view
Route::get('/general/{ten}', function ($ten) {
    return view('general',['ten' => $ten]);
});

//Truyền tham số cho router
Route::get('a/{name}/{age}','homecontroller@index')->where(['name'=>'[a-zA-Z]+','age'=>'[0-9]+']);

//pretty url pagination đang sửa dở
Route::get('/pagination/page/{page_number?}', function($page_number=1){
    /*$per_page = 1;
    City::resolveConnection()->getPaginator()->setCurrentPage($page_number);
    $users = City::orderBy('name', 'desc')->paginate($per_page);
    echo '<pre>';
    print_r( $users );
    echo '</pre>';*/
    echo $page_number;
    //exit;
    $users = DB::table('city')->paginate(15);
	// $users = DB::table('users')->simplePaginate(15);
	$users = City::paginate(15);
    return View::make('hello')->with('hello', $users);
});

/*Route::get('/articles/page/{page_number?}', function($page_number=1){
    $per_page = 1;
    Articles::resolveConnection()->getPaginator()->setCurrentPage($page_number);
    $articles = Articles::orderBy('created_at', 'desc')->paginate($per_page);
    return View::make('pages/articles')->with('articles', $articles);
});*/

Route::get('/vue', function () {
    return view('testvujs');
});

Route::resource('sanpham', 'SanphamController');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/', function () {
    return view('laravue');
});
Route::prefix('api')->group(function() {
    Route::resource('tasks', 'TaskController');
});