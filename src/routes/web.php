<?php declare(strict_types=1);

use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('top');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('profile')
        ->name('profile.')
        ->group(function () {
            Route::get('/', [ProfileController::class, 'edit'])->name('edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        });

    Route::prefix('games')
        ->group(function () {
            Route::get('/', [GameController::class, 'index'])->name('games');
            Route::get('/latest', [GameController::class, 'latest'])->name('games.latest');
            Route::get('/{gameId}', [GameController::class, 'find'])->name('games.find');
        });
});

require __DIR__.'/auth.php';