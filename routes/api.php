<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\userAuth\LoginController;
use App\Http\Controllers\Api\userAuth\LogoutController;
use App\Http\Controllers\Api\userAuth\ProfileController;
use App\Http\Controllers\Api\userAuth\RegisterController;
use App\Http\Controllers\Api\userAuth\PasswordController;
use App\Http\Controllers\Api\Country\CountryController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Product\UserProductController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Product\SearchController;
use App\Http\Controllers\Api\Product\FavouriteProductController;
use App\Http\Controllers\Api\vendor\VendorController;
use App\Http\Controllers\Api\vendor\FavouriteController;
use App\Http\Controllers\Api\vendor\RateingController;
use App\Http\Controllers\Api\userAuth\PhoneVerificationController;
use App\Http\Controllers\Api\userAuth\ForgotPasswordController;
use App\Http\Controllers\Api\Block\BlockController;
use App\Http\Controllers\Api\Mute\MuteController;
use App\Http\Controllers\Api\Chat\ChatController;
use App\Http\Controllers\Api\userAuth\ForgotPasswordByEmailController;
use App\Http\Controllers\Api\TepsApiController;
use App\Http\Controllers\Api\VerifyRequestController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\DeviceTokrnController;
use App\Http\Controllers\dashboard\PrivacyPolicyController;
use App\Http\Controllers\dashboard\TermsConditionsController;
use App\Http\Controllers\dashboard\SaleConditionsController;
use App\Http\Controllers\dashboard\PurchaseConditionsController;
use App\Http\Controllers\dashboard\ReportController;
use App\Http\Controllers\dashboard\AdsRolesController;
use App\Http\Controllers\dashboard\AccountRolesController;
use App\Notifications\NewMessageNotification;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. T
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('setapplang')->prefix('{locale}')->group(function(){
    ////user authentication
    Route::post('register', [RegisterController::class,'register']);
    Route::post('login', [LoginController::class,'login']);
    ////login with socialite
    Route::post('registerWithSocial', [RegisterController::class,'registerWithSocial']);
    ////user forget password by sms
    Route::post('forgot-password/send-code',[ForgotPasswordController::class,'sendVerificationCode']);
    Route::post('forgot-password/verify-code',[ForgotPasswordController::class,'verifyCode']);
    ////user forget password by email
    Route::post('forgot-password', [ForgotPasswordByEmailController::class, 'forgotPassword']);
  	Route::post('validateToken', [ForgotPasswordByEmailController::class, 'validateResetToken']);
    Route::post('resetPassword', [ForgotPasswordByEmailController::class, 'completeResetPassword']);
    ////category
    Route::get('category',[CategoryController::class ,'index']);
    Route::get('subCategory/{id}',[CategoryController::class ,'subCategory']);
    Route::get('catProduct/{id}',[CategoryController::class ,'catProduct']);
    Route::get('catWithSubProduct/{catId}/{subId}',[CategoryController::class ,'catWithSubProduct']);
    ////product
    Route::get('product', [ProductController::class,'index']);
    Route::get('product/{id}', [ProductController::class,'show']);
    ////product in the same city
    Route::get('cityProduct', [ProductController::class,'cityProduct']);
    /////product with most-views
    Route::get('mostViews', [ProductController::class,'mostViews']);
    ////search
    Route::get('search', [SearchController::class,'search']);
    Route::get('searchInCategory', [SearchController::class,'searchInCategory']);
    Route::get('searchInMostViews', [SearchController::class,'searchInMostViews']);
    Route::get('filter', [SearchController::class,'filter']);
    ////vendor
    Route::get('vendor/{id}', [VendorController::class,'vendor']);
    Route::get('vendorProduct/{id}', [VendorController::class,'vendorProduct']);
    Route::post('vendor/{id}/favourit', [FavouriteController::class,'favourit']);
    Route::get('vendorRate/{id}', [RateingController::class,'vendorRate']);
    ////TermsConditions
    Route::get('TermsConditions', [TermsConditionsController::class,'TermsConditions']);
    
    
  
});


Route::middleware(['auth:sanctum','setapplang'])->prefix('{locale}')->group(function(){
    ////user
    Route::get('/profile',[ProfileController::class,'profile']);
    Route::put('updateProfile', [ProfileController::class,'update']);
    Route::post('destroy', [ProfileController::class, 'destroy']);
    Route::post('logout', [LogoutController::class, 'logout']);
    Route::post('change-password',[PasswordController::class,'changePassword']);
    Route::post('verify-phone', [PhoneVerificationController::class , 'verify']);
    Route::post('reset-passwordbyvrifycod', [ForgotPasswordController::class ,'resetPassword']);
  	////verify
    Route::post('verifyRequest', [VerifyRequestController::class,'verifyRequest']);
    ///Government 
    Route::get('government', [CountryController::class,'getGovernment']);
    Route::get('state/{id}', [CountryController::class,'getState']);
    ////user product
    Route::post('userProduct', [UserProductController::class,'store']);
    Route::get('userProduct', [UserProductController::class,'index']);
    Route::get('userProduct/{id}', [UserProductController::class,'show']);
    Route::put('userProduct/{product}', [UserProductController::class, 'update']);
    Route::delete('userProduct/{id}', [UserProductController::class, 'destroy']);
    Route::post('userProduct/{id}/sold', [UserProductController::class,'sold']);
    Route::get('userMostViews/{id}', [UserProductController::class,'userMostViews']);
    Route::get('block', [UserProductController::class,'block']);
  	Route::post('repost/{id}', [UserProductController::class,'repost']);
    ////user product ios
    Route::post('userProductInf', [UserProductController::class,'storeIOs']);
    Route::post('ProductImage', [UserProductController::class,'storeImage']);
    ////Vendor
    Route::post('vendor/{id}/rateing', [RateingController::class,'addRating']);
    //// product favourite 
    Route::post('addToFavorites/{productId}', [FavouriteProductController::class,'addToFavorites']);
    Route::post('removeFromFavorites/{productId}', [FavouriteProductController::class,'removeFromFavorites']);
    Route::get('userFavoriteProducts/', [FavouriteProductController::class,'getFavoriteProducts']);
    Route::get('is_favorite/{id}', [FavouriteProductController::class,'is_favorite']);
    ////block
    Route::post('block/{blockedUserId}', [BlockController::class, 'blockUser']);
    Route::delete('unblock/{blockedUserId}', [BlockController::class, 'unblockUser']);
    Route::get('blocked-users', [BlockController::class, 'blockedUsers']); 
  	////mute
    Route::post('mute/{mutedUserId}', [MuteController::class, 'muteUser']);
    Route::delete('unmute/{mutedUserId}', [MuteController::class, 'unmuted']);
    Route::get('muted-users/{mutedUserId}', [MuteController::class, 'muteddUsers']); 
    ////chat
    Route::post('sendMessage', [ChatController::class,'sendMessage']);
   	Route::post('sendFile', [ChatController::class,'sendFile']);
    Route::get('getUserChatWith', [ChatController::class,'getUserChatWith']);
    Route::get('getUserChats', [ChatController::class,'getUserChats']);
    Route::post('deleteMessage', [ChatController::class,'deleteMessage']);
    Route::post('deleteChat', [ChatController::class,'deleteChat']);
    ////Teps
    Route::get('Teps', [TepsApiController::class,'index']);
    ////PrivacyPolicy
    Route::get('PrivacyPolicy', [PrivacyPolicyController::class,'PrivacyPolicy']);
  	////contactUs
  	Route::post('contactUs', [ContactUsController::class,'contactUs']);
  	////SaleConditions
    Route::get('SaleConditions', [SaleConditionsController::class,'SaleConditions']);
  	////PurchaseConditions
    Route::get('PurchaseConditions', [PurchaseConditionsController::class,'PurchaseConditions']);
  	////AccountRoles
    Route::get('AccountRoles', [AccountRolesController::class,'AccountRoles']);
  	////AdsRoles
    Route::get('AdsRoles', [AdsRolesController::class,'AdsRoles']);
  	/////report
   	Route::post('addReport/{id}', [ReportController::class,'addReport']);
  	/////Notification
  	Route::post('storeNotification', [NotificationController::class,'store']);
  	Route::get('notifications', [NotificationController::class,'index']);
  	Route::get('showOne', [NotificationController::class,'showOne']);
  	Route::get('unread', [NotificationController::class,'unread']);
  	Route::post('fcmToken', [DeviceTokrnController::class,'store']);
  
  
  Route::get('/send-notification', function (Request $request) {
    $user = $request->user(); // Assuming you have a user model and authentication system
    $user->notify(new NewMessageNotification("ujibiooi yo"));
    return "Notification sent!";
});
  
});