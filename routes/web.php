<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get("/welcome", function () {
    return "tes routing";
});

Route::redirect("/github", "https://github.com/zhfrann");

Route::fallback(function () {
    return "404 Tidak ada";
});

// learn view
Route::view("/hello", "hello", ['name' => config("myconfig.author.first")]);
//or
Route::get("/hello-again", function () {
    return view("hello", ["name" => config("myconfig.author.first")]);
});

Route::get("/helloworld", function () {
    return view("hello.world", ["name" => config("myconfig.author.first")]);
});
