<?php

use App\Http\Controllers\DatasetApiController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('v2/dataset', [DatasetApiController::class, 'getDatasets']);
Route::get('v2/dataset/{dataset:slug}', [DatasetApiController::class, 'getDataset'])
    ->missing(function (Request $request) {
        return response()->json([
            'success' => false,
            'message' => 'Dataset tidak ditemukan',
            'data'    => []
        ], 404);
    });

Route::post('v2/posts', [PostController::class, 'store']);
