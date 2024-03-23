<?php

use App\Http\Controllers\Web\IndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['suffix' => '.html'], function () {
    Route::get('/{view?}', function ($view = "auth.login") {
        $view = str_replace(["-", ".html"], [".", ""], $view);
        if (!view()->exists($view)) {
            abort(404);
        }

        return view($view);
    });
});
