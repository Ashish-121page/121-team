<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\BulkController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\BrandUserController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\AccessCatalogueRequest;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\Admin\ConstantManagement\MailSmsTemplateController;
use App\Http\Controllers\Admin\ConstantManagement\CategoryTypeController;
use App\Http\Controllers\Admin\ConstantManagement\CategoryController;
use App\Http\Controllers\Admin\ConstantManagement\UserEnquiryController;
use App\Http\Controllers\Admin\ConstantManagement\LocationController;
use App\Http\Controllers\Admin\ConstantManagement\ArticleController;
use App\Http\Controllers\Admin\ConstantManagement\ContentGroupController;
use App\Http\Controllers\Admin\ConstantManagement\NotificationController;
use App\Http\Controllers\Admin\Manage\EnquiryController;
use App\Http\Controllers\Admin\Manage\TicketConversationController;
use App\Http\Controllers\Admin\Manage\LeadController;
use App\Http\Controllers\Admin\Manage\UserNoteController;
use App\Http\Controllers\Admin\Manage\ContactController;
use App\Http\Controllers\Admin\EmailComposerController;
use App\Http\Controllers\Backend\CaseWorkstreamController;
use App\Http\Controllers\Backend\CaseWorkstreamParticipantController;
use App\Http\Controllers\Backend\CaseWorkstreamMessageController;
use App\Http\Controllers\Backend\CaseWorkstreamAttachmentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\invoiceController;
use App\Http\Controllers\NewBulkController;
use App\Http\Controllers\Panel\ProposalController;
use App\Http\Controllers\Panel\UserShopItemController;
use App\Http\Controllers\Panel\ImageController;
use App\Http\Controllers\settingController;
use App\Http\Controllers\UserAddressController;
use App\Models\UserShopItem;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|'
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::group(['middleware' => 'auth','prefix' => 'panel', 'as' => 'panel.'], function () {
Route::group(['middleware' => 'auth','prefix' => 'panel', 'as' => 'panel.'], function () {
    // Backend Route Start-------------------------------------------------------------------------------------
    Route::get('/clear-cache', [HomeController::class,'clearCache']);
    Route::get('/logout-as', [HomeController::class,'logoutAs'])->name('auth.logout-as');
    Route::get('/view-notification/{notification}', [NotificationController::class,'show'])->name('notification.read');
    Route::get('/profile', function () {
        return view('user.profile');
    });
    // Route::get('/invoice', function () {
    //     return view('pages.invoice');
    // });
        Route::group([ 'namespace' => 'Admin\Manage','prefix' => 'admin/manage/enquiry', 'as' => 'admin.enquiry.'], function () {

            Route::post('/api/token', [EnquiryController::class,'token'])->name('api.token');
            Route::post('/api/sendmessage', [EnquiryController::class,'sendMessage'])->name('api.sendMessage');
        });
    // dashboard route
    Route::get('/dashboard', [HomeController::class,'dashboard'])->name('dashboard');


    //only those have manage_user permission will get access
    Route::group(['namespace' => 'Admin\Message','middleware' => 'can:manage_chats','prefix' => 'chats','as' =>'chats.'], function () {
        Route::get('index', ['uses' => 'ChatController@index', 'as' => 'index']);
    });



    //only those have manage_user permission will get access
    Route::group(['middleware' => 'can:access_by_brand','prefix' => 'brands','as' =>'brands.'], function () {
        Route::group(['prefix' => 'products','as' =>'products.'], function () {
            Route::get('/', ['uses' => 'Panel\BrandController@ProductIndex', 'as' => 'index']);
            Route::get('/create', ['uses' => 'Panel\BrandController@ProductCreate', 'as' => 'create']);
            Route::post('/store', ['uses' => 'Panel\BrandController@Productstore', 'as' => 'store']);
        });
        Route::post('/legal', ['uses' => 'Panel\BrandController@legalPage', 'as' => 'legal-page.index']);
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/user-profile', [UserController::class,'profile']);
        Route::get('/send-otp', [UserController::class,'sendOTP'])->name('user.send-otp');
        Route::get('/verify-otp', [UserController::class,'verifyOTP'])->name('user.verify-otp');
        Route::post('/update/number', [UserController::class,'updateAdditionalNumber'])->name('user.update-numbers');
        Route::get('/delete/number/{user_id}/{number}', [UserController::class,'deleteAdditionalNumber'])->name('user.number.delete');
        // CHECK HAS ACCESS CODE OR NOT USING MIDDLEWARE
        // Route::get('/subscription', [UserController::class,'subscription'])->name('subscription.index')->middleware('check_access_code');
        Route::get('/subscription', [UserController::class,'subscription'])->name('subscription.index');

        Route::post('/user/update-profile/{id}', [UserController::class,'updateProfile'])->name('update-user-profile');
        Route::post('/user/profile-update/{id}', [UserController::class,'updateProfileImage'])->name('update-profile-img');


        Route::get('/addphone', [UserController::class,'upaddphone'])->name('user.addphone');


        Route::post('/user/password-update/{id}', [UserController::class,'updatePassword'])->name('update-password');
        Route::post('/verify-ekyc', [UserController::class,'ekycVerify'])->name('verify-ekyc');
        Route::get('/support_ticket', [SupportTicketController::class,'supportTicket'])->name('support_ticket.index');
        Route::post('/support_ticket', ['uses' => 'SupportTicketController@Store', 'as' => 'support_ticket.store']);
    });

    Route::group(['middleware' => 'can:manage_user'], function () {
        Route::get('/users/index/{role?}', [UserController::class,'index'])->name('users.index');
        Route::any('/users-print', [UserController::class,'print'])->name('users.print');
        Route::get('/user/create', [UserController::class,'create'])->name('users.create');
        Route::post('/user/create', [UserController::class,'store'])->name('create-user');

        Route::get('/user/bulk', [UserController::class,'bulkuserimportshow'])->name('create.user.bulk');
        Route::post('/user/bulk', [BulkController::class,'bulkuserimportadd'])->name('create.user.bulk');


        Route::get('/user/{id}', [UserController::class,'edit']);
        Route::post('/user/update/{id}', [UserController::class,'update'])->name('update-user');
        Route::post('/user/update', [UserController::class,'update']);
        Route::get('/user/delete/{id}', [UserController::class,'delete']);
        Route::get('/user/login-as/{id}', [UserController::class,'loginAs']);
        Route::get('/user/status/{id}/{s}', [UserController::class,'status'])->name('user.status.update');
        Route::get('/user-log/{u_id}/{role?}', [UserController::class,'userlog'])->name('user_log.index');
        Route::post('/ekyc-status', [UserController::class,'updateEkycStatus'])->name('update-ekyc-status');
    });
    Route::get('/users-show/{id?}', [UserController::class,'userShow'])->name('users.show');

    Route::post('', 'ProfileController@updatePassword')->name('backend.password.update');
    //only those have manage_role permission will get access
    Route::group(['middleware' => 'can:manage_role'], function () {
        Route::get('/roles', [RolesController::class,'index'])->name('roles');
        Route::post('/role/create', [RolesController::class,'create']);
        Route::get('/role/edit/{id}', [RolesController::class,'edit']);
        Route::post('/role/update', [RolesController::class,'update']);
        Route::get('/role/delete/{id}', [RolesController::class,'delete']);
    });


    //only those have manage_permission permission will get access
    Route::group(['middleware' => 'can:manage_permission'], function () {
        Route::get('/permission', [PermissionController::class,'index'])->name('permission');
        Route::post('/permission/create', [PermissionController::class,'create']);
        Route::get('/permission/update', [PermissionController::class,'update']);
        Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
    });



    // get permissions
    Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);

    Route::group(['namespace' => 'Admin\WebsiteSetting','middleware' => 'can:manage_setting', 'prefix' => 'website-setting', 'as' => 'website_setting.'], function () {
        Route::get('header', ['uses' => 'HeaderController@index', 'as' => 'header']);
        Route::post('header', ['uses' => 'HeaderController@storeHeader', 'as' => 'header.store']);

        Route::get('footer', ['uses' => 'FooterController@index', 'as' => 'footer']);
        Route::post('footer-about', ['uses' => 'FooterController@storeAbout', 'as' => 'footer.about.store']);
        Route::post('footer-contact', ['uses' => 'FooterController@storeContact', 'as' => 'footer.contact.store']);
        Route::post('footer-links', ['uses' => 'FooterController@storeFooterLinks', 'as' => 'footer.links.store']);
        Route::post('footer-bottom', ['uses' => 'FooterController@storeFooterBottom', 'as' => 'footer.bottom.store']);

        Route::get('pages', ['uses' => 'PagesController@index', 'as' => 'pages']);
        Route::post('pages/print', ['uses' => 'PagesController@print', 'as' => 'pages.print']);
        Route::get('pages/create', ['uses' => 'PagesController@createPage', 'as' => 'pages.create']);
        Route::post('pages', ['uses' => 'PagesController@storePages', 'as' => 'pages.store']);
        Route::get('pages/edit/{id}', ['uses' => 'PagesController@editPage', 'as' => 'pages.edit']);
        Route::post('pages/update/{id}', ['uses' => 'PagesController@updatePage', 'as' => 'pages.update']);
        Route::get('pages/delete/{id}', ['uses' => 'PagesController@destroy', 'as' => 'pages.delete']);
        Route::post('home-update', ['uses' => 'PagesController@storeHome', 'as' => 'home.store']);

        Route::get('appearance', ['uses' => 'AppearanceController@index', 'as' => 'appearance']);
        Route::post('theme-store', ['uses' => 'AppearanceController@storeTheme', 'as' => 'theme.store']);
        Route::post('seo-store', ['uses' => 'AppearanceController@storeSeo', 'as' => 'seo.store']);
        Route::post('cookies-store', ['uses' => 'AppearanceController@storeCookies', 'as' => 'cookies.store']);
        Route::post('script-store', ['uses' => 'AppearanceController@storeCustomScript', 'as' => 'script.store']);
        Route::post('style-store', ['uses' => 'AppearanceController@storeCustomStyles', 'as' => 'style.store']);


        Route::get('social-login', ['uses' => 'SocialLoginController@index', 'as' => 'social-login']);
        Route::post('social-login', ['uses' => 'SocialLoginController@store', 'as' => 'social-login.store']);
    });

    Route::group(['namespace' => 'Admin\Setting','middleware' => 'can:manage_setting', 'prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::get('general', ['uses' => 'GeneralController@index', 'as' => 'general']);
        Route::get('storage-link', ['uses' => 'GeneralController@storageLink', 'as' => 'storage_link']);
        Route::get('optimize-clear', ['uses' => 'GeneralController@OptimizeClear', 'as' => 'optimize_clear']);
        Route::get('backup', ['uses' => 'GeneralController@backup', 'as' => 'backup']);
        Route::post('general', ['uses' => 'GeneralController@storeGeneral', 'as' => 'general.store']);
        Route::post('currency', ['uses' => 'GeneralController@storeCurrency', 'as' => 'currency.store']);
        Route::post('verification', ['uses' => 'GeneralController@storeVerification', 'as' => 'verification.store']);
        Route::post('dnt', ['uses' => 'GeneralController@storeDnT', 'as' => 'dnt.store']);
        Route::post('plugin', ['uses' => 'GeneralController@storePlugin', 'as' => 'plugin.store']);

        Route::get('mail', ['uses' => 'MailController@index', 'as' => 'mail']);
        Route::post('mail', ['uses' => 'MailController@storeMail', 'as' => 'mail.store']);
        Route::post('sms', ['uses' => 'MailController@storeSMS', 'as' => 'sms.store']);
        Route::post('test', ['uses' => 'MailController@testSend', 'as' => 'test.send']);
        Route::post('notification', ['uses' => 'MailController@storePushNotification', 'as' => 'notification.store']);

        Route::get('payment', ['uses' => 'PaymentSettingController@index', 'as' => 'payment']);
        Route::post('payment', ['uses' => 'PaymentSettingController@storePayment', 'as' => 'payment.store']);

        Route::get('registration', ['uses' => 'SettingController@registration', 'as' => 'registration']);
        Route::post('registration', ['uses' => 'SettingController@registrationStore', 'as' => 'registration.store']);
    });

    Route::group(['namespace' => 'Admin\ConstantManagement','prefix' => 'constant-management', 'as' => 'constant_management.'], function () {

        Route::group(['middleware' => 'can:manage_category', 'prefix' => 'category', 'as' => 'category.'], function () {

            Route::get('/view/{type_id}', [CategoryController::class,'index'])->name('index');
            Route::get('/check/global', [CategoryController::class,'checkglobal'])->name('check.global');
            Route::get('/create/{type_id}/{level?}/{parent_id?}', [CategoryController::class,'create'])->name('create');
            Route::post('/store', [CategoryController::class,'store'])->name('store');
            Route::get('/edit/{id}', [CategoryController::class,'edit'])->name('edit');
            Route::get('/show/{id}', [CategoryController::class,'show'])->name('show');
            Route::get('/changeshow', [CategoryController::class,'changeshow'])->name('change');
            Route::post('/change', [CategoryController::class,'change'])->name('changeup');
            Route::post('/update/{id}', [CategoryController::class,'update'])->name('update');
            Route::get('/delete/{id}', [CategoryController::class,'destroy'])->name('delete');
            Route::any('/select/Global/{user_id}', [CategoryController::class,'selectglobalCategory'])->name('select.global');
            Route::post('bulk/delete/{user_id}', [CategoryController::class,'bulkdelete'])->name('bulk.delete');
            Route::get('update/Ajax/',[CategoryController::class,'updateAjax'])->name('update.ajax');
            Route::post('rename/{user}',[CategoryController::class,'renamecat'])->name('rename');
        });


    });
    Route::group(['middleware' => 'auth', 'prefix' => 'constant-management/notification', 'as' => 'constant_management.notification.'], function () {
        Route::get('/', [NotificationController::class,'index'])->name('index');
        Route::get('/read-all', [NotificationController::class,'seeAllNotification'])->name('readall');
    });


    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('/{user}', [settingController::class,'index'])->name('index');
        Route::get('makedefaultTemplate/{user}{template}', [settingController::class,'makedefaultTemplate'])->name('make.default.Template');
        Route::post('offer/banner', [settingController::class,'uploadbanner'])->name('upload.banner');
        Route::get('edit/Template/{template}', [settingController::class,'EditTemplate'])->name('edit.Template');
        Route::post('custom/fields', [settingController::class,'customfields'])->name('custom.fields');
        Route::get('/add-details', [settingController::class,'addDetails'])->name('add-details');

        Route::post('update/custom/fields', [settingController::class,'Updatecustomfields'])->name('update.custom.fields');
        Route::get('remove/custom/fields/{fieldId}', [settingController::class,'removecustomfields'])->name('remove.custom.fields');


        Route::post('quot/setting', [settingController::class,'updateQuotsetting'])->name('quot.setting');



    });


    Route::group(['namespace' => 'Admin\ConstantManagement','middleware' => 'can:manage_setting', 'prefix' => 'constant-management', 'as' => 'constant_management.'], function () {
        Route::group(['middleware' => 'can:manage_setting', 'prefix' => 'mail-sms-template', 'as' => 'mail_sms_template.'], function () {
            Route::get('/', [MailSmsTemplateController::class,'index'])->name('index');
            Route::get('/create', [MailSmsTemplateController::class,'create'])->name('create');
            Route::post('/store', [MailSmsTemplateController::class,'store'])->name('store');
            Route::get('/edit/{id}', [MailSmsTemplateController::class,'edit'])->name('edit');
            Route::get('/show/{id}', [MailSmsTemplateController::class,'show'])->name('show');
            Route::post('/update/{id}', [MailSmsTemplateController::class,'update'])->name('update');
            Route::get('/delete/{id}', [MailSmsTemplateController::class,'destroy'])->name('delete');
        });

           Route::group(['middleware' => 'can:manage_category_type', 'prefix' => 'category-type', 'as' => 'category_type.'], function () {
                Route::get('/', [CategoryTypeController::class,'index'])->name('index');
                Route::get('/create', [CategoryTypeController::class,'create'])->name('create');
                Route::post('/store', [CategoryTypeController::class,'store'])->name('store');
                Route::get('/edit/{id}', [CategoryTypeController::class,'edit'])->name('edit');
                Route::get('/show/{id}', [CategoryTypeController::class,'show'])->name('show');
                Route::post('/update/{id}', [CategoryTypeController::class,'update'])->name('update');
                Route::get('/delete/{id}', [CategoryTypeController::class,'destroy'])->name('delete');
            });

        Route::group(['middleware' => 'can:manage_user_enquiry', 'prefix' => 'user-enquiry', 'as' => 'user_enquiry.'], function () {
            Route::get('/', [UserEnquiryController::class,'index'])->name('index');
            Route::get('/create', [UserEnquiryController::class,'create'])->name('create');
            Route::post('/store', [UserEnquiryController::class,'store'])->name('store');
            Route::get('/edit/{id}', [UserEnquiryController::class,'edit'])->name('edit');
            Route::get('/show/{id}', [UserEnquiryController::class,'show'])->name('show');
            Route::post('/update/{id}', [UserEnquiryController::class,'update'])->name('update');
            Route::get('/delete/{id}', [UserEnquiryController::class,'destroy'])->name('delete');
        });


        Route::group(['middleware' => 'can:manage_article', 'prefix' => 'article', 'as' => 'article.'], function () {
            Route::get('/', [ArticleController::class,'index'])->name('index');
            Route::any('/print', [ArticleController::class,'print'])->name('print');
            Route::get('/create', [ArticleController::class,'create'])->name('create');
            Route::post('/store', [ArticleController::class,'store'])->name('store');
            Route::get('/edit/{id}', [ArticleController::class,'edit'])->name('edit');
            Route::get('/show/{id}', [ArticleController::class,'show'])->name('show');
            Route::post('/update/{id}', [ArticleController::class,'update'])->name('update');
            Route::get('/delete/{id}', [ArticleController::class,'destroy'])->name('delete');
        });
        Route::group(['middleware' => 'can:manage_setting', 'prefix' => 'location', 'as' => 'location.'], function () {
            Route::get('/', [LocationController::class,'country'])->name('country');
            Route::get('/create', [LocationController::class,'create'])->name('create');
            Route::post('/store', [LocationController::class,'store'])->name('store');
            Route::get('/edit/{id}', [LocationController::class,'edit'])->name('edit');
            Route::get('/show/{id}', [LocationController::class,'show'])->name('show');
            Route::post('/update/{id}', [LocationController::class,'update'])->name('update');
            Route::get('/state', [LocationController::class,'state'])->name('state');
            Route::post('/state/store', [LocationController::class,'stateStore'])->name('state.store');
            Route::post('/state/update', [LocationController::class,'stateUpdate'])->name('state.update');
            Route::get('/city', [LocationController::class,'city'])->name('city');
            Route::post('/city/store', [LocationController::class,'cityStore'])->name('city.store');
            Route::post('/city/update', [LocationController::class,'cityUpdate'])->name('city.update');
            Route::get('/delete/{id}', [LocationController::class,'destroy'])->name('delete');
        });


        Route::group(['middleware' => 'can:manage_article', 'prefix' => 'support_ticket', 'as' => 'support_ticket.'],
        function () {
            Route::get('/', [SupportTicketController::class,'AdminIndex'])->name('index');
            Route::get('show/{id}', [SupportTicketController::class,'AdminShow'])->name('show');
            Route::post('/reply', [SupportTicketController::class,'reply'])->name('reply');
            Route::get('/update-status/{ticket_id}/{status}', [SupportTicketController::class,'updateStatus'])->name('status');
        });
    });
    Route::group(['namespace' => 'Admin\Manage','middleware' => 'check_access_code', 'prefix' => 'admin/manage', 'as' => 'admin.'], function () {
        Route::group(['middleware' => 'can:manage_enquiry', 'prefix' => 'enquiry', 'as' => 'enquiry.'], function () {
            Route::get('/', [EnquiryController::class,'index'])->name('index');
            Route::any('/print', [EnquiryController::class,'print'])->name('print');
            Route::get('/create', [EnquiryController::class,'create'])->name('create');
            Route::post('/store', [EnquiryController::class,'store'])->name('store');
            Route::get('/edit/{id}', [EnquiryController::class,'edit'])->name('edit');
            Route::get('/show/{id}', [EnquiryController::class,'show'])->name('show');
            Route::post('/order', [EnquiryController::class,'order'])->name('order');
            Route::post('/update/{id}', [EnquiryController::class,'update'])->name('update');
            Route::get('/update-status/{id}/{s}', [EnquiryController::class,'updateStatus'])->name('update.status');
            Route::get('/delete/{id}', [EnquiryController::class,'destroy'])->name('delete');
        });
        Route::group(['middleware' => 'can:manage_enquiry', 'prefix' => 'ticket-conversation', 'as' => 'ticket_conversation.'], function () {
            Route::get('/', [TicketConversationController::class,'index'])->name('index');
            Route::get('/create', [TicketConversationController::class,'create'])->name('create');
            Route::post('/store', [TicketConversationController::class,'store'])->name('store');
            Route::get('/edit/{id}', [TicketConversationController::class,'edit'])->name('edit');
            Route::get('/show/{id}', [TicketConversationController::class,'show'])->name('show');
            Route::post('/update/{id}', [TicketConversationController::class,'update'])->name('update');
            Route::get('/delete/{id}', [TicketConversationController::class,'destroy'])->name('delete');

        });
    });

    Route::group(['namespace' => 'Admin\Manage','middleware' => 'can:manage_setting', 'prefix' => 'admin/manage', 'as' => 'admin.'], function () {
        Route::group(['middleware' => 'can:manage_setting', 'prefix' => 'lead', 'as' => 'lead.'], function () {
            Route::get('/', [LeadController::class,'index'])->name('index');
            Route::any('/print', [LeadController::class,'print'])->name('print');
            Route::get('/create', [LeadController::class,'create'])->name('create');
            Route::post('/store', [LeadController::class,'store'])->name('store');
            Route::get('/edit/{id}', [LeadController::class,'edit'])->name('edit');
            Route::get('/show/{id}', [LeadController::class,'show'])->name('show');
            Route::post('/update/{id}', [LeadController::class,'update'])->name('update');
            Route::get('/delete/{id}', [LeadController::class,'destroy'])->name('delete');
        });

        Route::group(['middleware' => 'can:manage_setting', 'prefix' => 'user-note', 'as' => 'user_note.'], function () {
            Route::get('/', [UserNoteController::class,'index'])->name('index');
            Route::get('/create', [UserNoteController::class,'create'])->name('create');
            Route::post('/store', [UserNoteController::class,'store'])->name('store');
            Route::get('/edit/{id}', [UserNoteController::class,'edit'])->name('edit');
            Route::get('/show/{id}', [UserNoteController::class,'show'])->name('show');
            Route::post('/update/{id}', [UserNoteController::class,'update'])->name('update');
            Route::get('/delete/{id}', [UserNoteController::class,'destroy'])->name('delete');
        });
        Route::group(['middleware' => 'can:manage_setting', 'prefix' => 'contact', 'as' => 'contact.'], function () {
            Route::get('/', [ContactController::class,'index'])->name('index');
            Route::get('/create', [ContactController::class,'create'])->name('create');
            Route::post('/store', [ContactController::class,'store'])->name('store');
            Route::get('/edit/{id}', [ContactController::class,'edit'])->name('edit');
            Route::get('/show/{id}', [ContactController::class,'show'])->name('show');
            Route::post('/update/{id}', [ContactController::class,'update'])->name('update');
            Route::get('/delete/{id}', [ContactController::class,'destroy'])->name('delete');
        });
        Route::group(['middleware' => 'can:manage_compose_email', 'prefix' => 'email', 'as' => 'email.'], function () {
            Route::get('/compose-email', [EmailComposerController::class,'index'])->name('index');
            Route::post('/compose-email', [EmailComposerController::class,'send'])->name('send');
            Route::post('/message-prepare', [EmailComposerController::class,'msgPrepare'])->name('msg.prepare');
        });
    });

        // Authorized Seller
       Route::group(['prefix' => 'brand-user', 'as' => 'brand_user.'], function () {
            Route::get('/', [BrandUserController::class,'index'])->name('index');
            Route::post('/store', [BrandUserController::class,'store'])->name('store');
             Route::get('/show/{id}', [BrandUserController::class,'show'])->name('show');
            Route::get('/edit/{id}', [BrandUserController::class,'edit'])->name('edit');
            Route::post('/update/{id}', [BrandUserController::class,'update'])->name('update');
            Route::get('/delete/{id}', [BrandUserController::class,'destroy'])->name('delete');
        });
        // Authorized Seller
       Route::group(['middleware'=>'check_access_code','prefix' => 'brand', 'as' => 'brand.'], function () {
            Route::get('/claim/{brand_id}/apply', [BrandUserController::class,'claimBrandCreate'])->name('claim.create');
            // store for Authorize Seller
            Route::post('/claim/{brand_id}/apply/as/store', [BrandUserController::class,'claimBrandStoreForAs'])->name('claim.as.store');

            // store for brand owner
            Route::post('/claim/{brand_id}/apply/bo/store', [BrandUserController::class,'claimBrandStoreForBo'])->name('claim.bo.store');

            Route::post('/claim/{brand_id}/reply/', [BrandUserController::class,'claimReplyStore'])->name('seller.claim.rejection.store');
        });

        Route::get('/access-catalogue-requests', [AccessCatalogueRequest::class,'accessCatalogueReq'])->name('catalogue-request');
    // Seller Dashboard
        Route::group(['middleware' => 'check_access_code','prefix' => 'seller', 'as' => 'seller.'], function () {
            Route::get('/supplier', [SellerController::class,'supplierIndex'])->name('supplier.index');
            Route::get('/my_supplier', [SellerController::class,'mySupplierIndex'])->name('my_supplier.index');
            Route::get('/my_reseller', [SellerController::class,'myResellerIndex'])->name('my_reseller.index');
            Route::get('/explore', [SellerController::class,'exploreIndex'])->name('explore.index');
            Route::get('/api/brands', [SellerController::class,'apiBrandUsers'])->name('api.brand.users');
            Route::get('/request', [SellerController::class,'requestIndex'])->name('request.index');
            Route::get('/', [SellerController::class,'copyToaster'])->name('copy-toaster');
            Route::get('/request/update-status/', [SellerController::class,'updateRequestStatus'])->name('update.request-status');
            Route::get('/update/price-group', [SellerController::class,'updatePriceGroup'])->name('update.price-group');
            Route::get('/user-enquiry', [SellerController::class,'userEnquiryIndex'])->name('enquiry.index');
            Route::get('/user-enquiry/edit/{id}', [SellerController::class,'userEnquiryEdit'])->name('enquiry.edit');
            Route::get('/user-enquiry/delete/{id}', [SellerController::class,'userEnquirydestroy'])->name('enquiry.delete');
            Route::post('/user-enquiry/update/{id}', [SellerController::class,'updateEnquiry'])->name('enquiry.update');
            Route::get('/ignore', [SellerController::class,'ignoreIndex'])->name('ignore.index');
            Route::get('/reminder/{id}', [SellerController::class,'requestSendReminder'])->name('send.request-reminder');

            Route::post('/request/catalogue', [SellerController::class,'requestCatalogue'])->name('request.catalogue');

            Route::get('/category/{type_id}', [CategoryController::class,'index'])->name('category.index');
            Route::post('/update/site-name/{id}', [SellerController::class,'updateSiteName'])->name('update.site-name');
            Route::get('/delete/{id}', [AccessCatalogueRequest::class,'destroy'])->name('request-delete');
            Route::get('/deleteacr/{id}',[AccessCatalogueRequest::class,'deleteacr'])->name('delete.acr');


        });

        // workstream routes


    Route::group(['prefix' => 'case-work-stream', 'as' => 'case_work_stream.'], function () {
        Route::get('index/{id?}', [CaseWorkstreamController::class,'index'])->name('index');
        Route::get('/create/{id?}', [CaseWorkstreamController::class,'create'])->name('create');
        Route::post('/store', [CaseWorkstreamController::class,'store'])->name('store');
        Route::get('/edit/{id}', [CaseWorkstreamController::class,'edit'])->name('edit');
        Route::get('/show/{id}', [CaseWorkstreamController::class,'show'])->name('show');
        Route::get('/call/{id}', [CaseWorkstreamController::class,'voiceCall'])->name('voice.call');
        Route::get('/video-call/{id}', [CaseWorkstreamController::class,'videoCall'])->name('video.call');
        Route::get('/completed/{id}', [CaseWorkstreamController::class,'markCompleted'])->name('mark.completed');
        Route::post('/update/{id}', [CaseWorkstreamController::class,'update'])->name('update');
        Route::get('/delete/{id}', [CaseWorkstreamController::class,'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'case-work-stream-participant', 'as' => 'case_work_stream_participant.'], function () {
        Route::get('index/{id?}', [CaseWorkstreamParticipantController::class,'index'])->name('index');
        Route::get('/create/{id?}', [CaseWorkstreamParticipantController::class,'create'])->name('create');
        Route::post('/store', [CaseWorkstreamParticipantController::class,'store'])->name('store');
        Route::get('/edit/{id}', [CaseWorkstreamParticipantController::class,'edit'])->name('edit');
        Route::get('/show/{id}', [CaseWorkstreamParticipantController::class,'show'])->name('show');
        Route::post('/update/{id}', [CaseWorkstreamParticipantController::class,'update'])->name('update');
        Route::get('/delete/{id}', [CaseWorkstreamParticipantController::class,'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'case-work-stream-message', 'as' => 'case_work_stream_message.'], function () {
        Route::get('index/{id?}', [CaseWorkstreamMessageController::class,'index'])->name('index');
        Route::get('/create/{id?}', [CaseWorkstreamMessageController::class,'create'])->name('create');
        Route::post('/store', [CaseWorkstreamMessageController::class,'store'])->name('store');
        Route::get('/edit/{id}', [CaseWorkstreamMessageController::class,'edit'])->name('edit');
        Route::get('/show/{id}', [CaseWorkstreamMessageController::class,'show'])->name('show');
        Route::post('/update/{id}', [CaseWorkstreamMessageController::class,'update'])->name('update');
        Route::get('/delete/{id}', [CaseWorkstreamMessageController::class,'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'case-work-stream-attachment', 'as' => 'case_work_stream_attachment.'], function () {
        Route::get('index/{id?}', [CaseWorkstreamAttachmentController::class,'index'])->name('index');
        Route::get('/create/{id?}', [CaseWorkstreamAttachmentController::class,'create'])->name('create');
        Route::post('/store', [CaseWorkstreamAttachmentController::class,'store'])->name('store');
        Route::get('/edit/{id}', [CaseWorkstreamAttachmentController::class,'edit'])->name('edit');
        Route::get('/show/{id}', [CaseWorkstreamAttachmentController::class,'show'])->name('show');
        Route::post('/update/{id}', [CaseWorkstreamAttachmentController::class,'update'])->name('update');
        Route::get('/delete/{id}', [CaseWorkstreamAttachmentController::class,'destroy'])->name('delete');
    });


    // workstream routes end

     // BulkUpload
    // Route::get('/export/product-bulk', [BulkController::class,'exportData'])->name('product.bulk-export');


    // Route::post('/update/product-bulk', [BulkController::class,'productBulkUpdate'])->name('product.bulk-update');
    Route::get('/export/product-group/bulk', [BulkController::class,'exportProductGroupData'])->name('product.group.bulk-export');
    Route::get('/export/inventory-group/bulk', [BulkController::class,'exportInventoryStock'])->name('inventory.group.bulk-export');
    Route::post('/update/inventory-group/bulk', [BulkController::class,'inventoryGroupBulkUpdate'])->name('inventory.group.bulk-update');
    Route::post('/update/product-group/bulk', [BulkController::class,'productGroupBulkUpdate'])->name('product.group.bulk-update');
    Route::post('/category-upload', [BulkController::class,'categoryUpload'])->name('category-upload');
    Route::post('/update/product-admin/bulk', [BulkController::class,'updateproduct121team'])->name('product.admin.bulk-update');

    Route::get('/export/inventoryNew', [BulkController::class,'inventoryExportDownload'])->name('product.inventoryExport');
    Route::get('/export/deliveryNew', [BulkController::class,'DeliveryExportDownload'])->name('product.deliveryExport');
    Route::post('/update/delivery-group/bulk', [BulkController::class,'DeliveryGroupBulkUpdate'])->name('delivery.group.bulk-update');

    Route::get('/display',[UserShopItemController::class,'checkdisplay'])->name('check.display');
    Route::get('/display/product/{id}',[UserShopItemController::class,'checkproductdisplay'])->name('view.product');


    Route::group(['middleware' => 'auth','namespace' => '/currency', 'prefix' => '/', 'as' => 'currency.'], function () {
        Route::get('/manage/Currency', [CurrencyController::class,'index'])->name('manage.index');
        Route::get('/make/default/{record}', [CurrencyController::class,'makedefault'])->name('make.default');
        Route::get('/export/bulkcurrency/{user}', [NewBulkController::class,'exportrecordCurrecy'])->name('export.bulk');
        Route::get('/download/bulkcurrency/', [NewBulkController::class,'exportfileCurrency'])->name('exportfileCurrency.bulk');
        Route::post('/upload/bulkcurrency/{user}', [NewBulkController::class,'uploadCurrency'])->name('upload.bulk');

        Route::post('/upload/single/bulkcurrency/{user}', [CurrencyController::class,'uploadCurrency'])->name('upload.single');
        Route::post('/update/bulkcurrency/{user}', [NewBulkController::class,'updateCurrency'])->name('update.bulk');

        Route::post('/update/singlecurrency', [CurrencyController::class,'update'])->name('update.single');


    });






    // @ Group Route for Bulk Sheet
    Route::group(['middleware' => 'auth','namespace' => '/bulk', 'prefix' => '/', 'as' => 'bulk.'], function () {

        Route::post('/product-upload', [NewBulkController::class,'productUpload'])->name('product-upload');
        Route::get('/export/product-bulk-sheet/{user_id}', [NewBulkController::class,'ProductSheetExport'])->name('product.bulk-sheet-export');

        Route::post('/export/product-bulk-sheet/custom/{user_id}', [NewBulkController::class,'exportDataCustom'])->name('product.custom.bulk-sheet-export');
        Route::post('/product-upload/{user_id}', [NewBulkController::class,'UploadDataCustom'])->name('custom.product-upload');

        Route::post('/update/product-bulk', [NewBulkController::class,'productBulkUpdate'])->name('product.bulk-update');
        Route::get('/export/product-bulk/{user_id}', [NewBulkController::class,'exportData'])->name('product.bulk-export');

        // ` Update Bulk Excel For Users Upload Admin Start
        Route::get('/manage-bulk', [NewBulkController::class,'updateExcelShow'])->name('manage.bulk');
        Route::post('/update-bulk-excel', [NewBulkController::class,'updateExcel'])->name('update.bulk.excel');
        // ` Update Bulk Excel For Users Upload Admin End

    });



    Route::group(['middleware' => 'auth', 'prefix' => '/invoice', 'as' => 'invoice.'], function () {
        Route::get('/',[invoiceController::class,'index'])->name('index');
    });

    Route::group(['middleware' => 'auth', 'namespace' => 'panel', 'prefix' => '/image', 'as' => 'image.'], function () {
        Route::any('/Image-studio/{file_path}',[ImageController::class,'photoStudio'])->name('studio');

        Route::post('/removebg',[ImageController::class,'removeBg'])->name('removebg');
        Route::any('/changebg',[ImageController::class,'changebg'])->name('changebg');
        Route::post('/crop/image',[ImageController::class,'cropimage'])->name('crop.image');


        Route::get('/maya', [ImageController::class, 'showdesigner'])->name('designer');
        Route::post('/generate-image', [ImageController::class, 'generateImage'])->name('generateImage');
        Route::post('/generate-image-from-image', [ImageController::class, 'generateImageFromImage'])->name('generateImageFromImage');;


    });



    // For Exporting User Deatils
    Route::get('/export/user-bulk', [BulkController::class,'exportUserData'])->name('user.bulk-export');
    Route::post('/update/user-bulk', [BulkController::class,'UserBulkUpdate'])->name('user.bulk-update');



    Route::any('Entity', [UserAddressController::class,'EntityGet'])->name('Entity.get');



    // Need to add condition for access by only admin
    Route::get('brand/claim/{brand_id}/show', [BrandUserController::class,'claimBrandShow'])->name('brand.claim.show');


    //Backend Routes END--------------------------------------------------------------------------------------
});
