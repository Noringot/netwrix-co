<?php

use App\Http\Controllers\Api\v1\PartnersSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/countries', [PartnersSearch::class, 'getAllCountries'])->name('get_countries');
Route::get('/states', [PartnersSearch::class, 'getAllStates'])->name('get_states');
Route::get('/partners', [PartnersSearch::class, 'getAllPartners'])->name('get_partners');
