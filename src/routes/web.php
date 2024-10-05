<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminGameController;
use App\Http\Controllers\Admin\AdminAuthenticatedSessionController;
use App\Http\Controllers\User\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserLoginController;

Route::get('/', function () {
    return view('top');
})
->name('top');

// 認証前
Route::prefix('oauth')
    ->middleware(['guest'])
    ->as('oauth.')
    ->group(function () {
        // ユーザーログイン
        Route::prefix('user')
            ->as('user.')
            ->group(function () {
                Route::get('/{provider}/redirect', [UserLoginController::class, 'redirectToProvider'])
                    ->name('login');
                Route::get('/{provider}/callback', [UserLoginController::class, 'handleProviderCallback'])
                    ->name('callback');
            });
        
        // 管理者ログイン
        Route::prefix('admin')
            ->as('admin.')
            ->group(function () {
                Route::get('/secret-login-3c25fc', fn() => view('admin.auth.login'))
                    ->name('top');
                Route::get('/redirect', [AdminAuthenticatedSessionController::class, 'redirectToProvider'])
                    ->name('login');
                Route::get('/callback', [AdminAuthenticatedSessionController::class, 'handleProviderCallback'])
                    ->name('callback');
            });
    });

// ユーザー
Route::middleware(['auth', 'verified', 'user'])
    ->group(function () {
        Route::prefix('profile')
            ->name('profile.')
            ->group(function () {
                Route::get('/', [ProfileController::class, 'edit'])->name('edit');
                Route::patch('/', [ProfileController::class, 'update'])->name('update');
                Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
            });

        Route::prefix('games')
            ->as('games.')
            ->group(function () {
                Route::get('/', [GameController::class, 'index'])->name('index');
                Route::get('/latest', [GameController::class, 'latest'])->name('latest');
                Route::get('/{gameId}', [GameController::class, 'find'])->name('game');
            });
    });

// 管理者
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->as('admin.')
    ->group(function () {
        // 認証処理
        Route::post('/enable2fa', [AdminAuthenticatedSessionController::class, 'enable2FA'])->name('enable2fa');
        Route::post('/verify2fa', [AdminAuthenticatedSessionController::class, 'verify2FA'])->name('verify2fa');

        Route::post('/logout', [AdminAuthenticatedSessionController::class, 'logout'])->name('logout');

        // 認証後
        Route::prefix('games')
            ->middleware(['2fa'])
            ->as('games.')
            ->group(function () {
                Route::get('/', [AdminGameController::class, 'index'])->name('index');
            });
    });

require __DIR__.'/auth.php';