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


// Route Parameter
Route::get("/products/{id}", function ($productId) {
    return "Products : $productId";
})->name("product.detail");

Route::get("/products/{product}/items/{item}", function ($productId, $itemId) {
    return "Products : $productId, Items : $itemId";
})->name("product.item.detail");

Route::get("/categories/{id}", function ($categoryId) {
    return "Category : $categoryId";
})->where("id", "[0-9]+")->name("categori.detail");

Route::get("/users/{id?}", function (string $userId = "404") {
    return "User : $userId";
})->name("user.detail");

Route::get("/conflict/{name}", function ($name) {
    return "Conflict $name";
});

Route::get("/conflict/john", function () {
    return "Conflict John Doe";
});
