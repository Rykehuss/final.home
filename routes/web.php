<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth'], 'prefix' => 'bunch/{bunch_id}'], function (){
    // Subscriber
    Route::get('subscriber/create', 'SubscriberController@create')->name('subscriber.create');
    Route::post('subscriber/store', 'SubscriberController@store')->name('subscriber.store');
    Route::get('subscriber/index', 'SubscriberController@index')->name('subscriber.index');
    Route::get('subscriber/{subscriber}', 'SubscriberController@show')->name('subscriber.show');
    Route::get('subscriber/{subscriber}/edit', 'SubscriberController@edit')->name('subscriber.edit');
    Route::match(['put', 'patch'], 'subscriber/{subscriber}', 'SubscriberController@update')->name('subscriber.update');
    Route::delete('subscriber/{subscriber}', 'SubscriberController@destroy')->name('subscriber.destroy');

    Route::get('subscriber/remove_from_bunch/{subscriber},{bunch}', 'SubscriberController@removeFromBunch')->name('subscriber.removeFromBunch');
    Route::post('subscriber/add_to_bunch/{subscriber}', 'SubscriberController@addToBunch')->name('subscriber.addToBunch');
});

Route::group(['middleware' => ['auth']], function (){
    // Bunch
    Route::get('bunch/remove_subscriber/{bunch},{subscriber}', 'BunchController@removeSubscriber')->name('bunch.removeSubscriber');
    Route::post('bunch/add_subscriber/{bunch}', 'BunchController@addSubscriber')->name('bunch.addSubscriber');
    Route::get('bunch/{bunch}/subscriber', 'BunchController@editSubscribers')->name('bunch.editSubscribers');

    Route::resource('bunch', 'BunchController');

    // Template
    Route::resource('template', 'TemplateController');

    // Campaign
    Route::resource('campaign', 'CampaignController');
    Route::get('campaign/{campaign}/preview', 'CampaignController@preview')->name('campaign.preview');
    Route::get('campaign/{campaign}/send', 'CampaignController@send')->name('campaign.send');

    // Report
    Route::get('report', 'ReportController@index')->name('report.index');
    Route::get('report/{report}', 'ReportController@show')->name('report.show');

});


// Utility
Route::get('send_test_email', function(){
    Mail::raw('Test e-mail', function($message)
    {
        $message->subject('I send e-mail!');
        $message->from('nowhere@gmail.com', 'Unknown place');
        $message->to(['dmtrggl@gmail.com', 'maxim.gontar@gmail.com']);
    });
});

Route::get('/campaign_mail/{campaign},{subscriber}', function (App\Models\Campaign $campaign, \App\Models\Subscriber $subscriber) {
    return new App\Mail\CampaignMail($campaign, $subscriber);
})->name('campaign_mail');

Route::get('/campaign_mail_unsubscibe/{campaign},{subscriber}',
    function (App\Models\Campaign $campaign, \App\Models\Subscriber $subscriber) {
    if ($campaign->bunch->subscribers->contains($subscriber)) {
        $campaign->bunch->subscribers()->detach($subscriber->id);
        return view('bunch.unsubscribe_successfully', compact('campaign', 'subscriber'));
    }
    else {
        return view('bunch.unsubscribe_unsuccessfully', compact('campaign', 'subscriber'));
    }
})->name('campaign_mail_unsubscribe');

Route::get('mail_info', 'CampaignController@mailInfo');
