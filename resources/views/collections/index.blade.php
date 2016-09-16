@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div style="padding-bottom: 10px">
            <a class="btn btn-primary" href="/home">Active</a>
            <a class="btn btn-success active" href="/collections">Collections</a>
            <a class="btn btn-warning" href="/pre-booking">Pre Booked</a>
            <a class="btn btn-default" href="/history">History</a>
        </div>
        <div class="row">
            <div class="col-md-10 col-lg-5 col-md-offset-1">
                <div class="panel panel-success">
                    <div class="panel-heading">{{ $user->name }} You are logged in!</div>

                    <div class="panel-body">
                        <a href="/home/create" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                        <h3 class="text-center" style="color: white">Collections</h3>

                        <table width="" class="table" style="color: white;">
                            <tr>
                                {{--<th></th>--}}
                                <th>No</th>
                                <th>Contact</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                            @foreach($tickets as $ticket)
                                <tr <?php if($ticket->ticket_status=='collection') echo 'class="alert-success"'?>>
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
                                    <?php
                                    $date = date_create($ticket->collection_at);
                                    ?>
                                    <td>{{ date_format($date,"d/m/Y H:i:s") }}</td>
                                    <td><a href="home/{{ $ticket->id }}" class="btn btn-success btn-sm">Pull</a></td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".alert").fadeTo(2000, 500).slideUp(500, function () {
                $(".alert").slideUp(500);
            });
        });
    </script>
@endsection
