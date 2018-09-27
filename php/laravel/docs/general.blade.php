@extends('layout')
@section('title') Hello day la title @endsection

@section('content')

	Cài đặt laravel:
	- nên cài đặt github sẽ có công cụ chạy terminal sẵn luôn
	- cài đặt composer : chạy file setup <br>
	- cài đặt php artisan : composer install<br>
	- chạy lệnh bên dưới để cài đặt project: <br>
		cd C://<br>
		cd xampp/htdocs<br>
		composer create-project --prefer-dist laravel/laravel first_project "5.4.*"<br>
--------------------------------------------------------------------------<br>
	- cấu hình: database trong config/database.php nếu local thì sử dụng file. env ở root <br>
	- Controllers nằm trong thư mục app/http/controllers <br>
	- Model trong file app <br>
	- View nằm trong thư mục resources/views<br>
	- Router nằm trong thư mục routes/web.php (xem file web.php để sử dụng routes) <br>
--------------------------------------------------------------
<i><br><b>Cách sử dụng blade template </b></i> <br>

	- cú pháp kế thừa 1 template đã được định sẵn @ extends('layout') : layout là file template đã tạo layout.blade.php <br>
	- ta dùng cú pháp @ section('bien da dinh truoc') and @ endsection, @ yield để thay đổi nội dung động trong file layout<br>

	<br>
	- sử dụng cú pháp @{{ $biến }} để thay cho echo <br>
	- nếu thêm dấu @ trước @{{ }} thì sẽ show dạng raw test vd @{{ $biến }} <br>
	- có thể set giá trị mặc địch cho echo vd: @{{ $ten or 'Ten' }} nếu có $tên thì show $ten ngược lại là Ten vd:<br>
	@{{ $name or 'Default' }} tương đương @{{ isset($name) ? $name : 'Default' }}

	{{ $post->author->name ?? '' }}
	<br><br>

	vd:((view source code để hiểu chi tiết)) <br>
	<?php
		$str  = '<i>{!!$str!!} dấu !! sẽ echo ra raw text</i>';
		$str1 = '<b>{{$str}} in giá trị của biến</b>';
	?>
	{!!$str!!}
	</br>
	{{$str1}}
	<br>
---------------------------------------------------------------
<br>
Tạo model <br>
$ php artisan make:model Task -mr <br>

---------------------------------------------------------------
<br>
Create database: (view source)<br>
<template>
$ mysql -uroot -p
MySQL [(none)]> create database laravue;
Query OK, 1 row affected (0.04 sec)
MySQL [(none)]> Ctrl-C -- exit!
<template>


<br>
---------------------------------------------------------------
@endsection