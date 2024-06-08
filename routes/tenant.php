<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuizesController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Jobs\ExportQuizResults;
use Illuminate\Support\Facades\Log;
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
    // Route::get('/example-route', function () {
    //     Log::info('This is a log message from the tenant.php route file');
    //     return 'Example Route';
    // });
    Route::get('/', [DashboardController::class,'index'])->name('tenant.dashboard');
    Route::middleware('auth:web,member')->group(function () {
    Route::prefix('quizes')->group(function () {
        Route::get('/', [QuizesController::class,'index'])->name('quizes');
        Route::get('/create', [QuizesController::class, 'create'])->name('quizes.create');
        Route::post('/', [QuizesController::class, 'store'])->name('quizes.store');
        Route::get('/{quiz}/edit', [QuizesController::class, 'edit'])->name('quizes.edit');
        Route::put('/{quiz}', [QuizesController::class, 'update'])->name('quizes.update');
        Route::delete('/{quiz}', [QuizesController::class, 'destroy'])->name('quizes.destroy');
        // Route::get('/{link}', 'App\Http\Controllers\QuizController@showQuizByLink')->name('quizes.show');
        Route::post('/{quiz}/subscribe', 'App\Http\Controllers\QuizSubscribionsController@subscribe')->name('quizes.subscribe');
        Route::get('/member/{link}', 'App\Http\Controllers\QuizSubscribionsController@openSubscribedQuiz')->name('quizes.member');
        Route::post('/{quiz}/submit', 'App\Http\Controllers\QuizSubscribionsController@submit')->name('quizzes.submit');
        Route::get('/{quiz}/result', 'App\Http\Controllers\QuizSubscribionsController@quizAllResults')->name('quizes.result');
        Route::get('/startQuiz/{link}', 'App\Http\Controllers\QuizSubscribionsController@startQuiz')->name('quizes.startQuiz');

        Route::get('/export-quiz-results', function () {
            ExportQuizResults::dispatch()->onQueue('high')->delay(now()->addMinutes(1));

            return redirect()->route('quizes')->message('success','Exported file successfully');
        })->name('quiz.export');
    });
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('admin.logout');
    Route::post('/member/logout', 'App\Http\Controllers\MemberAuthController@logout')->name('member.logout');
    });

    Route::middleware('guest')->group(function () {
        // Member Authentication Routes
        Route::prefix('member')->group(function () {
            Route::get('login', 'App\Http\Controllers\MemberAuthController@showLoginForm')->name('member.login');
            Route::post('login', 'App\Http\Controllers\MemberAuthController@login')->name('member.post_login');
         
            Route::get('register', 'App\Http\Controllers\MemberAuthController@showRegistrationForm')->name('member.register');
            Route::post('register', 'App\Http\Controllers\MemberAuthController@register')->name('member.post_register');
        });
        Route::get('login', [AuthenticatedSessionController::class, 'create'])
                    ->name('login.admin');
        Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('admin.login');
    });

    Route::middleware('auth:web')->group(function () {
        Route::get('/members', [MembersController::class, 'index'])->name('members.index');
        Route::get('/members/create', [MembersController::class, 'create'])->name('members.create');
        Route::post('/members', [MembersController::class, 'store'])->name('members.store');
        Route::get('/members/{member}/edit', [MembersController::class, 'edit'])->name('members.edit');
        Route::put('/members/{member}', [MembersController::class, 'update'])->name('members.update');
        Route::delete('/members/{member}', [MembersController::class, 'destroy'])->name('members.destroy');
    });
});
