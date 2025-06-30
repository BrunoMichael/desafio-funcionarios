<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\ListFuncionarios;
use App\Livewire\FuncionarioForm;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas para Funcionários
    Route::get('/funcionarios', ListFuncionarios::class)->name('funcionarios.index');
    Route::get('/funcionarios/create', function () {
        return view('funcionarios.create');
    })->name('funcionarios.create');
    Route::get('/funcionarios/{funcionario}/edit', FuncionarioForm::class)->name('funcionarios.edit');
});

require __DIR__.'/auth.php';