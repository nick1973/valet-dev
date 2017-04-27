@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-danger">
                {{ session('status') }}
            </div>
        @endif
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <li>{{ $error }}</li>
            </div>
        @endforeach
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h4>Please add your start ticket and serial numbers</h4></div>
                    <div class="panel-body">
                        {{--<form class="form-horizontal" role="form" method="POST" action="{{ url('/add_ticket_number') }}">--}}
                        {!! Form::model($user,[
                            'method' => 'PATCH',
                            'route' => ['user.update', $user->id],
                            'class' => 'form-horizontal']) !!}
                        {{ csrf_field() }}
                            <div class="form-group">
                                <label style="color: white" class="col-md-4 control-label">Start Ticket Number</label>
                                <div class="col-md-6">
                                    <input id="" type="text" class="form-control" name="ticket_number" value="{{ old('ticket_number') }}">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label style="color: white" for="password" class="col-md-4 control-label">Start Ticket Serial Number</label>

                                <div class="col-md-6">
                                    <input id="" type="text" class="form-control" name="ticket_serial_number" value="{{ old('ticket_serial_number') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="color: white" class="col-md-4 control-label">Booked in By</label>
                                <div class="col-md-6">
                                    <select name="booked_in_by" class="form-control" id="ticket_price">
                                        <option selected>{{ old('booked_in_by') }}</option>
                                        <option>Amy Hamilton</option>
                                        <option>Bruno Cruz</option>
                                        <option>Mihaela Erdei</option>
                                        <option>Dave Duggan</option>
                                        <option>Oliver McLean</option>
                                        <option>Fabio Barata</option>
                                        <option>Ivo Correia</option>
                                        <option>John Harris</option>
                                        <option>David Terra</option>
                                        <option>Nelson Fonseca</option>
                                        <option>Fabio Jesus</option>
                                        {{--<option></option>--}}
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                         Add Ticket Number
                                    </button>

                                    {{--<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>--}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
