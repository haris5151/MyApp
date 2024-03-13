<?php
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DropdownController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/login' ,[LoginController::class, 'login']);
Route::post('/register',[RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/fetch-country',[DropdownController::class,'fetchCountry']);
Route::get('/fetch-state',[DropdownController::class,'fetchState']);
Route::get('/fetch-city',[DropdownController::class,'fetchCity']);

Route::get('/index-company',[CompanyController::class,'index']);
Route::post('/create-company',[CompanyController::class,'createCompany']);
Route::get('/show-company/{id}',[CompanyController::class,'show']);
Route::put('/update-company/{id}',[CompanyController::class,'update']);

Route::get('/index-branch',[BranchController::class,'index']);
Route::post('/create-branch',[BranchController::class,'createBranch']);
Route::get('/show-branch/{id}',[BranchController::class,'show']);
Route::put('/update-branch/{id}',[BranchController::class,'update']);







// Route::get('/user',function(Request $request){
//     return $request->user();

// })->middleware('auth:Sanctum');

// Route::get('/logout',function(Request $request){
//     return $request->user()->currentAccessToken()->delete();

// })->middleware('auth:Sanctum');