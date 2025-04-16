<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('test');
});

Route::prefix('api/v1/')->group(function () {
  Route::get('/test', function () {
    return response()->json(['message' => 'Hello, World from api!']);
  });
  Route::delete('/test', function () {
    return response()->json(['message' => 'Deleting']);
  });
});