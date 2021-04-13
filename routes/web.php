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


Route::get("/", ["uses" => "HomeController@index"]);
Route::get("/login", ["as" => "login", "uses" => "LoginController@index"]);
Route::post("/logout", ["as" => "logout", "uses" => "LoginController@logout"]);
Route::post("/login", ["as" => "login-submit", "uses" => "LoginController@login"]);
Route::post("/answer", ["as" => "answer", "uses" => "HomeController@answer"]);
Route::get("/play", ["as" => "play", "uses" => "HomeController@play"])->middleware(["auth","web"]);
