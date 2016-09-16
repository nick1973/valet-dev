@extends('layouts.app')

@section('content')
    <div class="container">
        <div style="padding-bottom: 10px">
            <a class="btn btn-primary" href="/home">Active</a>
            <a class="btn btn-success" href="/collections">Collections</a>
            <a class="btn btn-warning" href="/pre-booking">Pre Booked</a>
            <a class="btn btn-default active" href="/history">History</a>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $user->name }} You are logged in!</div>
                    <div class="panel-body">
                        {{--<form id="searchreg-form" action="/search-reg">--}}
                            {{--{{ csrf_field() }}--}}
                            {{--<input id="searchreg" name="searchreg" onkeyup="searchReg()" placeholder="Search for Reg" class="pull-left form-control">--}}
                        {{--</form>--}}
                        {{--<a href="/home/create" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>--}}
                        <h3 class="text-center" style="color: white">History</h3>
                        <table class="table" style="color: white">
                            <tr>
                                {{--<th></th>--}}
                                <th>No</th>
                                <th>Contact</th>
                                <th>Action</th>
                                <th></th>
                            </tr>
                            @foreach($tickets as $ticket)
                                <tr>
                                    {{--@if($ticket->ticket_key_safe=="")--}}
                                        {{--<td><i style="color: red" class="fa fa-key" aria-hidden="true"></i></td>--}}
                                    {{--@else--}}
                                        {{--<td><i style="color: green" class="fa fa-key" aria-hidden="true"></i></td>--}}
                                    {{--@endif--}}
                                    <td>{{ $ticket->ticket_number }}{{ $ticket->valet1_ticket_id }}{{ $ticket->valet2_ticket_id }}
                                        {{ $ticket->valet3_ticket_id }}</td>
                                    <td><div style="word-wrap: break-word; width: 100px">
                                    @if($ticket->ticket_key_safe=="")
                                        <i style="color: red" class="fa fa-key" aria-hidden="true"></i>
                                    @else
                                        <i style="color: green" class="fa fa-key" aria-hidden="true"></i>
                                    @endif
                                        @if($ticket->existing_customer=="Yes")
                                            <i class="fa fa-user" style="color: pink" aria-hidden="true"></i>
                                        @endif
                                        @if($ticket->ticket_price=='VIP-FREE')
                                            <i class="fa fa-star" style="color: gold" aria-hidden="true"></i>
                                        @endif
                                        {{ $ticket->ticket_name }} {{ $ticket->ticket_mobile}}
                                        <span style="text-transform:uppercase">{{ $ticket->ticket_registration}}</span>
                                    </div></td>
                                        <td><a href="history/{{ $ticket->id }}" class="btn btn-success btn-sm">View</a></td>
                                        <td>{{ date_format($ticket->created_at,"d/m/y") }}</td>
                                </tr>
                            @endforeach
                        </table>

                        <div id="search_results" style="color: white"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{--<script>--}}
        {{--function searchReg() {--}}
            {{--var formData = $("#searchreg-form").serializeArray();--}}
            {{--var URL = $("#searchreg-form").attr("action");--}}
            {{--$.post(URL,--}}
                    {{--formData,--}}
                    {{--function (data, textStatus, jqXHR) {--}}
                        {{--$("#search_results").empty();--}}
                        {{--var x;--}}
                        {{--for(x = 0; x < data.length; x++){--}}
                            {{--$.each(data[x], function(key, field){--}}
                                {{--$("#search_results").append(key + " :" + field + "</br>");--}}
                            {{--});--}}

                        {{--}--}}
                        {{--console.log(data);--}}

                    {{--}).fail(function (jqXHR, textStatus, errorThrown) {--}}
                {{--console.log(errorThrown);--}}
            {{--});--}}

        {{--}--}}
    {{--</script>--}}
@endsection
