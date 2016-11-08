<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Tracking;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add_ticket_number(Request $request, $id)
    {

    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $tickets = Tracking::whereIn('ticket_status', ['active','collection'])->where('id','!=','1')->orderBy('updated_at', 'desc')->get();
        if($user->name==='admin'){
            return view('reports.index', compact('user', 'tickets'));
        }
        if($user->name==='bvfinance' || $user->name==='ctmfinance'){
            return redirect()->action('ReportsController@weeklyReport');
        }
        if($user->name==='visitorcentre'){
            return redirect()->action('PreBookController@index');
        }
        if($user->ticket_number!=='' || $user->ticket_serial_number!==''){
            return view('home', compact('user', 'tickets'));
        }

        return view('ticket', compact('user'));
    }

    public function history()
    {
        $user = Auth::user();
        $tickets = Tracking::where('ticket_status', 'complete')->orderBy('created_at', 'desc')->get();
        return view('history', compact('user', 'tickets'));
    }

    public function show($id)
    {
        $ticket = Tracking::find($id);
        if($ticket->ticket_status==='complete'){
            return redirect()->back()->with('status', 'This ticket has already been pulled and paid!');
        }
        return view('show', compact('ticket'));
    }

    public function historyShow($id)
    {
        $ticket = Tracking::find($id);
        return view('history_show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = Tracking::find($id);
        return view('edit', compact('ticket'));
    }

    public function create()
    {
        $booked_in_by = Auth::user()->booked_in_by;
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
        $lastRecord = Tracking::latest($ticket_id)->where('ticket_status', 'active')->first();
        //return $lastRecord->valet1_ticket_id;
        if($lastRecord->$ticket_id === '' && $lastRecord->$ticket_serial_number === ''){
            $ticket_number = Auth::user()->ticket_number;
            $ticket_serial_number = Auth::user()->ticket_serial_number;
            return view('create', compact('ticket_number', 'ticket_serial_number', 'booked_in_by'));
        }
        $ticket_serial_number = (int)$lastRecord->$ticket_serial_number;
        $ticket_serial_number = $ticket_serial_number + 1;

        $ticket_number = (int)$lastRecord->$ticket_id;
        $ticket_number = sprintf('%03d', (int)$ticket_number + 1);
        if($ticket_number==='121')
        {
            $ticket_number = '001';
        }

        return view('create', compact('ticket_number', 'ticket_serial_number', 'booked_in_by'));
    }

//    public function create()
//    {
//
//        $lastRecord = Tracking::latest('id')->where('ticket_status', 'active')->first();
//        //return $lastRecord;
//        $ticket_number = (int)$lastRecord->ticket_number;
//        $ticket_number = sprintf('%03d', $ticket_number + 1);
//        if($ticket_number==='121')
//        {
//            $ticket_number = '001';
//        }
//        return view('create', compact('ticket_number'));
//    }

    public function reallocateTicket($id)
    {
        $old_data = Tracking::find($id);
        $old_data->update(['ticket_status' => 'deleted']);
        $lastRecord = Tracking::latest('id')->where('ticket_status', 'active')->first();
        //return $lastRecord;
        $ticket_number = (int)$lastRecord->ticket_number;
        $ticket_number = sprintf('%03d', $ticket_number + 1);
        if($ticket_number==='121')
        {
            $ticket_number = '001';
        }
        return view('create', compact('ticket_number', 'old_data'));
    }

    public function store(Request $request)
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

        $this->validate($request, [
            'ticket_number' => 'required|max:3|min:3',
            'ticket_name' => 'required|max:255',
            'ticket_mobile' => 'required|numeric',
            'ticket_registration' => 'required',
            'booked_in_by' => 'required',
//            'ticket_driver' => 'required'

        ]);
        $input = $request->all();
        //return $input;
        $ticket_number = $request->input('ticket_number');
        $serial_number = $request->input('ticket_serial_number');
        //return $ticket_number;
        // NO Ticket found
        if(Tracking::where($ticket_id, $ticket_number)->orderBy('id', 'desc')->first()==null)
        {
            array_pull($input, 'ticket_serial_number');
            $result = array_add($input, $ticket_serial_number, $serial_number);
            //array_pull($result, 'ticket_number');
            $input = array_add($result, $ticket_id, $ticket_number);
            //return $input;
            Tracking::create($input);
            return redirect('home')->with('status', 'Ticket\'s Been Issued!')->withInput();
        }
            if (Tracking::where($ticket_id, $ticket_number)->orderBy('id', 'desc')->first()->exists()) {
                // Ticket found
                $ticket = Tracking::where($ticket_id, $ticket_number)->orderBy('id', 'desc')->first();

                if($ticket->ticket_status==='complete' || $ticket->ticket_status==='deleted')
                {
                    array_pull($input, 'ticket_serial_number');
                    $result = array_add($input, $ticket_serial_number, $serial_number);
                    array_pull($result, 'ticket_number');
                    $input = array_add($result, $ticket_id, $ticket_number);
                    Tracking::create($input);
                    return redirect('home')->with('status', 'Ticket\'s Been Issued!')->withInput();
                }
                //return "Active";
            }
        return redirect()->back()->with('status', 'Ticket\'s still active!')->with('ticket_number',$ticket_number)->withInput();
    }

    public function update(Request $request, $id)
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


        $ticket = Tracking::find($id);
        $input = $request->all();
        $ticket->update($input);
//        if($ticket->$ticket_id===''){
//            return redirect()->route('pre-booking.index');
//        }
        return redirect()->route('home.index');
    }

    public function searchHistory(Request $request)
    {
        $reg = $request->input('searchreg');
        return $request->all();
        if($reg===null){
            $reg = '';
        }

        $tickets = Tracking::where('ticket_status', 'active')->Where('ticket_registration', 'LIKE', '%'.$reg.'%')
            ->orderBy('created_at', 'desc')->get();
        //$tickets = Tracking::all();
        return $reg;
        //return view('history', compact('user', 'tickets'));

    }
}
