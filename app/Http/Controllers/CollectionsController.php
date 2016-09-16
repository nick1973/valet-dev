<?php

namespace App\Http\Controllers;

use App\Tracking;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class CollectionsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tickets = Tracking::Where('ticket_status', 'collection')->where('id','!=','1')->orderBy('updated_at', 'desc')->get();
        return view('collections.index', compact('user', 'tickets'));
    }
}
