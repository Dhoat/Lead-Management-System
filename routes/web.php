<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadUpdateController;

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



Route::get('/', [LeadController::class, 'index'])->name('leads.index');
Route::get('/leads/data', [LeadController::class, 'getData'])->name('leads.data');
Route::post('/leads/update/{id}', [LeadController::class, 'update'])->name('leads.update');



Route::post('/leads/post-update', [LeadUpdateController::class, 'postUpdate'])->name('leads.postUpdate');
Route::get('/leads/view-updates/{id}', [LeadUpdateController::class, 'viewUpdates'])->name('leads.viewUpdates');