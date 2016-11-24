<?php

namespace App\Http\Controllers;

use App\Tracking;
use App\User;
use Dotenv\Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{

    public function index()
    {
        $tickets = Tracking::whereIn('ticket_status', ['active','collection'])->where('id','!=','1')->orderBy('updated_at', 'desc')->get();
        $user = Auth::user();
        return view('home', compact('user', 'tickets'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $user = User::find($id);
        if(Auth::user()->name==='Valet1'){
            $ticket_id = 'valet1_ticket_id';
            //$ticket_serial_number = 'valet1_ticket_serial_number';
        }
        if(Auth::user()->name==='Valet2'){
            $ticket_id = 'valet2_ticket_id';
            //$ticket_serial_number = 'valet2_ticket_serial_number';
        }
        if(Auth::user()->name==='Valet3'){
            $ticket_id = 'valet3_ticket_id';
            //$ticket_serial_number = 'valet3_ticket_serial_number';
        }
        $user->update(['ticket_number' => '', 'ticket_serial_number' => '']);
        //$lastRecord = Tracking::latest($ticket_id)->where('ticket_status', 'active')->first();
        //$lastRecord->update([$ticket_id => '']);

        $rules = [
            'ticket_number' => 'required|max:3|min:3'
            //'ticket_serial_number' => 'required|numeric'

        ];
        $validator = \Illuminate\Support\Facades\Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $active = Tracking::whereIn('ticket_status', ['active','collection'])
                            ->where(function ($query){
                                $ticket_number = Input::get('ticket_number');
                                $query->orWhere('ticket_number', '=', $ticket_number)
                                    ->orWhere('valet1_ticket_id', '=', $ticket_number)
                                    ->orWhere('valet2_ticket_id', '=', $ticket_number)
                                    ->orWhere('valet3_ticket_id', '=', $ticket_number);
                            })->count();
        if($active>0)
        {
            return redirect()->back()->with('status','This Ticket is in use!');
        }

        $user->update($input);
        return $this->index();
    }

    public function log_out()
    {
        $user = User::find(Auth::user()->id);
        $user->update(['ticket_number' => '', 'ticket_serial_number' => '']);
        Auth::logout();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

}
