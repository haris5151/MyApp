<?php
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Models\MdProduct;
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
Route::get('/get-user' ,[LoginController::class, 'index']);
Route::post('/register',[RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/last-seen', function () {
})->middleware('last.seen');

// Route::get('/fetch-country',[DropdownController::class,'fetchCountry']);
// Route::get('/fetch-state',[DropdownController::class,'fetchState']);
// Route::get('/fetch-city',[DropdownController::class,'fetchCity']);
Route::get('fetch-country', [DropdownController::class, 'fetchCountry']);
Route::get('fetch-city/{country}', [DropdownController::class, 'fetchCity']);

Route::get('/index-company',[CompanyController::class,'index']);
Route::post('/create-company',[CompanyController::class,'createCompany']);
Route::get('/show-company/{id}',[CompanyController::class,'show']);
Route::put('/update-company/{id}',[CompanyController::class,'update']);

Route::get('/index-branch',[BranchController::class,'index']);
Route::post('/create-branch',[BranchController::class,'createBranch']);
Route::get('/show-branch/{id}',[BranchController::class,'show']);
Route::put('/update-branch/{id}',[BranchController::class,'update']);

Route::get('/index-role',[RoleController::class,'index']);
Route::post('/create-role',[RoleController::class,'createRole']);
Route::get('/show-role/{id}',[RoleController::class,'show']);
Route::put('/update-role/{id}',[RoleController::class,'update']);

Route::get('/index-product',[ProductController::class,'index']);
Route::post('/create-product',[ProductController::class,'createProduct']);
Route::get('/show-product/{id}',[ProductController::class,'show']);
Route::post('/update-product/{id}',[ProductController::class,'update']);

Route::post('/create-service',[ServiceController::class, 'createService']);
Route::get('/index-service',[ServiceController::class, 'index']);
Route::get('/show-service/{id}',[ServiceController::class, 'show']);
Route::put('/update-service/{id}',[ServiceController::class, 'update']);

Route::post('/create-order',[OrderController::class, 'createOrder']);
Route::get('/index-order',[OrderController::class, 'index']);
Route::get('/show-order/{id}',[OrderController::class, 'show']);
Route::post('/update-order/{id}',[OrderController::class, 'update']);








// Route::get('/user',function(Request $request){
//     return $request->user();

// })->middleware('auth:Sanctum');

// Route::get('/logout',function(Request $request){
//     return $request->user()->currentAccessToken()->delete();

// })->middleware('auth:Sanctum');