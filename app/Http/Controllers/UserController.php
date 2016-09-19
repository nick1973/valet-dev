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
        $input = $request->all();
        $user = User::find($id);
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
