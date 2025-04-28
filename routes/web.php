<?php

use App\Http\Controllers\CookieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Http\Middleware\ContohMiddleware;
use App\Http\Middleware\VerifyCsrfToken;
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


Route::get("/controller/hello/request", [HelloController::class, 'request']);
Route::get("/controller/hello/{name?}", [HelloController::class, 'hello']);


Route::get("/input/hello", [InputController::class, 'hello']);
Route::post("/input/hello", [InputController::class, 'hello']);
Route::post("/input/hello/first", [InputController::class, 'helloFirstName']);
Route::post("/input/hello/input", [InputController::class, 'helloInput']);
Route::post("/input/hello/array", [InputController::class, 'arrayInput']);
Route::post("/input/type", [InputController::class, 'inputType']);
Route::post("/input/filter/only", [InputController::class, 'filterOnly']);
Route::post("/input/except/only", [InputController::class, 'exceptOnly']);
Route::post("/input/filter/merge", [InputController::class, 'filterMerge']);

Route::post("/file/upload", [FileController::class, "upload"])->withoutMiddleware([VerifyCsrfToken::class]);

Route::get("/response/hello", [ResponseController::class, "response"]);
Route::get("/response/header", [ResponseController::class, "header"]);
Route::get("/response/type/view", [ResponseController::class, "responseView"]);
Route::get("/response/type/json", [ResponseController::class, "responseJson"]);
Route::get("/response/type/file", [ResponseController::class, "responseFile"]);
Route::get("/response/type/download", [ResponseController::class, "responseDownload"]);

Route::get("/cookie/set", [CookieController::class, "createCookie"]);
Route::get("/cookie/get", [CookieController::class, "getCookie"]);
Route::get("/cookie/clear", [CookieController::class, "clearCookie"]);

Route::get("/redirect/to", [RedirectController::class, "redirectTo"]);
Route::get("/redirect/from", [RedirectController::class, "redirectFrom"]);
Route::get("/redirect/name", [RedirectController::class, "redirectName"]);
Route::get("/redirect/name/{name}", [RedirectController::class, "redirectHello"])->name("redirect-hello");
Route::get("/redirect/action", [RedirectController::class, "redirectAction"]);
Route::get("/redirect/youtube", [RedirectController::class, "away"]);

// Middleware
Route::get("/middleware/api", function () {
    return "OK";
    // })->middleware(ContohMiddleware::class);
})->middleware(['contoh:pzn,401']);

Route::get("/middleware/group", function () {
    return "GROUP";
})->middleware('pzn');


// Csrf
Route::get("/form", [FormController::class, "form"]);
Route::post("/form", [FormController::class, "submitForm"]);
