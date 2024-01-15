<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;

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

Route::group(['middleware' => 'can:manage_dev', 'prefix' => 'dev'], function(){

    // API Documentation
    Route::get('/rest-api', function () { return view('api'); });
	Route::get('/invoice', function () { return view('pages.invoice'); });

	//form-controls
	Route::get('/client-datatable', function () { return view('pages.datatable.client-table'); });
	Route::group(['namespace' => 'Admin'], function () {
        Route::get('/server-datatable', ['uses' => 'DevController@index']);
        Route::get('/server/get-list', ['uses' => 'DevController@getServerList']);
	});
	//calendar
	// Route::get('/calendar', function () { return view('pages.calendar'); });
	Route::get('/file-manager', function () { return view('pages.file-manager'); });
	Route::get('/pdf-viewer', function () { return view('pages.pdf_viewer'); });
	Route::get('/image-cropper', function () { return view('pages.image-cropper'); });
	Route::get('/drag-cropper', function () { return view('pages.image-drag-cropper'); });
	Route::get('/notes', function () { return view('pages.notes'); });
	Route::get('/view', function () { return view('pages.view'); });

	Route::group(['namespace' => 'Admin','as' => 'dev.'], function () {
		Route::post('/drag-cropper', ['uses' => 'DevController@imageStore', 'as' => 'drag.cropper.post']);
	});
	Route::group(['namespace' => 'Admin','prefix' => 'calendar' ,'as' => 'dev.calendar.'], function () {
        Route::get('/', ['uses' => 'DevController@calendar', 'as' => 'index']);
        Route::post('/store-cal', ['uses' => 'DevController@storeCal', 'as' => 'store']);
        Route::post('/update-cal', ['uses' => 'DevController@updateCal', 'as' => 'update']);
        Route::get('/delete-cal/{id}', ['uses' => 'DevController@deleteCal', 'as' => 'delete']);
    });

	//form-controls
	Route::get('/form-addon', function () { return view('pages.form-addon'); });
	Route::get('/form-advance', function () { return view('pages.form-advance'); });
	Route::get('/form-advance-copy', function () { return view('pages.form-advance-copy'); });
	Route::get('/form-components', function () { return view('pages.form-components'); });
	Route::get('/form-picker', function () { return view('pages.form-picker'); });

	//widgets and Statistics
	Route::get('/widget-chart', function () { return view('pages.widget-chart'); });
	Route::get('/widget-data', function () { return view('pages.widget-data'); });
	Route::get('/widget-statistic', function () { return view('pages.widget-statistic'); });
	Route::get('/widgets', function () { return view('pages.widgets'); });

	//Charts & Graphs
	Route::get('/charts-amcharts', function () { return view('pages.charts-amcharts'); });
	Route::get('/charts-chartist', function () { return view('pages.charts-chartist'); });
	Route::get('/charts-flot', function () { return view('pages.charts-flot'); });
	Route::get('/charts-knob', function () { return view('pages.charts-knob'); });

	// themekit ui pages
	Route::get('/alerts', function () { return view('pages.ui.alerts'); });
	Route::get('/badges', function () { return view('pages.ui.badges'); });
	Route::get('/buttons', function () { return view('pages.ui.buttons'); });
	Route::get('/cards', function () { return view('pages.ui.cards'); });
	Route::get('/carousel', function () { return view('pages.ui.carousel'); });
	Route::get('/icons', function () { return view('pages.ui.icons'); });
	Route::get('/modals', function () { return view('pages.ui.modals'); });
	Route::get('/navigation', function () { return view('pages.ui.navigation'); });
	Route::get('/accordion-collapse', function () { return view('pages.ui.accordion-collapse'); });
	Route::get('/notifications', function () { return view('pages.ui.notifications'); });
	Route::get('/range-slider', function () { return view('pages.ui.range-slider'); });
	Route::get('/rating', function () { return view('pages.ui.rating'); });
	Route::get('/session-timeout', function () { return view('pages.ui.session-timeout'); });
	Route::get('/pricing', function () { return view('pages.pricing'); });



	// Test Images API URLS
	Route::get('/image-studio', ['uses' => 'DevRouteController@imagestudio', 'as' => 'image.studio']);
	Route::get('/image-studio/test', ['uses' => 'DevRouteController@ashish', 'as' => 'image.studio']);



});

