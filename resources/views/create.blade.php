@extends('layouts.app')
@section('content')
    @if (session('status'))
        <div class="alert alert-danger">
            {{ session('status') }}
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-warning">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">Create a New Entry</div>
                    <div class="panel-body">
                        <form id="testform" class="form-viritical" action="/home" method="post">
                            {{ csrf_field() }}
                            <input name="ticket_serial_number" value="{{ $ticket_serial_number }}" readonly hidden>
                            <div class="form-group">
                                @if (session('ticket_number'))
                                    <input value="{{ session('ticket_number') }}"
                                           name="ticket_number" type="text" class="form-control" id="ticket_number" placeholder="Ticket Number"
                                    readonly>
                                @else
                                    <input value="<?php echo empty($ticket_number) ? "" : $ticket_number; ?>"
                                       name="ticket_number" type="text" class="form-control" id="ticket_number" placeholder="Ticket Number"
                                    readonly>
                                @endif
                            </div>
                            <div class="form-group">
                                <input name="ticket_registration" autocapitalize="characters" style="text-transform:uppercase" type="text" class="form-control"
                                       id="ticket_registration" placeholder="Registration"
                                       value="{{ empty($old_data->ticket_registration) ? old('ticket_registration') : $old_data->ticket_registration }}">
                            </div>
                            <div class="form-group">
                                <select name="ticket_price" class="form-control" id="ticket_price">
                                    @if(!empty(old('ticket_price')))
                                        <option selected>{{ old('ticket_price') }}</option>
                                        <option>£25</option>
                                        <option>£20</option>
                                        <option>VIP-FREE</option>
                                        <option>Self drive-£10</option>
                                    @elseif(!empty($old_data->ticket_price))
                                        <option>{{ $old_data->ticket_price }}</option>
                                        <option>£25</option>
                                        <option>£20</option>
                                        <option>VIP-FREE</option>
                                        <option>Self drive-£10</option>
                                    @else
                                        <option>£25</option>
                                        <option>£20</option>
                                        <option>VIP-FREE</option>
                                        {{--<option>Self drive-£10</option>--}}
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <input name="ticket_name" type="text" class="form-control" id="ticket_name" placeholder="Name"
                                       value="{{ empty($old_data->ticket_name) ? old('ticket_name') : $old_data->ticket_name }}">
                            </div>
                            <div class="form-group">
                                <input name="ticket_mobile" type="text" class="form-control"
                                       value="{{ empty($old_data->ticket_mobile) ? old('ticket_mobile') : $old_data->ticket_mobile }}" id="ticket_mobile" placeholder="Mobile">
                                {{--pattern="^\s*\(?(020[7,8]{1}\)?[ ]?[1-9]{1}[0-9{2}[ ]?[0-9]{4})|(0[1-8]{1}[0-9]{3}\)?[ ]?[1-9]{1}[0-9]{2}[ ]?[0-9]{3})\s*$"--}}
                            </div>

                            <div class="form-group">
                                <input name="booked_in_by" type="text" class="form-control" id="" placeholder="Booked in By"
                                       value="{{ empty($booked_in_by) ? 'No Name' : $booked_in_by }}" readonly>
                                {{--<select name="booked_in_by" class="form-control" id="ticket_price">--}}
                                    {{--@if(!empty(old('booked_in_by')))--}}
                                        {{--<option selected>{{ old('booked_in_by') }}</option>--}}
                                        {{--<option>Amy Hamilton</option>--}}
                                        {{--<option>Arnoldo Mota</option>--}}
                                        {{--<option>Brian Duggan</option>--}}
                                        {{--<option>Dave Duggan</option>--}}
                                        {{--<option>Ellie Porterfield</option>--}}
                                        {{--<option>Fabio Barata</option>--}}
                                        {{--<option>Ivo Correia</option>--}}
                                        {{--<option>John Harris</option>--}}
                                        {{--<option>Joshua Little</option>--}}
                                        {{--<option>Nelson Fonseca</option>--}}
                                        {{--<option>Robert Jones</option>--}}
                                        {{--<option>Rui Jesus</option>--}}
                                    {{--@elseif(!empty($old_data->booked_in_by))--}}
                                        {{--<option>{{ $old_data->booked_in_by }}</option>--}}
                                    {{--@else--}}
                                        {{--<option disabled selected>Booked in By</option>--}}
                                        {{--<option>Amy Hamilton</option>--}}
                                        {{--<option>Arnoldo Mota</option>--}}
                                        {{--<option>Brian Duggan</option>--}}
                                        {{--<option>Dave Duggan</option>--}}
                                        {{--<option>Ellie Porterfield</option>--}}
                                        {{--<option>Fabio Barata</option>--}}
                                        {{--<option>Ivo Correia</option>--}}
                                        {{--<option>John Harris</option>--}}
                                        {{--<option>Joshua Little</option>--}}
                                        {{--<option>Nelson Fonseca</option>--}}
                                        {{--<option>Robert Jones</option>--}}
                                        {{--<option>Rui Jesus</option>--}}
                                    {{--@endif--}}
                                {{--</select>--}}
                            </div>

                            {{--<div class="form-group">--}}
                                {{--<select name="ticket_driver" class="form-control" id="ticket_price">--}}
                                    {{--@if(!empty(old('ticket_driver')))--}}
                                        {{--<option selected>{{ old('ticket_driver') }}</option>--}}
                                        {{--<option>Arnoldo Mota</option>--}}
                                        {{--<option>Brian Duggan</option>--}}
                                        {{--<option>Dave Duggan</option>--}}
                                        {{--<option>Ivo Correir</option>--}}
                                        {{--<option>John Harris</option>--}}
                                        {{--<option>Nelson Fonseca</option>--}}
                                        {{--<option>Robert Jones</option>--}}
                                    {{--@elseif(!empty($old_data->ticket_driver))--}}
                                        {{--<option>{{ $old_data->ticket_driver }}</option>--}}
                                    {{--@else--}}
                                        {{--<option disabled selected>Driver</option>--}}
                                        {{--<option>Arnoldo Mota</option>--}}
                                        {{--<option>Brian Duggan</option>--}}
                                        {{--<option>Dave Duggan</option>--}}
                                        {{--<option>Ivo Correir</option>--}}
                                        {{--<option>John Harris</option>--}}
                                        {{--<option>Nelson Fonseca</option>--}}
                                        {{--<option>Robert Jones</option>--}}
                                    {{--@endif--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                @if(!empty($old_data->existing_customer)=="Yes" || !empty(old('existing_customer')))
                                    <input id="existing_customer" type="button" class="btn btn-success"
                                           name='existing_customer' value="Is an Existing Customer">
                                @else
                                    <input id="existing_customer" type="button" class="btn btn-danger"
                                           name='existing_customer' value="Not an Existing Customer">
                                @endif
                            </div>
                            <div id="existing"></div>

                            <div class="form-group">
                                <input name="ticket_manufacturer" type="text" class="form-control" id="ticket_manufacturer"
                                       value="{{ empty($old_data->ticket_manufacturer) ? "" : $old_data->ticket_manufacturer }}" placeholder="Manufacturer">
                            </div>
                            <div class="form-group">
                                <input name="ticket_model" type="text" class="form-control" id="ticket_model"
                                       value="{{ empty($old_data->ticket_model) ? "" : $old_data->ticket_model }}" placeholder="Model">
                            </div>
                            <div class="form-group">
                                <input name="ticket_colour" type="text" class="form-control" id="ticket_colour"
                                       value="{{ empty($old_data->ticket_colour) ? "" : $old_data->ticket_colour }}" placeholder="Colour">
                            </div>
                            <div class="form-group">
                                @if(!empty($old_data->ticket_notes))
                                    <textarea name="ticket_notes" class="form-control" placeholder="Notes:">
                                        {{ $old_data->ticket_notes }}
                                    </textarea>
                                    @else
                                    <textarea name="ticket_notes" class="form-control" placeholder="Notes:"></textarea>
                                @endif
                            </div>
                            <div class="form-group">
                                <input name="ticket_status" type="text" value="active" hidden>
                                <input type="submit" class="btn bg-primary center-block" value="Issue Ticket">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
//            $(".alert").fadeTo(2000, 500).slideUp(500, function(){
//                $(".alert").slideUp(500);
//            });

            $("#existing_customer").click(function () {
                $("#existing_customer").toggleClass('btn-danger').toggleClass('btn-success');
                if(this.value == 'Not an Existing Customer')
                {
                    this.value = 'Is an Existing Customer';
                    $('#existing').empty();
                    $('#existing').append("<input type='text' value='Yes' name='existing_customer' hidden />");
                }
                else {
                    this.value = 'Not an Existing Customer';
                    $('#existing').empty();
                    $('#existing').append("<input type='text' value='No' name='existing_customer' hidden />");
                }
            });
        });
    </script>
@endsection
