<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();

/*Route::get('/', function () {
    return view('index');
Route::get('/listings/create', [ListingController::class, 'create'])->name('admin.listings.create');Route::get('/listings/create', [ListingController::class, 'create'])->name('admin.listings.create');
}); */

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    // Analytics

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('admin.analytics.index');
    // Message Notifications
    Route::prefix('messages')->group(function () {
        Route::post('/', [MessageController::class, 'store'])->name('messages.store'); // Add the name here
        Route::get('/', [MessageController::class, 'index'])->name('admin.messages.index');
        Route::get('/{message}', [MessageController::class, 'show'])->name('admin.messages.show');
        Route::post('/{message}/mark-successful', [MessageController::class, 'markSuccessful'])
            ->name('messages.mark-successful');
    });
});
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/admin/listings', [ListingController::class, 'index'])->name('layouts.allListings');
Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');
// Listings routes
Route::get('/posted-rooms', [ListingController::class, 'index'])->name('listings.index');
Route::get('/posted-rooms/search', [ListingController::class, 'search'])->name('listings.search');
Route::get('/posted-rooms/{listing}', [ListingController::class, 'show'])->name('listings.show');
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/landlords', [LandlordController::class, 'index'])->name('admin.landlords.index');
    Route::post('/landlords', [LandlordController::class, 'store'])->name('admin.landlords.store');
    Route::put('/landlords/{landlord}', [LandlordController::class, 'update'])->name('admin.landlords.update'); // This is the store route
    Route::delete('/landlords/{landlord}', [LandlordController::class, 'destroy'])->name('admin.landlords.destroy');

    Route::get('/agents', [AgentController::class, 'index'])->name('admin.agents.index');
    Route::post('/agents', [AgentController::class, 'store'])->name('admin.agents.store');
    Route::put('/agents/{agent}', [AgentController::class, 'update'])->name('admin.agents.update'); // This is the store route
    Route::delete('/agents/{agent}', [AgentController::class, 'destroy'])->name('admin.agents.destroy');

    Route::get('/tenants', [TenantController::class, 'index'])->name('admin.tenants.index');
    Route::post('/tenants', [TenantController::class, 'store'])->name('admin.tenants.store');
    Route::put('/tenants/{tenant}', [TenantController::class, 'update'])->name('admin.tenants.update'); // This is the store route
    Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('admin.tenants.destroy');
});
