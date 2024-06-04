<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuizesController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
// use App\Http\Middleware\TenantsMiddleware;
/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyBySubdomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', [DashboardController::class,'index'])->name('tenant.dashboard');
    Route::prefix('quizes')->group(function () {
        Route::get('/', [QuizesController::class,'index'])->name('quizes');
        Route::get('/create', [QuizesController::class, 'create'])->name('quizes.create');
        Route::post('/', [QuizesController::class, 'store'])->name('quizes.store');
        Route::get('/{quiz}/edit', [QuizesController::class, 'edit'])->name('quizes.edit');
        Route::put('/{quiz}', [QuizesController::class, 'update'])->name('quizes.update');
        Route::delete('/{quiz}', [QuizesController::class, 'destroy'])->name('quizes.destroy');
        // Route::get('/{link}', 'App\Http\Controllers\QuizController@showQuizByLink')->name('quizes.show');
        Route::post('/{quiz}/subscribe', 'App\Http\Controllers\QuizesController@subscribe')->name('quizes.subscribe');
        Route::get('/member/{link}', 'App\Http\Controllers\QuizesController@openSubscribedQuiz')->name('quizes.member');
    });
    Route::get('/members', [MembersController::class,'index'])->name('members');

    // Member Authentication Routes
    Route::prefix('member')->group(function () {
        Route::get('login', 'App\Http\Controllers\MemberAuthController@showLoginForm')->name('member.login');
        Route::post('login', 'App\Http\Controllers\MemberAuthController@login')->name('member.post_login');
        Route::post('logout', 'App\Http\Controllers\MemberAuthController@logout')->name('member.logout');
        Route::get('register', 'App\Http\Controllers\MemberAuthController@showRegistrationForm')->name('member.register');
        Route::post('register', 'App\Http\Controllers\MemberAuthController@register')->name('member.post_register');
    });

    Route::middleware('guest')->group(function () {
    
        Route::get('login', [AuthenticatedSessionController::class, 'create'])
                    ->name('login.admin');
        Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('admin.login');
    });
});
