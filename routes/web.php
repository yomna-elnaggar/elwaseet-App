<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dashboard\AdminController;
use App\Http\Controllers\dashboard\BrandController;
use App\Http\Controllers\dashboard\StateController;
use App\Http\Controllers\dashboard\CountryController;
use App\Http\Controllers\dashboard\InvoiceController;
use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\ProductsController;
use App\Http\Controllers\dashboard\GovernmentController;
use App\Http\Controllers\dashboard\TargetTypeController;
use App\Http\Controllers\dashboard\SubCategoryController;
use App\Http\Controllers\dashboard\SuperCategoryController;
use App\Mail\test;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\dashboard\TepsController;
use App\Http\Controllers\dashboard\PrivacyPolicyController;
use App\Http\Controllers\dashboard\TermsConditionsController;
use App\Http\Controllers\dashboard\SaleConditionsController;
use App\Http\Controllers\dashboard\PurchaseConditionsController;
use App\Http\Controllers\dashboard\ReportController;
use App\Http\Controllers\dashboard\AdsRolesController;
use App\Http\Controllers\dashboard\AccountRolesController;
use App\Http\Controllers\Api\VerifyRequestController;
use App\Http\Controllers\Api\ContactUsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/' , [AdminController::class, 'Dashboard'])->name('admin.dashboard')
->middleware('admin');

Route::prefix('admin')->group(function (){
    // for Login and Dashboard
    Route::get('/login' , [AdminController::class, 'index'])->name('login_form');
    Route::post('/login/owner' , [AdminController::class, 'Login'])->name('admin.login');
    Route::get('/logout' , [AdminController::class, 'AdminLogout'])->name('admin.logout')
    ->middleware('admin');
    // Route::get('/register' , [AdminController::class, 'AdminRegister'])->name('admin.register');
    Route::post('/register/create' , [AdminController::class, 'AdminRegisterCreate'])->name('admin.register.create');

    /* =================================
    SuperCategory
    ===================================*/
    Route::get('SuperCategory/', [SuperCategoryController::class, 'index'])->name('SuperCategory.all');
    Route::get('SuperCategory/create', [SuperCategoryController::class, 'create'])->name('SuperCategory.create');
    Route::post('SuperCategory/store', [SuperCategoryController::class, 'store'])->name('SuperCategory.store');
    Route::get('SuperCategory/edit/{id}', [SuperCategoryController::class, 'edit'])->name('SuperCategory.edit');
    Route::post('SuperCategory/update/{id}', [SuperCategoryController::class, 'update'])->name('SuperCategory.update');
    Route::get('SuperCategory/destroy/{id}', [SuperCategoryController::class, 'destroy'])->name('SuperCategory.destroy');
    /* =================================
    category
    ===================================*/
    Route::get('category/', [CategoryController::class, 'index'])->name('category.all');
    Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('category/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
/* =================================
    Subcategory
    ===================================*/
    Route::get('subcategory/', [SubCategoryController::class, 'index'])->name('subcategory.all');
    Route::get('subcategory/create', [SubCategoryController::class, 'create'])->name('subcategory.create');
    Route::post('subcategory/store', [SubCategoryController::class, 'store'])->name('subcategory.store');
    Route::get('subcategory/edit/{id}', [SubCategoryController::class, 'edit'])->name('subcategory.edit');
    Route::post('subcategory/update/{id}', [SubCategoryController::class, 'update'])->name('subcategory.update');
    Route::get('subcategory/destroy/{id}', [SubCategoryController::class, 'destroy'])->name('subcategory.destroy');

    /*country
    ===================================*/
    Route::get('country/', [CountryController::class, 'index'])->name('country.all');
    Route::get('country/create', [CountryController::class, 'create'])->name('country.create');
    Route::post('country/store', [CountryController::class, 'store'])->name('country.store');
    Route::get('country/edit/{id}', [CountryController::class, 'edit'])->name('country.edit');
    Route::post('country/update/{id}', [CountryController::class, 'update'])->name('country.update');
    Route::get('country/destroy/{id}', [CountryController::class, 'destroy'])->name('country.destroy');
  

    /* =================================
    government
    ===================================*/
    Route::get('government/', [GovernmentController::class, 'index'])->name('government.all');
    Route::get('government/create', [GovernmentController::class, 'create'])->name('government.create');
    Route::post('government/store', [GovernmentController::class, 'store'])->name('government.store');
    Route::get('government/edit/{id}', [GovernmentController::class, 'edit'])->name('government.edit');
    Route::post('government/update/{id}', [GovernmentController::class, 'update'])->name('government.update');
    Route::get('government/destroy/{id}', [GovernmentController::class, 'destroy'])->name('government.destroy');
   

    /* =================================
    state
    ===================================*/
    Route::get('state/', [StateController::class, 'index'])->name('state.all');
    Route::get('state/create', [StateController::class, 'create'])->name('state.create');
    Route::post('state/store', [StateController::class, 'store'])->name('state.store');
    Route::get('state/edit/{id}', [StateController::class, 'edit'])->name('state.edit');
    Route::post('state/update/{id}', [StateController::class, 'update'])->name('state.update');
    Route::get('state/destroy/{id}', [StateController::class, 'destroy'])->name('state.destroy');

    /* =================================StateController
    Products
    ===================================*/
    Route::get('product/', [ProductsController::class, 'index'])->name('product.all');
    Route::get('product/destroy/{id}', [ProductsController::class, 'destroy'])->name('product.destroy');

     /* =================================
    Teps
    ===================================*/
    Route::get('Teps/', [TepsController::class, 'index'])->name('Teps.all');
    Route::get('Teps/create', [TepsController::class, 'create'])->name('Teps.create');
    Route::post('Teps/store', [TepsController::class, 'store'])->name('Teps.store');
    Route::get('Teps/edit/{id}', [TepsController::class, 'edit'])->name('Teps.edit');
    Route::post('Teps/update/{id}', [TepsController::class, 'update'])->name('Teps.update');
    Route::get('Teps/destroy/{id}', [TepsController::class, 'destroy'])->name('Teps.destroy');
  
  /* =================================
    verify Request
    ===================================*/
    Route::get('verifyRequest/', [VerifyRequestController::class, 'index'])->name('verifyRequest.all');
    Route::get('verifyRequest/create', [VerifyRequestController::class, 'create'])->name('verifyRequest.create');
    Route::get('TeverifyRequestps/verify/{id}', [VerifyRequestController::class, 'verify'])->name('verifyRequest.verify');
  
   /* =================================
    privacy policy
    ===================================*/
    Route::get('privacyPolicy/', [PrivacyPolicyController::class, 'index'])->name('privacyPolicy.all');
    Route::get('privacyPolicy/create', [PrivacyPolicyController::class, 'create'])->name('privacyPolicy.create');
    Route::post('privacyPolicy/store', [PrivacyPolicyController::class, 'store'])->name('privacyPolicy.store');
    Route::get('privacyPolicy/edit/{id}', [PrivacyPolicyController::class, 'edit'])->name('privacyPolicy.edit');
    Route::post('privacyPolicy/update/{id}', [PrivacyPolicyController::class, 'update'])->name('privacyPolicy.update');
    Route::get('privacyPolicy/destroy/{id}', [PrivacyPolicyController::class, 'destroy'])->name('privacyPolicy.destroy');
  
    /* =================================
    Contact Us
    ===================================*/
    Route::get('ContactUs/', [ContactUsController::class, 'index'])->name('ContactUs.all');
    Route::get('ContactUs/destroy/{id}', [ContactUsController::class, 'destroy'])->name('ContactUs.destroy');
  
   	/* =================================
    Terms and conditions
    ===================================*/
    Route::get('termsConditions/', [TermsConditionsController::class, 'index'])->name('termsConditions.all');
    Route::get('termsConditions/create', [TermsConditionsController::class, 'create'])->name('termsConditions.create');
    Route::post('termsConditions/store', [TermsConditionsController::class, 'store'])->name('termsConditions.store');
    Route::get('termsConditions/edit/{id}', [TermsConditionsController::class, 'edit'])->name('termsConditions.edit');
    Route::post('termsConditions/update/{id}', [TermsConditionsController::class, 'update'])->name('termsConditions.update');
    Route::get('termsConditions/destroy/{id}', [TermsConditionsController::class, 'destroy'])->name('termsConditions.destroy');
    /* =================================
    Sale Conditions
    ===================================*/
    Route::get('saleConditions/', [SaleConditionsController::class, 'index'])->name('saleConditions.all');
    Route::get('saleConditions/create', [SaleConditionsController::class, 'create'])->name('saleConditions.create');
    Route::post('saleConditions/store', [SaleConditionsController::class, 'store'])->name('saleConditions.store');
    Route::get('saleConditions/edit/{id}', [SaleConditionsController::class, 'edit'])->name('saleConditions.edit');
    Route::post('saleConditions/update/{id}', [SaleConditionsController::class, 'update'])->name('saleConditions.update');
    Route::get('saleConditions/destroy/{id}', [SaleConditionsController::class, 'destroy'])->name('saleConditions.destroy');
	/* =================================
    Purchase Conditions
    ===================================*/
    Route::get('purchaseConditions/', [PurchaseConditionsController::class, 'index'])->name('purchaseConditions.all');
    Route::get('purchaseConditions/create', [PurchaseConditionsController::class, 'create'])->name('purchaseConditions.create');
    Route::post('purchaseConditions/store', [PurchaseConditionsController::class, 'store'])->name('purchaseConditions.store');
    Route::get('purchaseConditions/edit/{id}', [PurchaseConditionsController::class, 'edit'])->name('purchaseConditions.edit');
    Route::post('purchaseConditions/update/{id}', [PurchaseConditionsController::class, 'update'])->name('purchaseConditions.update');
    Route::get('purchaseConditions/destroy/{id}', [PurchaseConditionsController::class, 'destroy'])->name('purchaseConditions.destroy');
  
  	/* =================================
    Account Roles
    ===================================*/
    Route::get('accountRoles/', [AccountRolesController::class, 'index'])->name('accountRoles.all');
    Route::get('accountRoles/create', [AccountRolesController::class, 'create'])->name('accountRoles.create');
    Route::post('accountRoles/store', [AccountRolesController::class, 'store'])->name('accountRoles.store');
    Route::get('accountRoles/edit/{id}', [AccountRolesController::class, 'edit'])->name('accountRoles.edit');
    Route::post('accountRoles/update/{id}', [AccountRolesController::class, 'update'])->name('accountRoles.update');
    Route::get('accountRoles/destroy/{id}', [AccountRolesController::class, 'destroy'])->name('accountRoles.destroy');
  	/* =================================
    Ads Roles
    ===================================*/
    Route::get('adsRoles/', [AdsRolesController::class, 'index'])->name('adsRoles.all');
    Route::get('adsRoles/create', [AdsRolesController::class, 'create'])->name('adsRoles.create');
    Route::post('adsRoles/store', [AdsRolesController::class, 'store'])->name('adsRoles.store');
    Route::get('adsRoles/edit/{id}', [AdsRolesController::class, 'edit'])->name('adsRoles.edit');
    Route::post('adsRoles/update/{id}', [AdsRolesController::class, 'update'])->name('adsRoles.update');
    Route::get('adsRoles/destroy/{id}', [AdsRolesController::class, 'destroy'])->name('adsRoles.destroy');
  
    /* =================================
    Reports
    ===================================*/
    Route::get('Report/', [ReportController::class, 'index'])->name('Report.all');
    Route::get('Report/destroy/{id}', [ReportController::class, 'destroy'])->name('Report.destroy');
  
})->middleware('admin');

///get category related 
Route::get('category/{id}', [SubCategoryController::class,'getCategory']);
  
//getGovernment
Route::get('government/{id}', [StateController::class,'getGovernment']);


require __DIR__.'/auth.php';
