<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Admin\AdminMuridController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', [AdminMuridController::class, 'test']);

Route::get('/broadcast', function() {
    event(new \Factum\Events\TestEvent('Sent from my Laravel application'));

    return 'ok';
});
