<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EditInfoController;


Route::redirect('/', '/events');


Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::get('/events', [EventController::class, 'index'])->name('events.getAll');
Route::get('/events/{id}/edit', [EventController::class, 'editEvent'])->name('events.edit');
Route::put('/events/{id}/edit', [EventController::class, 'update'])->name('events.update');
Route::post('/events/create', [EventController::class, 'store'])->name('events.store');
Route::delete('/events/{id}/destroy', [EventController::class, 'destroy'])->name('events.destroy');

Route::get('/calendar', [CalendarController::class, 'show'])->name('calendar');

Route::get('/calendar', [CalendarController::class, 'show'])->name('calendar');

Route::post('/editInfo/{option}/createFood', [EditInfoController::class, 'createFood'])->name('newFoodInfo');
Route::post('/editInfo/{option}/createOther', [EditInfoController::class, 'createOther'])->name('newOtherInfo');

Route::get('/editInfo', [EditInfoController::class, 'show'])->name('editTables');

Route::get('/editFoodInfo/{option}', [EditInfoController::class, 'editFoods'])->name('editFoodInfo');
Route::get('/editOtherInfo/{option}', [EditInfoController::class, 'editOtherOptions'])->name('editOtherOptionsInfo');

Route::post('/editFoodInfo/{option}', [EditInfoController::class, 'saveEditFoods'])->name('saveEditFoodInfo');
Route::post('/editOtherInfo/{option}', [EditInfoController::class, 'saveEditOthers'])->name('saveEditOtherInfo');

Route::delete('/editInfo/{option}/delete', [EditInfoController::class, 'deleteOption'])->name('deleteOption');
