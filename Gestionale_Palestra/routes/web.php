<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Activity;
use App\Models\Course;
use App\Models\Reservation;

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



Route::post('/reservations/{id}/accept', [ReservationController::class, 'accept'])->name('reservations.accept');
Route::post('/reservations/{id}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');

Route::get('/admindashboard', function () {
    $user = Auth::user();
    if ($user->role_id == 1) {
        $reservations = Reservation::all();
        return view('admindashboard', ["reservations" => $reservations]);}
    else {
        return redirect('/');   
    }})->name('admindashboard');

Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $activities = Activity::all(); 
    $courses = Course::with('reservation')->get(); 
    $reservations = Reservation::all();

    return view('dashboard', compact('activities', 'courses', 'reservations')); 
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
