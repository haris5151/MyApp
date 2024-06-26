<?php
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MdServiceDetailController;
use App\Http\Controllers\NotificationSendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SizeController;

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
Route::post('/login', [LoginController::class, 'login']);
Route::get('/get-user', [LoginController::class, 'index']);
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/show-user/{id}', [RegisterController::class, 'show']);

Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/last-seen', function () {
})->middleware('last.seen');
// update user
Route::post('/update-user-registeration/{id}', [RegisterController::class, 'update']);

// Route::get('/fetch-country',[DropdownController::class,'fetchCountry']);
// Route::get('/fetch-state',[DropdownController::class,'fetchState']);
// Route::get('/fetch-city',[DropdownController::class,'fetchCity']);
Route::get('fetch-country', [DropdownController::class, 'fetchCountry']);
Route::get('fetch-city/{country}', [DropdownController::class, 'fetchCity']);

Route::get('/index-company', [CompanyController::class, 'index']);
Route::post('/create-company', [CompanyController::class, 'createCompany']);
Route::get('/show-company/{id}', [CompanyController::class, 'show']);
Route::put('/update-company/{id}', [CompanyController::class, 'update']);

Route::get('/index-branch', [BranchController::class, 'index']);
Route::post('/create-branch', [BranchController::class, 'createBranch']);
Route::get('/show-branch/{id}', [BranchController::class, 'show']);
Route::put('/update-branch/{id}', [BranchController::class, 'update']);

// Route::get('/index-role', [RoleController::class, 'index']);
// Route::post('/create-role', [RoleController::class, 'createRole']);
// Route::get('/show-role/{id}', [RoleController::class, 'show']);
// Route::put('/update-role/{id}', [RoleController::class, 'update']);

Route::get('/index-product', [ProductController::class, 'index']);
Route::post('/create-product', [ProductController::class, 'createProduct']);
Route::get('/show-product/{id}', [ProductController::class, 'show']);
Route::post('/update-product/{id}', [ProductController::class, 'update']);

Route::post('/create-service',[ServiceController::class, 'createService']);
Route::get('/index-service',[ServiceController::class, 'index']);
Route::get('/show-service/{id}',[ServiceController::class, 'show']);
// get services related to specific branch
Route::get('/show-branch_service/{id}',[ServiceController::class, 'showBranch']);

Route::get('/show-service_details/{id}',[MdServiceDetailController::class, 'showServiceDetails']);


Route::put('/update-service/{id}',[ServiceController::class, 'update']);

Route::post('/create-order', [OrderController::class, 'createOrder']);
Route::get('/index-order', [OrderController::class, 'index']);
Route::get('/show-order/{id}', [OrderController::class, 'show']);
Route::post('/update-order/{id}', [OrderController::class, 'update']);

Route::post('/create-servicedetails', [MdServiceDetailController::class, 'createServiceDetails']);
Route::post('/update-servicedetails/{id}', [MdServiceDetailController::class, 'updateServiceDetails']);
Route::get('/index-servicedetail', [MdServiceDetailController::class, 'index']);
Route::get('/show-servicedetail/{id}', [MdServiceDetailController::class, 'show']);

Route::post('/create-appointment',[AppointmentController::class, 'createAppointment']);
Route::post('/update-appointment/{id}',[AppointmentController::class, 'update']);
Route::get('/index-appointment',[AppointmentController::class, 'index']);
Route::get('/get-service-details/{id}',[AppointmentController::class, 'getservicedetails']);

// send notification
// Route::post('/send-notification',[NotificationSendController::class, 'sendNotification']);
// Route::post('/store-token', [NotificationSendController::class, 'updateDeviceToken']);
Route::post('/send-notification/{receiverId}', [NotificationController::class, 'sendNotification']);
Route::get('/notifications/{userId}', [NotificationController::class, 'getNotifications']);
Route::put('/notifications/mark-read/{userId}', [NotificationController::class, 'markNotificationsAsRead']);








// login with google
Route::get('/google/redctire', [SocialController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [SocialController::class, 'handleGoogleCallback'])->name('google.callback');

// facebook login
// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return response()->json();
//     })->name('dashboard');
// });
//
Route::get('/auth/facebook', [SocialController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);

// Vendor routes
// Route::middleware('vendor')->group(function () {
//     Route::post('/create-service', [ServiceController::class, 'createService']);

//     Route::get('/index-service', [ServiceController::class, 'index']);
//     Route::get('/show-service/{id}', [ServiceController::class, 'show']);
//     Route::put('/update-service/{id}', [ServiceController::class, 'update']);

//     Route::post('/create-servicedetails', [MdServiceDetailController::class, 'createServiceDetails']);
//     Route::post('/update-servicedetails/{id}', [MdServiceDetailController::class, 'updateServiceDetails']);
//     Route::get('/index-servicedetail', [MdServiceDetailController::class, 'index']);
//     Route::get('/show-servicedetail/{id}', [MdServiceDetailController::class, 'show']);

//     Route::get('/index-company', [CompanyController::class, 'index']);
//     Route::post('/create-company', [CompanyController::class, 'createCompany']);
//     Route::get('/show-company/{id}', [CompanyController::class, 'show']);
//     Route::put('/update-company/{id}', [CompanyController::class, 'update']);

//     Route::get('/index-branch', [BranchController::class, 'index']);
//     Route::post('/create-branch', [BranchController::class, 'createBranch']);
//     Route::get('/show-branch/{id}', [BranchController::class, 'show']);
//     Route::put('/update-branch/{id}', [BranchController::class, 'update']);
// });
// Customer routes
// Route::middleware('customer')->group(function () {

//     Route::post('/create-order', [OrderController::class, 'createOrder']);
//     Route::get('/index-order', [OrderController::class, 'index']);
//     Route::get('/show-order/{id}', [OrderController::class, 'show']);
//     Route::post('/update-order/{id}', [OrderController::class, 'update']);

//     Route::post('/create-appointment', [AppointmentController::class, 'createAppointment']);

// });

// Route::get('/user',function(Request $request){
//     return $request->user();

// })->middleware('auth:Sanctum');

// Route::get('/logout',function(Request $request){
//     return $request->user()->currentAccessToken()->delete();

// })->middleware('auth:Sanctum');

// nearby location
Route::post('/locations/search',[LocationController::class,'search']);
Route::get('/nearby-branches/{userId}', [LocationController::class, 'getNearbyBranches']);
// dashbooardapis
Route::get('/companies/last-seven-days',[DashboardController::class, 'companiesCreatedLastSevenDays']);
Route::get('/branches/last-seven-days',[DashboardController::class, 'BranchesCreatedLastSevenDays']);
Route::get('/services/last-seven-days',[DashboardController::class, 'ServicesCreatedLastSevenDays']);
Route::get('/gender',[DashboardController::class, 'countUsersByGender']);
Route::get('/total-count',[DashboardController::class, 'totalCounts']);
Route::get('/order-status',[DashboardController::class, 'orderCountsByStatus']);
Route::get('/order-total',[DashboardController::class, 'OrderCreatedLastSevenDays']);

// message

Route::post('/send-message', [MessageController::class,'sendMessage']);
Route::get('/get-message', [MessageController::class ,'getMessages']);

// sizes
Route::post('/create-size', [SizeController::class, 'create']);
Route::get('/index-size', [SizeController::class, 'index']);
Route::get('/show-size/{id}', [SizeController::class, 'show']);
Route::post('/update-size/{id}', [SizeController::class, 'update']);
