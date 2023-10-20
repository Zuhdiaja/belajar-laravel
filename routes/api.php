<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\SiswaController;
use App\Models\Siswa;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function(){
    Route::get('/getsiswa', [SiswaController::class, 'getsiswa']);
    Route::post('/createsiswa', [SiswaController::class, 'createsiswa']);
    Route::post('/updatesiswa/{id}', [SiswaController::class, 'updatesiswa']);
    Route::delete('/deletesiswa/{id}', [SiswaController::class, 'deletesiswa']);
});


// Route::get('/getImage/{id}' , function($id){
//     $gambar = Siswa::where("id" , "=" , $id)->get('gambar');
//     return response()->json($gambar);
// });

Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout',   [AuthController::class, 'logout']);
});