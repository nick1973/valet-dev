<?php

namespace App\Http\Controllers;

use App\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class PreBookController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pre_books = Tracking::where('ticket_status', 'pre booked')->orderBy('booking_date', 'asc')->get();
        $today_pre_books = Tracking::where('ticket_status', 'pre booked')->whereRaw('date(booking_date) = ?', [Carbon::today()])->get();
        return view('pre-book.index', compact('user', 'pre_books', 'today_pre_books'));
    }

    public function destroy($id)
    {
        $booking = Tracking::find($id);
        $booking->delete();
        return redirect()->back();
    }

    public function create()
    {
        return view('pre-book.create');
    }

    public function store(Request $request)
    {
        $auth_required = $request->input('auth_required');
        //return $auth_required;
        if($auth_required==='1')
        {
            $this->validate($request, [
                'auth_by' => 'required',
                'ticket_name' => 'required|max:255',
                'ticket_registration' => 'required',
            ]);
        } else{
            $this->validate($request, [
                'ticket_name' => 'required|max:255',
                'ticket_registration' => 'required',
            ]);
        }
        $input = $request->all();
        Tracking::create($input);
        return redirect('pre-booking')->with('status', 'Ticket\'s Been Booked!');
    }

    public function issueTicket($id)
    {
        if(Auth::user()->name==='Valet1'){
            $ticket_id = 'valet1_ticket_id';
            $ticket_serial_number = 'valet1_ticket_serial_number';
        }
        if(Auth::user()->name==='Valet2'){
            $ticket_id = 'valet2_ticket_id';
            $ticket_serial_number = 'valet2_ticket_serial_number';
        }
        if(Auth::user()->name==='Valet3'){
            $ticket_id = 'valet3_ticket_id';
            $ticket_serial_number = 'valet3_ticket_serial_number';
        }


        $old_data = Tracking::find($id);
        $lastRecord = Tracking::latest($ticket_id)->where('ticket_status', 'active')->first();
        $ticket_number = (int)$lastRecord->$ticket_id;
        $ticket_number = sprintf('%03d', $ticket_number + 1);
        if($ticket_number==='121')
        {
            $ticket_number = '001';
        }
        $old_data->update(['ticket_status' => 'active', $ticket_id => $ticket_number]);
        return redirect('home')->with('status', 'Ticket\'s Been Issued!');
    }
}
