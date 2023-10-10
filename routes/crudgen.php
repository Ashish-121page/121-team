<?php
use App\Http\Controllers\CrudGenrator\CrudGenController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\couponsController;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Panel\ProposalController;
use App\Http\Controllers\WebsiteController;


Route::group(['middleware' => 'can:manage_dev','prefix' => 'dev/crudgen', 'as' => 'crudgen.'], function () {

    Route::get('/', [CrudGenController::class,'index'])->name('index');
    Route::get('/bulkimport', [CrudGenController::class,'bulkImport'])->name('bulkimport');
    Route::Post('/bulkimport/generate', [CrudGenController::class,'bulkImportGenerate'])->name('bulkimport.generate');
    Route::post('/generate', [CrudGenController::class,'generate'])->name('generate');
    Route::get('/getcol', [CrudGenController::class,'getColumns'])->name('getcol');
});

Route::group(['middleware' => 'auth','namespace' => 'Admin\ConstantManagement', 'prefix' => 'backend/constant-management/slider-types','as' =>'backend.constant-management.slider_types.'], function () {
    Route::get('index', ['uses' => 'SliderTypeController@index', 'as' => 'index']);
    Route::get('create', ['uses' => 'SliderTypeController@create', 'as' => 'create']);
    Route::post('store', ['uses' => 'SliderTypeController@store', 'as' => 'store']);
    Route::get('edit/{slider_type}', ['uses' => 'SliderTypeController@edit', 'as' => 'edit']);
    Route::post('update/{slider_type}', ['uses' => 'SliderTypeController@update', 'as' => 'update']);
    Route::get('delete/{slider_type}', ['uses' => 'SliderTypeController@destroy', 'as' => 'destroy']);
}); 


// Use to Show Proposals In Admin Panal
Route::group(['middleware' => 'can:manage_dev','prefix' => 'backend/constant-management/proposals', 'as' => 'backend.constant-management.proposals.'], function () {
    Route::get('/index', [ProposalController::class,'adminView'])->name('index');
    Route::get('/deleteDraft/{userId}', [ProposalController::class,'deleteDrafts'])->name('deleteDraft');
});



// Create and Manage coupons
Route::group(['middleware' => 'can:manage_dev','prefix' => 'backend/admin/coupons', 'as' => 'backend.admin.coupons.'], function () {
    Route::get('/index', [couponsController::class,'index'])->name('index');
    Route::post('/store', [couponsController::class,'store'])->name('store');
});
Route::get('backend/admin/coupons/usecoupon', [couponsController::class,'usecoupon'])->name('backend.admin.coupons.use');


// Manage Short Urls and Add URL
Route::group(['middleware' => 'can:manage_dev','prefix' => '/panel/short_url', 'as' => 'panel.short_url.'], function () {
    Route::get('/',[WebsiteController::class,'manageurl'])->name('manage_url');
    Route::post('/',[WebsiteController::class,'manageurl'])->name('searchurl');
    Route::get('/edit/{id}',[WebsiteController::class,'editurl'])->name('edit_url');
    Route::post('/update/{id}',[WebsiteController::class,'updateurl'])->name('update_url');
    Route::get('/delete/{id}',[WebsiteController::class,'deleteurl'])->name('delete_url');
    Route::post('/create',[WebsiteController::class,'createurl'])->name('create_url');

});

Route::group(['middleware' => 'auth','namespace' => 'Backend\ConstantManagement', 'prefix' => 'backend/constant-management/sliders','as' =>'backend.constant-management.sliders.'], function () {
    Route::get('index', ['uses' => 'SliderController@index', 'as' => 'index']);
    Route::get('create', ['uses' => 'SliderController@create', 'as' => 'create']);
    Route::post('store', ['uses' => 'SliderController@store', 'as' => 'store']);
    Route::get('edit/{slider}', ['uses' => 'SliderController@edit', 'as' => 'edit']);
    Route::post('update/{slider}', ['uses' => 'SliderController@update', 'as' => 'update']);
    Route::get('delete/{slider}', ['uses' => 'SliderController@destroy', 'as' => 'destroy']);
}); 

    Route::group(['middleware' => 'auth','namespace' => 'Admin\ConstantManagement', 'prefix' => 'backend/constant-management/news-letters','as' =>'backend/constant-management.news_letters.'], function () {
        Route::get('index', ['uses' => 'NewsLetterController@index', 'as' => 'index']);
        Route::get('create', ['uses' => 'NewsLetterController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'NewsLetterController@store', 'as' => 'store']);
        Route::get('edit/{news_letter}', ['uses' => 'NewsLetterController@edit', 'as' => 'edit']);
        Route::post('update/{news_letter}', ['uses' => 'NewsLetterController@update', 'as' => 'update']);
        Route::get('delete/{news_letter}', ['uses' => 'NewsLetterController@destroy', 'as' => 'destroy']);
        Route::get('/launchcampaign', ['uses' => 'NewsLetterController@launchcampaignShow', 'as' => 'launchcampaign.show']);
        Route::post('launchcampaign', ['uses' => 'NewsLetterController@runCampaign', 'as' => 'run.campaign']);
    }); 
    

    Route::group(['middleware' => 'auth','namespace' => 'Admin', 'prefix' => 'backend/site-content-managements','as' =>'backend.site_content_managements.'], function () {
        Route::get('index', ['uses' => 'SiteContentManagementController@index', 'as' => 'index']);
        Route::get('create', ['uses' => 'SiteContentManagementController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'SiteContentManagementController@store', 'as' => 'store']);
        Route::get('edit/{site_content_management}', ['uses' => 'SiteContentManagementController@edit', 'as' => 'edit']);
        Route::post('update/{site_content_management}', ['uses' => 'SiteContentManagementController@update', 'as' => 'update']);
        Route::get('delete/{site_content_management}', ['uses' => 'SiteContentManagementController@destroy', 'as' => 'destroy']);
    }); 
    Route::group(['middleware' => 'auth','namespace' => 'Admin', 'prefix' => 'backend/constant-management/faqs','as' =>'backend/constant-management.faqs.'], function () {
        Route::get('index', ['uses' => 'FaqController@index', 'as' => 'index']);
        Route::get('create', ['uses' => 'FaqController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'FaqController@store', 'as' => 'store']);
        Route::get('edit/{faq}', ['uses' => 'FaqController@edit', 'as' => 'edit']);
        Route::post('update/{faq}', ['uses' => 'FaqController@update', 'as' => 'update']);
        Route::get('delete/{faq}', ['uses' => 'FaqController@destroy', 'as' => 'destroy']);
    });

Route::group(['middleware' => 'check_access_code','namespace' => 'Admin', 'prefix' => 'panel/orders','as' =>'panel.orders.'], function () {
    Route::get('', ['uses' => 'OrderController@index', 'as' => 'index']);
    Route::any('/print', ['uses' => 'OrderController@print', 'as' => 'print']);
    Route::get('create', ['uses' => 'OrderController@create', 'as' => 'create']);
    Route::post('store', ['uses' => 'OrderController@store', 'as' => 'store']);
    Route::post('status', ['uses' => 'OrderController@status', 'as' => 'status']);
    Route::get('/{order}', ['uses' => 'OrderController@show', 'as' => 'show']);
    Route::get('/status/{order}', ['uses' => 'OrderController@updateStatus', 'as' => 'update-status']);
    Route::get('/status/{order}/re-update/{s_id}', ['uses' => 'OrderController@reUpdateStatus', 'as' => 're-update-status']);
    Route::get('invoice/{order}', ['uses' => 'OrderController@invoice', 'as' => 'invoice']);
    Route::get('show/{order}', ['uses' => 'OrderController@show', 'as' => 'show']);
    Route::post('update/{order}', ['uses' => 'OrderController@update', 'as' => 'update']);
    Route::get('delete/{order}', ['uses' => 'OrderController@destroy', 'as' => 'destroy']);
});   

Route::group(['middleware' => 'check_access_code','namespace' => 'Panel', 'prefix' => 'panel/brands','as' =>'panel.brands.'], function () {
        Route::get('', ['uses' => 'BrandController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'BrandController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'BrandController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'BrandController@store', 'as' => 'store']);
        Route::get('/{brand}', ['uses' => 'BrandController@show', 'as' => 'show']);
        Route::get('edit/{brand}', ['uses' => 'BrandController@edit', 'as' => 'edit']);
        Route::post('update/details/{brand}', ['uses' => 'BrandController@legalDetailsUpdate', 'as' => 'legal-details.update']);
        Route::post('update/{brand}', ['uses' => 'BrandController@update', 'as' => 'update']);
        Route::get('delete/{brand}', ['uses' => 'BrandController@destroy', 'as' => 'destroy']);
    }); 
    
    
Route::group(['middleware' => 'check_access_code','namespace' => 'Panel', 'prefix' => 'panel/products','as' =>'panel.products.'], function () {
        Route::get('', ['uses' => 'ProductController@index', 'as' => 'index']);
        Route::get('inventory', ['uses' => 'ProductController@inventoryIndex', 'as' => 'inventory.index']);
        Route::post('inventory/store', ['uses' => 'ProductController@inventoryStore', 'as' => 'inventory.store']);
        Route::get('inventory/edit/{product_id}', ['uses' => 'ProductController@inventoryEdit', 'as' => 'inventory.edit']);
        Route::get('/search', ['uses' => 'ProductController@search', 'as' => 'search']);
        Route::any('/print', ['uses' => 'ProductController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'ProductController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'ProductController@store', 'as' => 'store']);
        Route::get('/{product}', ['uses' => 'ProductController@show', 'as' => 'show']);
        Route::get('edit/{product}', ['uses' => 'ProductController@edit', 'as' => 'edit']);
        Route::get('clone/{product}', ['uses' => 'ProductController@clone', 'as' => 'clone']);
        Route::post('update/{product}', ['uses' => 'ProductController@update', 'as' => 'update']);
        Route::post('update/varient/{product}', ['uses' => 'ProductController@updateVarient', 'as' => 'update.varient']);
        Route::post('edit/api/varient', ['uses' => 'ProductController@editVarient', 'as' => 'varient']);
        Route::get('qr/request/', ['uses' => 'ProductController@getQrQuantity', 'as' => 'qr-request']);
        Route::post('update-sku/{product}', ['uses' => 'ProductController@updateSKU', 'as' => 'update-sku']);
        Route::get('delete/{product}', ['uses' => 'ProductController@destroy', 'as' => 'destroy']);
        Route::get('delete/product/image/{id}', ['uses' => 'ProductController@deleteImage', 'as' => 'deleteImage']);
        Route::get('/upload/qr/code', ['uses' => 'ProductController@updateProductSku', 'as' => 'update.qr']);
    }); 
        
Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/user-shops','as' =>'panel.user_shops.'], function () {
        Route::get('', ['uses' => 'UserShopController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'UserShopController@print', 'as' => 'print']);
        Route::get('printqr', ['uses' => 'UserShopController@printqr', 'as' => 'printqr']);
        Route::get('create', ['uses' => 'UserShopController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'UserShopController@store', 'as' => 'store']);
        Route::get('/{user_shop}', ['uses' => 'UserShopController@show', 'as' => 'show']);
        Route::get('edit/{user_shop}', ['uses' => 'UserShopController@edit', 'as' => 'edit']);        
        Route::post('update/{user_shop}', ['uses' => 'UserShopController@update', 'as' => 'update']);  
        Route::post('updateuser/{user_shop}', ['uses' => 'UserShopController@updateuserdetails', 'as' => 'updateuser']);
        Route::post('update/shop-view/{user_shop}', ['uses' => 'UserShopController@updateShopView', 'as' => 'update.shop-view']);
        Route::post('update/others/{user_shop}', ['uses' => 'UserShopController@otherFiledsUpdate', 'as' => 'other_fields.update']);
        Route::post('address/update/{user_shop}', ['uses' => 'UserShopController@Addressupdate', 'as' => 'address.update']);
        Route::post('about/{user_shop}', ['uses' => 'UserShopController@updateAbout', 'as' => 'about']);
        Route::post('contact/{user_shop}', ['uses' => 'UserShopController@updatecontact', 'as' => 'contact']);
        Route::post('story/{user_shop}', ['uses' => 'UserShopController@updateStory', 'as' => 'story']);
        Route::post('features/{user_shop}', ['uses' => 'UserShopController@updateFeatures', 'as' => 'features']);
        Route::get('delete/{user_shop}', ['uses' => 'UserShopController@destroy', 'as' => 'destroy']);
        Route::post('payments/{user_shop}', ['uses' => 'UserShopController@updatePayment', 'as' => 'payments']);
        Route::post('testimonial', ['uses' => 'UserShopController@updateTestimonial', 'as' => 'testimonial']);
        Route::post('products/{user_shop}', ['uses' => 'UserShopController@updateProductsSection', 'as' => 'products']);
        Route::get('remove-image/{user_shop}', ['uses' => 'UserShopController@removeImage', 'as' => 'remove-shop-image']);
    }); 
    

Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/groups','as' =>'panel.groups.'], function () {
        Route::get('', ['uses' => 'GroupController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'GroupController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'GroupController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'GroupController@store', 'as' => 'store']);
        Route::get('/{group}', ['uses' => 'GroupController@show', 'as' => 'show']);
        Route::get('edit/{group}', ['uses' => 'GroupController@edit', 'as' => 'edit']);
        Route::post('update/{group}', ['uses' => 'GroupController@update', 'as' => 'update']);
        Route::get('delete/{group}', ['uses' => 'GroupController@destroy', 'as' => 'destroy']);
    }); 
    
    

Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/group-users','as' =>'panel.group_users.'], function () {
        Route::get('', ['uses' => 'GroupUserController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'GroupUserController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'GroupUserController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'GroupUserController@store', 'as' => 'store']);
        Route::get('/{group_user}', ['uses' => 'GroupUserController@show', 'as' => 'show']);
        Route::get('edit/{group_user}', ['uses' => 'GroupUserController@edit', 'as' => 'edit']);
        Route::post('update/{group_user}', ['uses' => 'GroupUserController@update', 'as' => 'update']);
        Route::get('delete/{group_user}', ['uses' => 'GroupUserController@destroy', 'as' => 'destroy']);
    }); 
    
    

Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/group-products','as' =>'panel.group_products.'], function () {
        Route::get('', ['uses' => 'GroupProductController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'GroupProductController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'GroupProductController@create', 'as' => 'create']);
        Route::get('api-qr', ['uses' => 'GroupProductController@apiQr', 'as' => 'api.qr']);
        Route::post('store', ['uses' => 'GroupProductController@store', 'as' => 'store']);
        Route::get('/{group_product}', ['uses' => 'GroupProductController@show', 'as' => 'show']);
        Route::get('edit/{group_product}', ['uses' => 'GroupProductController@edit', 'as' => 'edit']);
        Route::post('update', ['uses' => 'GroupProductController@update', 'as' => 'update']);
        Route::get('delete/{group_product}', ['uses' => 'GroupProductController@destroy', 'as' => 'destroy']);
    }); 
    
     

Route::group(['middleware' => 'check_access_code','namespace' => 'Panel', 'prefix' => 'panel/user-shop-items','as' =>'panel.user_shop_items.'], function () {
        Route::get('', ['uses' => 'UserShopItemController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'UserShopItemController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'UserShopItemController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'UserShopItemController@store', 'as' => 'store']);
        Route::post('add/bulk', ['uses' => 'UserShopItemController@addBulk', 'as' => 'addbulk']);
        Route::post('remove/bulk', ['uses' => 'UserShopItemController@removebulk', 'as' => 'removebulk']);

        Route::get('api-addpin', ['uses' => 'UserShopItemController@addpin', 'as' => 'api.addpinonsie']);
        Route::get('api-removepin', ['uses' => 'UserShopItemController@removepin', 'as' => 'api.removepinonsie']);


        Route::get('/{user_shop_item}', ['uses' => 'UserShopItemController@show', 'as' => 'show']);
        Route::get('edit/{user_shop_item}', ['uses' => 'UserShopItemController@edit', 'as' => 'edit']);
        Route::get('remove/{pid}/{uid}', ['uses' => 'UserShopItemController@remove', 'as' => 'remove']);
        Route::get('get/subcategory', ['uses' => 'UserShopItemController@getSubcategory', 'as' => 'get-category']);
        Route::post('update/{user_shop_item}', ['uses' => 'UserShopItemController@update', 'as' => 'update']);
        Route::post('update121/{user_shop_item}', ['uses' => 'UserShopItemController@update121', 'as' => 'update121']);
  
        Route::get('update/product', ['uses' => 'UserShopItemController@updateproductshow', 'as' => 'update.product']);
        // Go to Panel.php For Post Route of Bulk 121 Product Changes Upload

        Route::post('add/images', ['uses' => 'UserShopItemController@addImages', 'as' => 'add.images']);
        Route::get('upload/bulk/images/', ['uses' => 'UserShopItemController@uploadBulkImage', 'as' => 'upload.bulk.image']);
        Route::post('update/media/images', ['uses' => 'UserShopItemController@updateMedia', 'as' => 'update.media.items']);
        Route::get('delete/{user_shop_item}', ['uses' => 'UserShopItemController@destroy', 'as' => 'destroy']);
        Route::get('update/product', ['uses' => 'UserShopItemController@updateproductshow', 'as' => 'update.product']);
        // Go to Panel.php For Post Route of Bulk 121 Product Changes Upload
    }); 
    
    

Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/medias','as' =>'panel.medias.'], function () {
        Route::get('', ['uses' => 'MediaController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'MediaController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'MediaController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'MediaController@store', 'as' => 'store']);
        Route::get('/{media}', ['uses' => 'MediaController@show', 'as' => 'show']);
        Route::get('edit/{media}', ['uses' => 'MediaController@edit', 'as' => 'edit']);
        Route::post('update/{media}', ['uses' => 'MediaController@update', 'as' => 'update']);
        Route::get('delete/{media}', ['uses' => 'MediaController@destroy', 'as' => 'destroy']);
    }); 
    
    

Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/packages','as' =>'panel.packages.'], function () {
        Route::get('', ['uses' => 'PackageController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'PackageController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'PackageController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'PackageController@store', 'as' => 'store']);
        Route::get('/{package}', ['uses' => 'PackageController@show', 'as' => 'show']);
        Route::get('edit/{package}', ['uses' => 'PackageController@edit', 'as' => 'edit']);
        Route::post('update/{package}', ['uses' => 'PackageController@update', 'as' => 'update']);
        Route::get('delete/{package}', ['uses' => 'PackageController@destroy', 'as' => 'destroy']);
    }); 
    
    

Route::group(['middleware' => 'is.admin','namespace' => 'Panel', 'prefix' => 'panel/access-codes','as' =>'panel.access_codes.'], function () {
        Route::get('', ['uses' => 'AccessCodeController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'AccessCodeController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'AccessCodeController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'AccessCodeController@store', 'as' => 'store']);
        Route::get('/{access_code}', ['uses' => 'AccessCodeController@show', 'as' => 'show']);
        Route::get('edit/{access_code}', ['uses' => 'AccessCodeController@edit', 'as' => 'edit']);
        Route::post('generate/code', ['uses' => 'AccessCodeController@codeGenerator', 'as' => 'generate-code']);
        Route::post('update/{access_code}', ['uses' => 'AccessCodeController@update', 'as' => 'update']);
        Route::get('delete/{access_code}', ['uses' => 'AccessCodeController@destroy', 'as' => 'destroy']);
    }); 

    Route::group(['middleware' => 'auth','prefix' => 'panel/report','as' =>'panel.report.'], function () {
        Route::get('/access_code', ['uses' => 'Admin\ReportController@accessCode', 'as' => 'access-code']);
        Route::any('/user_packages', ['uses' => 'Admin\ReportController@userPackages', 'as' => 'user-packages']);
        Route::get('/user_acquisition', ['uses' => 'Admin\ReportController@userAcquisition', 'as' =>
        'user-acquisition']);
    }); 
    
    

Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/user-packages','as' =>'panel.user_packages.'], function () {
        Route::get('/', ['uses' => 'UserPackageController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'UserPackageController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'UserPackageController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'UserPackageController@store', 'as' => 'store']);
        Route::get('/{user_package}', ['uses' => 'UserPackageController@show', 'as' => 'show']);
        Route::get('edit/{user_package}', ['uses' => 'UserPackageController@edit', 'as' => 'edit']);
        Route::post('update/{user_package}', ['uses' => 'UserPackageController@update', 'as' => 'update']);
        Route::get('delete/{user_package}', ['uses' => 'UserPackageController@destroy', 'as' => 'destroy']);
    }); 
    
    

Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/product-attributes','as' =>'panel.product_attributes.'], function () {
        Route::get('', ['uses' => 'ProductAttributeController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'ProductAttributeController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'ProductAttributeController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'ProductAttributeController@store', 'as' => 'store']);
        Route::get('/{product_attribute}', ['uses' => 'ProductAttributeController@show', 'as' => 'show']);
        Route::get('edit/{product_attribute}', ['uses' => 'ProductAttributeController@edit', 'as' => 'edit']);
        Route::post('update/{product_attribute}', ['uses' => 'ProductAttributeController@update', 'as' => 'update']);
        Route::get('delete/{product_attribute}', ['uses' => 'ProductAttributeController@destroy', 'as' => 'destroy']);
    }); 
    
    

Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/carts','as' =>'panel.carts.'], function () {
        Route::get('', ['uses' => 'CartController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'CartController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'CartController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'CartController@store', 'as' => 'store']);
        Route::get('/{cart}', ['uses' => 'CartController@show', 'as' => 'show']);
        Route::get('edit/{cart}', ['uses' => 'CartController@edit', 'as' => 'edit']);
        Route::post('update/{cart}', ['uses' => 'CartController@update', 'as' => 'update']);
        Route::get('delete/{cart}', ['uses' => 'CartController@destroy', 'as' => 'destroy']);
    }); 
    Route::group(['middleware' => 'check_access_code','namespace' => 'Panel', 'prefix' => 'panel/proposals','as' =>'panel.proposals.'], function () {
        Route::get('', ['uses' => 'ProposalController@index', 'as' => 'index']);
       
        Route::any('/print', ['uses' => 'ProposalController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'ProposalController@create', 'as' => 'create']);
        Route::get('sent/{proposal}', ['uses' => 'ProposalController@sent', 'as' => 'sent']);
        Route::post('store', ['uses' => 'ProposalController@store', 'as' => 'store']);
        Route::get('/{proposal}', ['uses' => 'ProposalController@show', 'as' => 'show']);
        Route::get('edit/{proposal}', ['uses' => 'ProposalController@edit', 'as' => 'edit']);
        Route::post('update/{proposal}', ['uses' => 'ProposalController@update', 'as' => 'update']);
        Route::post('update/{proposal}/price', ['uses' => 'ProposalController@updatePrice', 'as' => 'update-price']);
        Route::get('delete/{proposal}', ['uses' => 'ProposalController@destroy', 'as' => 'destroy']);
        Route::get('remove-image/{proposal}', ['uses' => 'ProposalController@removeImage', 'as' => 'remove-image']);
    }); 

    Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/proposal-items','as' =>'panel.proposal_items.'], function () {
        Route::get('', ['uses' => 'ProposalItemController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'ProposalItemController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'ProposalItemController@create', 'as' => 'create']);
        Route::post('update/sequence/{proposal_id}', ['uses' => 'ProposalItemController@updateSequence']);
        Route::get('api-store', ['uses' => 'ProposalItemController@apiStore', 'as' => 'api.store']);
        Route::get('api-addpin', ['uses' => 'ProposalItemController@addpin', 'as' => 'api.addpin']);
        Route::get('api-removepin', ['uses' => 'ProposalItemController@removepin', 'as' => 'api.removepin']);
        Route::get('setmargin', ['uses' => 'ProposalItemController@setmargin', 'as' => 'api.setmargin']);
        Route::get('api-remove', ['uses' => 'ProposalItemController@apiRemove', 'as' => 'api.remove']);
        Route::post('store', ['uses' => 'ProposalItemController@store', 'as' => 'store']);
        Route::get('/{proposal_item}', ['uses' => 'ProposalItemController@show', 'as' => 'show']);
        Route::get('edit/{proposal_item}', ['uses' => 'ProposalItemController@edit', 'as' => 'edit']);
        Route::post('update/{proposal_item}', ['uses' => 'ProposalItemController@update', 'as' => 'update']);
        Route::get('delete/{proposal_item}', ['uses' => 'ProposalItemController@destroy', 'as' => 'destroy']);
    });
    
    

Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/user-shop-testimonals','as' =>'panel.user_shop_testimonals.'], function () {
        Route::get('', ['uses' => 'UserShopTestimonalController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'UserShopTestimonalController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'UserShopTestimonalController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'UserShopTestimonalController@store', 'as' => 'store']);
        Route::get('/{user_shop_testimonal}', ['uses' => 'UserShopTestimonalController@show', 'as' => 'show']);
        Route::get('edit/{user_shop_testimonal}', ['uses' => 'UserShopTestimonalController@edit', 'as' => 'edit']);
        Route::post('update/{user_shop_testimonal}', ['uses' => 'UserShopTestimonalController@update', 'as' => 'update']);
        Route::get('delete/{user_shop_testimonal}', ['uses' => 'UserShopTestimonalController@destroy', 'as' => 'destroy']);
    }); 
    
    

Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/teams','as' =>'panel.teams.'], function () {
        Route::get('', ['uses' => 'TeamController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'TeamController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'TeamController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'TeamController@store', 'as' => 'store']);
        Route::get('/{team}', ['uses' => 'TeamController@show', 'as' => 'show']);
        Route::get('edit/{team}', ['uses' => 'TeamController@edit', 'as' => 'edit']);
        Route::post('update/{team}', ['uses' => 'TeamController@update', 'as' => 'update']);
        Route::post('user-shops/update', ['uses' => 'TeamController@userShopTeamUpdate', 'as' => 'user-shops.update']);
        Route::get('delete/{team}', ['uses' => 'TeamController@destroy', 'as' => 'destroy']);
    }); 
    
    

Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/price-ask-requests','as' =>'panel.price_ask_requests.'], function () {
        Route::get('', ['uses' => 'PriceAskRequestController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'PriceAskRequestController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'PriceAskRequestController@create', 'as' => 'create']);
        Route::get('{pid}/create/order/', ['uses' => 'PriceAskRequestController@customOrderCreate', 'as' => 'custom-order.create']);
        Route::post('create-custom-order', ['uses' => 'PriceAskRequestController@customOrder', 'as' => 'custom_order']);
        Route::post('store', ['uses' => 'PriceAskRequestController@store', 'as' => 'store']);
        Route::get('item/status/{id}/{s}', ['uses' => 'PriceAskRequestController@itemStatus', 'as' => 'item.status']);
        Route::post('item/store', ['uses' => 'PriceAskRequestController@itemStore', 'as' => 'item.store']);
        Route::get('/{price_ask_request}', ['uses' => 'PriceAskRequestController@show', 'as' => 'show']);
        Route::get('edit/{price_ask_request}', ['uses' => 'PriceAskRequestController@edit', 'as' => 'edit']);
        Route::get('show/{price_ask_request}', ['uses' => 'PriceAskRequestController@show', 'as' => 'show']);
        Route::get('status/{price_ask_request}', ['uses' => 'PriceAskRequestController@status', 'as' => 'status']);
        Route::post('update/{price_ask_request}', ['uses' => 'PriceAskRequestController@update', 'as' => 'update']);
        Route::get('delete/{price_ask_request}', ['uses' => 'PriceAskRequestController@destroy', 'as' => 'destroy']);
    }); 

Route::group(['middleware' => 'check_access_code','namespace' => 'Panel', 'prefix' => 'panel/filemanager','as' =>'panel.filemanager.'], function () {
        Route::get('', ['uses' => 'FileManager@index', 'as' => 'index']);
}); 
    
    

