@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-10 col-lg-12 col-md-offset-1 col-lg-offset-0">
                <div class="panel panel-warning">
                    <div class="panel-heading">Daily Car Count {{ \Carbon\Carbon::today()->format('d-m-Y') }}</div>
                    <div class="panel-body">
                        <table id="" class="table" cellspacing="0" width="100%" style="color: white">
                            <thead>
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>£</th>
                            </tr>
                            </thead>
                            <tr>
                                <td>£20-Card</td>
                                <td>{{ $card }}</td>
                                <td>{{ $card * 20 }}</td>
                            </tr>
                            <tr>
                                <td>£20-Cash</td>
                                <td>{{ $cash }}</td>
                                <td>{{ $cash * 20 }}</td>
                            </tr>
                            <tr>
                                <td>£20 (Not Paid)</td>
                                <td>{{ $not_paid }}</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>VIP-Free (Not Paid)</td>
                                <td>{{ $vip }}</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>{{ $car_count }}</td>
                                <td>{{ ($card * 20) + ($cash * 20) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection