<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\MicroSiteController;
use App\Http\Controllers\Panel\ProposalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\DevRouteController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\ConstantManagement\WorldController;
use App\Http\Controllers\SellerController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Microproposals;
use App\Http\Controllers\NewBulkController;
use App\Http\Controllers\Panel\ProposalItemController;
use App\Http\Controllers\settingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'subdomain'],  function () {
    Route::group(['namespace' => '/microsite', 'prefix' => '/', 'as' => 'pages.'], function () {
            Route::get('/home', [MicroSiteController::class,'index'])->name('index');
            Route::get('/social', [PageController::class, 'index']);
            Route::get('/about-us', [MicroSiteController::class,'aboutIndex'])->name('about-index');
            Route::get('/contact', [MicroSiteController::class,'contactIndex'])->name('contact-index');
            Route::post('/contact/store', [MicroSiteController::class,'contactStore'])->name('contact.store');
            Route::get('/shop/proposal/{proposal_slug}', [ProposalController::class,'shopProposalIndex'])->name('proposal.shop-index');
            Route::get('/shop', [MicroSiteController::class,'shopIndex'])->name('shop-index');
            
            // Making Propsals in 
            Route::get('/proposal/create', [Microproposals::class,'create'])->name('proposal.create');
            Route::get('/proposal/edit/{proposal}/{user_key}', [Microproposals::class,'edit'])->name('proposal.edit');

            Route::any('/proposal/export/excel', [Microproposals::class,'exportexcel'])->name('proposal.excel');

            Route::get('api-store', [Microproposals::class,'apiStore'])->name('api.store');
            Route::get('api-remove', [Microproposals::class,'apiRemove'])->name('api.remove');
            Route::get('/proposal/picked/{proposal}/{user_key}', [Microproposals::class,'picked'])->name('proposal.picked');
            Route::post('/update/{proposal}/price', [Microproposals::class,'updatePrice'])->name('proposal.update-price');
            Route::post('/update/{proposal}', [Microproposals::class,'update'])->name('proposal.update');
            Route::post('/getdata/{proposalid}', [Microproposals::class,'getdata'])->name('proposal.getdata');
            Route::get('/validate/', [Microproposals::class,'validatepass'])->name('proposal.validatepass');
            Route::post('/samplecheckout/', [Microproposals::class,'samplecheckout'])->name('proposal.samplecheckout');
            Route::get('/marginupdate', [Microproposals::class,'marginupdate'])->name('proposals.updatemargin');
            Route::get('/destroy/{proposal_item}', [Microproposals::class,'destroy'])->name('proposals.destroy');
            Route::post('/update/sequence/{proposal_id}', [Microproposals::class,'updateSequence'])->name('proposals.updateSequence');
            Route::get('/microashish', [Microproposals::class,'ashish'])->name('proposals.checkashish');

            Route::get('/update/download/{proposal}', [Microproposals::class,'updateDownload'])->name('proposals.update.download');

            // Adding Proposal Item Via Scanner
            Route::post('/addpropitem', [MicroSiteController::class,'addpropitem'])->name('proposals.addpropitem');
            Route::get('/make-copy/{Proposal}', [Microproposals::class,'copyoffer'])->name('proposals.makecopy');



            Route::get('/categories', [MicroSiteController::class,'shopCategories'])->name('categories');
            Route::get('/shop-cart', [MicroSiteController::class,'shopCart'])->name('shop-cart');
            Route::post('/add-cart', [MicroSiteController::class,'addCart'])->name('add-cart');
            Route::get('/update-cart-qty', [MicroSiteController::class,'updateCart'])->name('update-cart');
            Route::get('/remove-cart/{cart_id}', [MicroSiteController::class,'removeCart'])->name('remove-cart');
            Route::get('/wishlist', [MicroSiteController::class,'wishList'])->name('wishlist-index');
            Route::get('/pre-checkout', [MicroSiteController::class,'shopPreCheckout'])->name('shop-pre-checkout');
            Route::post('/pre-checkout', [MicroSiteController::class,'storePreCheckout'])->name('store.shop-pre-checkout');
            Route::get('/post-checkout', [MicroSiteController::class,'shopPostCheckout'])->name('shop-post-checkout');
            Route::post('/order/address', [MicroSiteController::class,'updateOrderAddress'])->name('order.update.address');
            Route::post('/store-checkout', [MicroSiteController::class,'storeShopCheckout'])->name('store.shop-checkout');
            Route::get('/shop-category', [MicroSiteController::class,'shopCategory'])->name('shop-category');
            Route::get('/shop/{id}', [MicroSiteController::class,'shopShow'])->name('shop-show');
            Route::post('/enquiry', [MicroSiteController::class,'storeEnquiry'])->name('store-enquiry');
            Route::get('/thank-you', [MicroSiteController::class,'thankYou'])->name('thank-you');
            Route::get('/change-currency',[MicroSiteController::class,'chagecurrency'])->name('change.currency');
        });
});



Route::get('/search',[WebsiteController::class,'searchon121'])->name('home.search');
Route::post('/searchreq',[WebsiteController::class,'searchreq'])->name('home.searchreq');


Route::get('/qb', function () {
    $mailcontent_data = App\Models\MailSmsTemplate::where('code','=',"send-proposal")->first();
    if($mailcontent_data){
        $arr=[
            '{customer_name}'=>'Anjali',
        ];
        $msg = DynamicMailTemplateFormatter($mailcontent_data->body,$mailcontent_data->variables,$arr);
        return dd($msg);
        // sendSms($cust_details->customer_mob_no,$msg,$mailcontent_data->footer);
    }
    return getNewCustomerCount(auth()->id(),0);
    return auth()->user();
    return getGSTNumberByUserShopId(8)['entity_name'];
    return view('demotest');
    return  getSellerPhoneBySlug('8823874387');
});
Route::get('/user-shop-cs-filler', function () {
    $data = App\Models\UserShopItem::where('user_id','!=',null)->orWhere('category_id','=',null)->orWhere('sub_category_id','=',null)->get();
    foreach($data as $item){
        $product = App\Models\Product::whereId($item->product_id)->first();
        if($product){
            $item->update([
                'category_id' => $product->category_id,
                'sub_category_id' => $product->sub_category
            ]);
        }
    }
    return "S";
});

    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
    // Frontend Route Start-------------------------------------------------------------------------------------
      
        // Website Controller
        Route::get('/', [WebsiteController::class,'index'])->name('website.index');
        Route::get('/microsite-proxy', [WebsiteController::class,'microSiteProxy'])->name('microsite.proxy');
        Route::get('/demo', [WebsiteController::class,'demoform'])->name('demoform');
        Route::get('/Dtask', [WebsiteController::class,'formjaya'])->name('jayaform23');
        
        Route::get('/feedback', [WebsiteController::class,'feedbackform'])->name('feedbackform');
        Route::get('/about', [WebsiteController::class,'about'])->name('about');
        Route::get('/plans', [WebsiteController::class,'planIndex'])->name('plan.index');
        Route::get('/plan/{id}/checkout', [WebsiteController::class,'checkout'])->name('plan.checkout');
        // Route::get('/plan/{id}/checkout/index', [WebsiteController::class,'checkoutIndex'])->name('plan.checkout.index');
        Route::post('/plan/{id}/checkout', [WebsiteController::class,'checkoutStore'])->name('plan.checkout.store');
        Route::get('/faqs', [WebsiteController::class,'faq'])->name('website.faq');
        Route::post('/{id}/package', [WebsiteController::class,'packageStore'])->name('package.store');
        Route::get('/contact-us', [WebsiteController::class,'contact'])->name('contact.index');
        Route::post('/contact-us/store', [WebsiteController::class,'contactStore'])->name('contact-us.store');
        Route::get('/start', [WebsiteController::class,'joinIndex'])->name('join.index');
        Route::post('/start/resend-otp','WebsiteController@resendStartOTP')->name('join.resend-otp');
        Route::post('/otp-validate', [WebsiteController::class,'joinValidateOTP'])->name('join-otp-validate');
        Route::post('/poll/question/store',[WebsiteController::class,'questionStore'])->name('user-enquiry.questions.store');
        
        Route::get('/expired', [WebsiteController::class,'expired'])->name('expired');
        
        
        // Paytm Routes
        Route::get('/initiate','PaytmController@initiate')->name('initiate.payment');
        Route::post('/payment','PaytmController@pay')->name('make.payment');
        Route::post('/payment/status', 'PaytmController@paymentCallback')->name('status');
        // Paytm Routes
        
        Route::post('/newsletter/store', [HomeController::class,'storeNewsletter'])->name('newsletter.store');
        Route::get('/article/{slug}', [HomeController::class,'showArticle'])->name('article.show');

        //Blog Controller
        Route::get('/blog', [BlogController::class,'index'])->name('blog.index');
        Route::get('/blog/{id}', [BlogController::class,'show'])->name('blog.show');
        
        // Todo: Custom Routes 
        Route::any('/ashish', [DevRouteController::class,'ashish']);
        Route::any('/excel', [NewBulkController::class,'testExports']);

        Route::get('/jaya', [DevRouteController::class,'jaya']);
        Route::get('/jaya/form', [DevRouteController::class,'jayaform']);


        // Todo: Short LInk
        Route::get('/short/{id}', [WebsiteController::class,'shorturlrefer']);

        Route::group(['namespace' => '/customer', 'prefix' => 'customer', 'as' => 'customer.'], function () {
           Route::get('/dashboard', [CustomerController::class,'dashboard'])->name('dashboard'); 
           Route::get('/checksample/{proposal}', [CustomerController::class,'checksample'])->name('checksample'); 
           Route::get('/lockEnquiry/{proposal}', [CustomerController::class,'lockEnquiry'])->name('lock.enquiry'); 
           Route::post('/lockEnquiry', [CustomerController::class,'lockEnquirystore'])->name('lock.enquiry.store'); 
           Route::post('/survey', [CustomerController::class,'survey'])->name('survey');
           Route::get('/verify-mail', [CustomerController::class,'VerifyMail'])->name('verify.mail'); 
           Route::get('/support-ticket/{id}', [CustomerController::class,'supportTicketShow'])->name('ticket.show'); 
           Route::get('/support-ticket/{id}/{status}', [CustomerController::class,'ticketStatusClose'])->name('ticket.status.update'); 
           Route::post('/ticket/chat/store', [CustomerController::class,'ticketChatStore'])->name('ticket.chat.store'); 
           Route::get('/notification', [CustomerController::class,'notification'])->name('notification'); 
           Route::get('/notification/{id}', [CustomerController::class,'notificationShow'])->name('notification.show'); 
           Route::post('/access-code/validate', [CustomerController::class,'validateAccessCode'])->name('access-code-validate');
           Route::post('/scan-code', [CustomerController::class,'scanCode'])->name('scan-code');
           Route::get('/invoice/{id}', [CustomerController::class,'invoice'])->name('invoice'); 
           Route::get('/remove-img/{user_shop}', [CustomerController::class,'removeImg'])->name('remove-img'); 
           Route::post('/Update-settings', [settingController::class,'update'])->name('update.settings'); 

           Route::get('/my-enquiry', [CustomerController::class,'chatIndex'])->name('chat.index'); 
           Route::post('/update-about/{shop_id}', [CustomerController::class,'updateShopAbout'])->name('update.shop.update'); 
           Route::post('/request/catalogue', [CustomerController::class,'requestCatalogueCustomer'])->name('request.catalogue'); 
           Route::get('/my-enquiry/{id}', [CustomerController::class,'chatShow'])->name('chat.show'); 
           Route::post('/profile/update/{id}', [CustomerController::class,'profileUpdate'])->name('profile.update');
           Route::post('/shop/update/{id}', [CustomerController::class,'shopUpdate'])->name('shop.update');
           Route::post('/industry/update/{id}', [CustomerController::class,'industryUpdate'])->name('industry.update');
           Route::get('/order-history', [CustomerController::class,'orderHistory'])->name('order-history');
            Route::post('/order-status/update/', [CustomerController::class,'updateOrderStatus'])->name('order.update'); 
           Route::post('/address/store', [UserAddressController::class,'store'])->name('address.store');
           Route::get('/address/store', [UserAddressController::class,'store'])->name('address.storeget');
           Route::post('/address/update/', [UserAddressController::class,'update'])->name('address.update'); 
           Route::get('/address/delete/{id}', [UserAddressController::class,'destroy'])->name('address.delete'); 

        });

        Route::group(['namespace' => '/auth','prefix' => 'auth', 'as' => 'auth.'], function () {
            // Login
            Route::get('/login', [CustomerLoginController::class,'login'])->name('login-index');
            Route::post('/login-validate', [CustomerLoginController::class,'validateLogin'])->name('login-validate');
            Route::get('/otp', [CustomerLoginController::class,'otp'])->name('otp-index');
            Route::post('/auth-otp-validate', [CustomerLoginController::class,'validateOTP'])->name('otp-validate');
            Route::get('/auth-signup', [CustomerLoginController::class,'signup'])->name('signup');
            Route::post('/signup-validate', [CustomerLoginController::class,'validateSignup'])->name('signup-validate');
            Route::get('/access-code', [CustomerLoginController::class,'accessCode'])->name('access-code');
            Route::post('/code-validate', [CustomerLoginController::class,'validateCode'])->name('code-validate');
            Route::get('/resend-otp', [CustomerLoginController::class,'resendOTP'])->name('resend-otp');
        });

        
        Route::get('/page', function () {
            return view('frontend.index');
        });

        Route::get('/login-as-guest', [WebsiteController::class,'loginasguest'])->name('loginasguest');

        Route::get('login', [CustomerLoginController::class,'login'])->name('login');
        Route::post('login', [LoginController::class,'login']);
        // Route::get('register', [RegisterController::class,'showRegistrationForm'])->name('register');
        // Route::post('register', [RegisterController::class,'register']);
        
        // Socialite Routes
        Route::get('login/{provider}', [SocialLoginController::class, 'login'])->name('social.login');
        Route::get('login/{provider}/callback', [SocialLoginController::class, 'login']);

        //Email Verification Routes
        Route::get('/email/verify', function () {
            return view('auth.verify');
        })->name('verification.notice');
        
        Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
            return redirect('panel/dashboard');
        })->name('verification.verify');

        Route::get('/email/verification-notification', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();
            return back()->with('message', 'Email has been sent from no-reply@121.page verification, kindly check Spam folder as well.');
        })->name('verification.resend');


        //SMS Verification routes
        Route::get('/sms/verify', function () {
            return view('auth.sms-verify');
        })->name('sms.verify');
        Route::post('/sms/verify', [HomeController::class,'smsVerification'])->name('sms.verify');

        //Password Routes
        Route::get('password/forget', function () {
            return view('pages.forgot-password');
        })->name('password.forget');
        Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');
        
        
        
        // Frontend Route END-------------------------------------------------------------------------------------
        
        
        
        Route::group(['middleware' => 'auth'], function () {
            // logout route
            Route::get('/logout', [LoginController::class,'logout']);
        });


//Route::get('/register', function () { return view('pages.register'); });
// Route::group(['namespace' => 'Admin/ConstantManagement','middleware' => 'web'], function () {
    Route::get('get-states', [WorldController::class,'getStates'])->name('world.get-states');
    Route::get('get-cities', [WorldController::class,'getCities'])->name('world.get-cities');
// });
Route::get('/offline', function () { return view('vendor/laravelpwa/offline'); });

Route::get('/page/{slug}', [HomeController::class,'page'])->name('page.slug');
//  Routes For Backend only

Route::group([], function () {
    require_once(__DIR__ . '/panel.php');
    require_once(__DIR__ . '/crudgen.php');
});

