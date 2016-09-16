<?php

namespace App\Http\Controllers;

use App\Reports;
use App\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function notes(Request $request)
    {
        $input = $request->all();
        if (Reports::where('page_id', Input::get('page_id'))->exists()) {
            //UPDATE
            $Reports = Reports::where('page_id', Input::get('page_id'));
            $input = $request->all();
            $Reports->update($input);
            return $input;
        }
        //CREATE
        Reports::create($input);
        return $input;
    }

    public function weeklyReport()
    {
        $weekly_report = Reports::where('page_id','1')->get();

        if($weekly_report->isEmpty()){
            return view('reports.weekly_report', compact('weekly_report'));
        } else{
            return view('reports.weekly_report', compact('weekly_report'));
        }

    }

    public function monthlyReport()
    {
        return view('reports.monthly_report');
    }

    public function carCount()
    {
        $card = Tracking::where('ticket_payment','Card Payment')->whereRaw('Date(created_at) = CURDATE()')->count();
        $cash = Tracking::where('ticket_payment','Cash Payment')->whereRaw('Date(created_at) = CURDATE()')->count();
        $not_paid = Tracking::where('ticket_payment','Not Paid')->whereRaw('Date(created_at) = CURDATE()')->count();//AND
        $vip = Tracking::where('ticket_price','VIP-FREE')->whereRaw('Date(created_at) = CURDATE()')->count();//AND NOT PAID
        $car_count = Tracking::whereRaw('Date(created_at) = CURDATE()')->whereNotIn('ticket_status',['deleted'])->count();//NOT DELETED ONES
        return view('reports.car_count', compact('card', 'cash', 'not_paid', 'vip', 'car_count'));
    }
}
