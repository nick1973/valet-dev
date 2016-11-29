@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">Ticket No {{ $ticket->ticket_number }}{{ $ticket->valet1_ticket_id }}{{ $ticket->valet2_ticket_id }}
                        {{ $ticket->valet3_ticket_id }}</div>

                    <div class="panel-body">
                        {!! Form::model($ticket,[
                            'method' => 'PATCH',
                            'route' => ['home.update', $ticket->id],
                            'id' => 'collect']) !!}
                        {{ csrf_field() }}

                            <div id="collection" class="form-group col-xs-7">
                                @if($ticket->ticket_status=="collection")
                                    <input id="existing_customer" type="button" class="btn btn-success"
                                           value="Customer is Collecting">
                                    <input type='text' value='active' name='ticket_status' hidden />
                                    <input type="datetime" name="collection_at" value="" hidden>
                                @else
                                    <input id="existing_customer" type="button" class="btn btn-danger"
                                           value="To Collect">
                                    <input type='text' value='collection' name='ticket_status' hidden />
                                    {!! Form::dateTime('collection_at', \Carbon\Carbon::now(),['hidden']) !!}
                                @endif
                            </div>
                        </form>
                        <table class="table" style="color: white">
                            <?php
                                $date = date_create($ticket->collection_at);
                            ?>
                            @if($ticket->collection_at!=="0000-00-00 00:00:00")
                            <tr>
                                <td>Collection: <?php echo empty($ticket->collection_at) ? "" : "<span style='word-wrap: break-word;color: green'>" . date_format($date,"d/m/Y") . " .... " . date_format($date,"H:i:s") . "</span>"; ?></td>
                            </tr>
                            @endif
                            <tr>
                                <td>Arrived: <?php echo empty($ticket->created_at) ? "" : "<span style='word-wrap: break-word;color: green'>" . date_format($ticket->created_at,"d/m/Y") . " .... " . date_format($ticket->created_at,"H:i:s") . "</span>"; ?></td>
                            </tr>

                            <tr>
                                <td>Name: <?php echo empty($ticket->ticket_name) ? "" : "<span style='word-wrap: break-word;color: green'>" .$ticket->ticket_name. "</span>"; ?></td>
                            </tr>

                            <tr>
                                <td>Mobile: <?php echo empty($ticket->ticket_mobile) ? "" : "<span style='color: green'>" .$ticket->ticket_mobile. "</span>"; ?></td>
                            </tr>

                            <tr>
                                <td>Registration: <?php echo empty($ticket->ticket_registration) ? "" : "<span style='text-transform:uppercase;color: green'>" .$ticket->ticket_registration. "</span>"; ?></td>
                            </tr>

                            <tr>
                                <td>Existing Customer: <?php echo empty($ticket->existing_customer) ? "" : "<span><i class='fa fa-asterisk' style='color: gold' aria-hidden='true'></i></span>"; ?></td>
                            </tr>

                            <tr>
                                <td>Manufacturer: <?php echo empty($ticket->ticket_manufacturer) ? "" : "<span style='color: green'>" .$ticket->ticket_manufacturer. "</span>"; ?></td>
                            </tr>

                            <tr>
                                <td>Model: <?php echo empty($ticket->ticket_model) ? "" : "<span style='color: green'>" .$ticket->ticket_model. "</span>"; ?></td>
                            </tr>

                            <tr>
                                <td>Colour: <?php echo empty($ticket->ticket_colour) ? "" : "<span style='color: green'>" .$ticket->ticket_colour. "</span>"; ?></td>
                            </tr>

                            <tr>
                                <td>Notes: <?php echo empty($ticket->ticket_notes) ? "" : "<span style='color: green'>" .$ticket->ticket_notes. "</span>"; ?></td>
                            </tr>
                        </table>
                            {{--<form id="priceForm" class="form-viritical" action="/home/{{ $ticket->id }}" method="post">--}}
                                {{--{!! Form::open(array('route' => array('home.update', $ticket->id)), []) !!}--}}
                            {!! Form::model($ticket,[
                            'method' => 'PATCH',
                            'route' => ['home.update', $ticket->id],
                            'id'=>'priceForm']) !!}
                                {{ csrf_field() }}
                                <select name="ticket_price" class="form-control" id="ticket_price">
                                    <option>{{ $ticket->ticket_price }}</option>
                                    <option value="£20">£20</option>
                                    <option value="VIP-FREE">VIP-FREE</option>
                                    {{--<option value="10">Self drive-£10</option>--}}
                                </select>
                                <div id="paymentMethod" class="col-xs-12"></div>
                            </form>
                        {{--@if($ticket->ticket_price == 'VIP-FREE')--}}
                            <div class="col-xs-12 row vip" style="padding-bottom: 10px; padding-top: 10px">
                                <div onclick="submitPrice('')" class="col-xs-4"><button type="submit" class="btn btn-warning">Confirm VIP</button></div>
                                {{--<div onclick="submitPrice('Cash Payment')" class="col-xs-4"><button type="submit" class="btn btn-primary">Paid Cash</button></div>--}}
                                {{--<div onclick="submitPrice('Not Paid')" class="col-xs-4"><button type="submit" class="btn btn-danger">Not Paid</button></div>--}}
                            </div>
                        {{--@else--}}
                            <div class="col-xs-12 row non_vip" style="padding-bottom: 10px; padding-top: 10px">
                                <div onclick="submitPrice('Card Payment')" class="col-xs-4"><button type="submit" class="btn btn-success">Paid Card</button></div>
                                <div onclick="submitPrice('Cash Payment')" class="col-xs-4"><button type="submit" class="btn btn-primary">Paid Cash</button></div>
                                {{--<div onclick="submitPrice('Not Paid')" class="col-xs-4"><button type="submit" class="btn btn-danger">Not Paid</button></div>--}}
                            </div>
                        {{--@endif--}}
                        <div id="submit" class="form-group"></div>
                        <div class="col-xs-12 row" style="padding-bottom: 10px">
                            <input class="btn btn-default pull-left" type="button" value="Back" onclick="window.history.back()">
                            {{--<a href="/home" class="btn btn-default pull-left">Back</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            var payment = '{{ $ticket->ticket_price }}'
            if (payment == 'VIP-FREE'){
                $(".non_vip").hide()
                $(".vip").show('fade')
            } else {
                $(".vip").hide()
                $(".non_vip").show('fade')
            }
        });


        $("#ticket_price").change(function (e) {
            console.log($(this).val())
            if($(this).val()=='VIP-FREE'){
                $(".non_vip").hide()
                $(".vip").show('fade')
            } else {
                $(".vip").hide()
                $(".non_vip").show('fade')
            }
        })

        function submitted(){
            $("#priceForm").submit();
        };

        function submitPrice(payment) {
            $('#paymentMethod').empty();
            $('#paymentMethod').append("<input type='text' value='" + payment + "' name='ticket_payment' hidden />");
            $('#paymentMethod').append("<input type='text' value='complete' name='ticket_status' hidden />");
            $('#submit').empty();
            $('#submit').append("<div class='col-xs-12 text-center'><p style='color: white'>" + payment + "</p></div>");
            $('#submit').append("<input onclick='submitted()' type='submit' value='Done' class='form-control btn-warning' />");
        }

        $("#existing_customer").click(function () {
            $("#existing_customer").toggleClass('btn-danger').toggleClass('btn-success');
            if(this.value == 'To Collect')
            {
                this.value = 'Customer is Collecting';
                $('#collect').submit();
            }
            else {
                this.value = 'To Collect';
                $('#collect').submit();

            }
        });
    </script>
@endsection
