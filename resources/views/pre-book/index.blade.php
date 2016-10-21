@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div style="padding-bottom: 10px">
            @if($user->name==='visitorcentre')
                <a class="btn btn-warning active" href="/pre-booking">Pre Booked</a>
            @else
                <a class="btn btn-primary" href="/home">Active</a>
                <a class="btn btn-success" href="/collections">Collections</a>
                <a class="btn btn-warning active" href="/pre-booking">Pre Booked</a>
                <a class="btn btn-default" href="/history">History</a>
            @endif
        </div>
        <div class="row">
            <div class="col-md-10 col-lg-10 col-md-offset-1">
                <div class="panel panel-warning">
                    <div class="panel-heading">{{ $user->name }}, you are logged in!</div>

                    <div class="panel-body">
                        <a href="/pre-booking/create" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                        <h3 class="text-center" style="color: white">Pre Booked</h3>

                        <table class="table" style="color: white">
                            <tr>
                                <th>Car</th>
                                <th>Name</th>
                                {{--@if(Auth::user()->name=='visitorcentre')--}}
                                    <th>Date to Arrive</th>
                                    <th>Action</th>
                                {{--@endif--}}

                            </tr>
                            {{--@if(Auth::user()->name=='visitorcentre')--}}
                                @foreach($pre_books as $pre_booked)
                                    <tr>
                                        <td>{{ $pre_booked->ticket_manufacturer }}, {{ $pre_booked->ticket_model }}, {{ $pre_booked->ticket_colour }}</td>
                                        <td>
                                            @if($pre_booked->existing_customer=="Yes")
                                                <i class="fa fa-user" style="color: pink" aria-hidden="true"></i>
                                            @endif
                                            @if($pre_booked->ticket_price=='VIP-FREE')
                                                <i class="fa fa-star" style="color: gold" aria-hidden="true"></i>
                                            @endif
                                            {{ $pre_booked->ticket_name }}
                                        </td>
                                        @if($pre_booked->ticket_mobile && $pre_booked->ticket_price && $pre_booked->ticket_name
                                        && $pre_booked->booked_in_by && $pre_booked->ticket_driver)
                                            <td><a href="issue/{{ $pre_booked->id }}" class="btn btn-success btn-sm">Issue</a></td>
                                        @endif
                                        {{--@if(Auth::user()->name=='visitorcentre')--}}
                                            <?php
                                            $date = date_create($pre_booked->booking_date);
                                            ?>
                                            <td>{{ date_format($date,"d/m/Y g:i:sa") }}</td>
                                        {{--@endif--}}
                                        <td><a href="home/{{ $pre_booked->id }}/edit" class="btn btn-default">Edit</a></td>
                                        {{--only if visitor centre--}}
                                        @if(Auth::user()->name=='visitorcentre')
                                            {!! Form::model($pre_booked,[
                                                'method' => 'DELETE',
                                                'route' => ['pre-booking.destroy', $pre_booked->id],
                                                'class' => '']) !!}
                                                {{ csrf_field() }}
                                        <td><button type="submit" class="btn btn-primary">Remove</button></td>
                                            {{--<td><a href="home/{{ $pre_booked->id }}/edit" class="btn btn-primary">Remove</a></td>--}}
                                            </form>
                                        @endif
                                    </tr>
                                @endforeach
                                {{--@else--}}
                                    {{--@foreach($today_pre_books as $pre_booked)--}}
                                        {{--<tr>--}}
                                            {{--<td style="text-transform:uppercase">{{ $pre_booked->ticket_registration }}</td>--}}
                                            {{--<td>--}}
                                                {{--@if($pre_booked->existing_customer=="Yes")--}}
                                                    {{--<i class="fa fa-user" style="color: pink" aria-hidden="true"></i>--}}
                                                {{--@endif--}}
                                                {{--@if($pre_booked->ticket_price=='VIP-FREE')--}}
                                                    {{--<i class="fa fa-star" style="color: gold" aria-hidden="true"></i>--}}
                                                {{--@endif--}}
                                                {{--{{ $pre_booked->ticket_name }}--}}
                                            {{--</td>--}}
                                            {{--@if($pre_booked->ticket_mobile && $pre_booked->ticket_price && $pre_booked->ticket_name--}}
                                            {{--&& $pre_booked->booked_in_by && $pre_booked->ticket_driver)--}}
                                                {{--<td><a href="issue/{{ $pre_booked->id }}" class="btn btn-success btn-sm">Issue</a></td>--}}
                                            {{--@endif--}}
                                            {{--@if(Auth::user()->name=='visitorcentre')--}}
                                                {{--<td>{{ $pre_booked->booking_date }}</td>--}}
                                            {{--@endif--}}
                                            {{--<td><a href="home/{{ $pre_booked->id }}/edit" class="btn btn-default">Edit</a></td>--}}
                                            {{--only if visitor centre--}}
                                            {{--@if(Auth::user()->name=='visitorcentre')--}}
                                                {{--<td><a href="home/{{ $pre_booked->id }}/edit" class="btn btn-primary">Remove</a></td>--}}
                                            {{--@endif--}}
                                        {{--</tr>--}}
                                    {{--@endforeach--}}
                            {{--@endif--}}
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
