<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotebookController;

Route::prefix('v1/notebook')->group(function () {
    Route::get('/', [NotebookController::class, 'index']);        // Получение записей в записной книжки
    Route::post('/', [NotebookController::class, 'store']);       // Создание записи в записной книжке
    Route::get('/{id}', [NotebookController::class, 'show']);     // Получение записи в записной книжке
    Route::post('/{id}', [NotebookController::class, 'update']);  // Обновление записи в записной книжке
    Route::delete('/{id}', [NotebookController::class, 'destroy']); // Удаление записи в записной книжке
});