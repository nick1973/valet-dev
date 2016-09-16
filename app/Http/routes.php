<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('auth/login');
    });
});

Route::auth();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/user/log_out', 'UserController@log_out');
    Route::resource('/user', 'UserController');



    Route::resource('/home', 'HomeController');
    Route::get('/history', 'HomeController@history');
    Route::get('/history/{history}', 'HomeController@historyShow');
    Route::get('/reallocate/{reallocate}', 'HomeController@reallocateTicket');

    Route::get('/reports/car-count', 'ReportsController@carCount');
    Route::get('/reports/weekly-report', 'ReportsController@weeklyReport');
    Route::get('/reports/monthly-report', 'ReportsController@monthlyReport');

    Route::post('/reports/weekly_notes', 'ReportsController@notes');

    Route::post('/reports/weekly-report', function (){

        $period = $_POST['period'];
        $day = $_POST['day'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $page_id = $_POST['page_id'];
        //return $day;
        $week = \Carbon\Carbon::create($year,$month,$day,0);
        $weekStart = date_format($week,"Y/m/d H:i:s");
        $weekSrt = date_format($week,"d/m/Y");
        if($period=='monthly'){
            $addWeek = $week->addDays(27);
        } else{
            $addWeek = $week->addDays(6);
        }
        $weekEnd = date_format($addWeek,"Y/m/d H:i:s");
        $weekE = date_format($addWeek,"d/m/Y");
        $card = \App\Tracking::where('ticket_payment','Card Payment')->whereBetween('created_at', [$weekStart, $weekEnd])->whereNotIn('ticket_status',['deleted'])->count();
        $cash = \App\Tracking::where('ticket_payment','Cash Payment')->whereBetween('created_at', [$weekStart, $weekEnd])->whereNotIn('ticket_status',['deleted'])->count();
        $not_paid = \App\Tracking::whereNotIn('ticket_price', ['VIP-FREE'])->where('ticket_payment','Not Paid')->whereBetween('created_at', [$weekStart, $weekEnd])->whereNotIn('ticket_status',['deleted'])->count();
        $vip = \App\Tracking::where('ticket_price','VIP-FREE')->where('ticket_payment','Not Paid')->whereBetween('created_at', [$weekStart, $weekEnd])->whereNotIn('ticket_status',['deleted'])->count();
        $car_count = \App\Tracking::whereBetween('created_at', [$weekStart, $weekEnd])->whereNotIn('ticket_status',['deleted'])->count();
        $notes = \App\Reports::where('page_id', $page_id)->get();
        return ['card' => $card,
                'cash' => $cash,
                'not_paid' => $not_paid,
                'vip' => $vip,
                'car_count' => $car_count,
                'weekSrt' => $weekSrt,
                'weekE' => $weekE,
                'notes' => $notes];
    });

    Route::resource('/reports', 'ReportsController');

    Route::resource('/pre-booking', 'PreBookController');
    Route::get('/issue/{booking}', 'PreBookController@issueTicket');

    Route::resource('/collections', 'CollectionsController');

    Route::any('/search-reg', function (){
        $reg = $_POST['searchreg'];
        return \App\Tracking::where('ticket_status', 'active')->Where('ticket_registration', 'LIKE', '%'.$reg.'%')
            ->orderBy('created_at', 'desc')->get();
    });

});

Route::get('/all-tickets', function () {
    return ['data' => \App\Tracking::where('id','!=','1')->get()];
});