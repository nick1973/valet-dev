@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Ticket Number {{ $ticket->ticket_number }}{{ $ticket->valet1_ticket_id }}{{ $ticket->valet2_ticket_id }}
                        {{ $ticket->valet3_ticket_id }}
                    </div>

                    <div class="panel-body">
                        <div class="col-xs-5">
                            <p style="color: white">Created</p>
                            <p style="color: white">Collection</p>
                            <p style="color: white">Paid</p>
                            <p style="color: white">Name</p>
                            <p style="color: white">Mobile</p>
                            <p style="color: white">Registration</p>
                            <p style="color: white">Existing</p>
                            <p style="color: white">Manufacturer</p>
                            <p style="color: white">Model</p>
                            <p style="color: white">Colour</p>
                            <p style="color: white">Notes</p>
                            <p style="color: white">Price</p>
                        </div>

                        <div class="col-xs-7">
                            <?php
                            $date = date_create($ticket->collection_at);
                            ?>
                            <p><?php echo empty($ticket->created_at) ? "" : "<span style='color: white'>" . date_format($ticket->created_at,"d/m/Y") . " .... " . date_format($ticket->created_at,"H:i:s") . "</span>"; ?></p>

                                @if($ticket->collection_at!=="0000-00-00 00:00:00")
                                    <p><?php echo empty($ticket->collection_at) ? "" : "<span style='color: white'>" . date_format($date,"d/m/Y") . " .... " . date_format($date,"H:i:s") . "</span>"; ?></p>
                                @else
                                    <p>No time</p>
                                @endif
                                @if($ticket->ticket_status=="complete")
                                <p><?php echo empty($ticket->updated_at) ? "" : "<span style='color: white'>" . date_format($ticket->updated_at,"d/m/Y") . " .... " . date_format($ticket->updated_at,"H:i:s") . "</span>"; ?></p>
                                @else
                                    <p>No time</p>
                                @endif
                                    <p><?php echo empty($ticket->ticket_name) ? "." : "<span style='color: white'>" .$ticket->ticket_name. "</span>"; ?></p>
                                    <p><?php echo empty($ticket->ticket_mobile) ? "." : "<span style='color: white'>" .$ticket->ticket_mobile. "</span>"; ?></p>
                                    <p><?php echo empty($ticket->ticket_registration) ? "." : "<span style='text-transform:uppercase;color: white'>" .$ticket->ticket_registration. "</span>"; ?></p>
                                    <p><?php echo empty($ticket->existing_customer) ? "." : "<span><i class='fa fa-asterisk' style='color: gold' aria-hidden='true'></i></span>"; ?></p>
                                    <p><?php echo empty($ticket->ticket_manufacturer) ? "." : "<span style='color: white'>" .$ticket->ticket_manufacturer. "</span>"; ?></p>
                                    <p><?php echo empty($ticket->ticket_model) ? "." : "<span style='color: white'>" .$ticket->ticket_model. "</span>"; ?></p>
                                    <p><?php echo empty($ticket->ticket_colour) ? "." : "<span style='color: white'>" .$ticket->ticket_colour. "</span>"; ?></p>
                                    <p><?php echo empty($ticket->ticket_notes) ? "." : "<span style='color: white'>" .$ticket->ticket_notes. "</span>"; ?></p>
                                    <p><?php echo empty($ticket->ticket_price) ? "." : "<span style='color: white'>" .$ticket->ticket_price. "</span>"; ?></p>
                        </div>
                        <div class="col-xs-12 row" style="padding-bottom: 10px">
                            <a href="/history" class="btn btn-default pull-left">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
