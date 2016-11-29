@extends('layouts.app')

@section('content')
    <style>
        td,th{
            text-align: center;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-lg-12 col-md-offset-1 col-lg-offset-0">
                <div class="form-group">
                    <a href="/#" class="btn btn-default active">Manager Reports</a>
                </div>
                <div id="panel" class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Manager Report <span id="weekSrt" style="font-weight: bold;"></span> to
                            <span id="weekE" style="font-weight: bold;"></span><span id="reportComplete" style="font-weight: bold;"></span>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div id="content">
                            <form id="weeklynotes">

                                <fieldset>
                                    <table id="" class="table table-bordered" cellspacing="0" width="100%" style="color: white">
                                        <thead>
                                        <tr>
                                            <th>FEE</th>
                                            <th>Payment Method</th>
                                            <th>Valet App Car Count</th>
                                            <th id="revenue">Revenue/£</th>

                                        </tr>
                                        </thead>
                                        <tr>
                                            <td>£20</td>
                                            <td>Cash</td>
                                            <td id="cash">0</td>
                                            <td id="revcash" class="cashtimes20">0</td>
                                        </tr>
                                        <tr>
                                            <td>£20</td>
                                            <td>Card</td>
                                            <td id="card">0</td>
                                            <td id="cardtimes20">0</td>
                                        </tr>


                                        {{--<tr>--}}
                                            {{--<td></td>--}}
                                            {{--<td><div class="pull-right"><b>Subtotal</b></div></td>--}}
                                            {{--<td class="subtotalCarCount">0</td>--}}
                                        {{--</tr>--}}

                                        <tr>
                                            <td>VIP-FREE</td>
                                            <td>N/A</td>
                                            <td id="vip">0</td>
                                            <td>-</td>
                                        </tr>
                                        <tfoot style="font-weight: bold">
                                        <td></td>
                                        <td><div class="pull-right"><b>TOTAL</b></div></td>
                                        <td id="carCount">0</td>
                                        <td id="totalRevenue">0</td>
                                        </tfoot>
                                    </table>
                                    {{--<textarea id="notes" name="weekly_notes" placeholder="NOTES:" class="form-control" rows="5"></textarea>--}}
                                    <div id="pageID"><input name="page_id" value="1" hidden></div>
                                    <div id="existing"></div>
                                    <input name="actual_total" id="actual_total" hidden>
                                </fieldset>
                            </form>
                            <input id="originalCashTimes20" hidden>
                            <input id="originalCardTimes20" hidden>
                            <input id="originaltrxFee" hidden>
                            <input id="originalTotalCardIncome" hidden>
                            <input id="originalGrandTotal" hidden>
                        </div>

                        <div style="color: white" class="form-group col-md-4 col-lg-4">
                            <h4>Please choose a start date</h4>
                                <div class="date">
                                    <input  name="date_timepicker_start" class="form-control" id="date_timepicker_start" type="text" >
                                </div>
                        </div>
                        <div style="color: white" class="form-group col-md-4 col-lg-4">
                            <h4>Please choose a end date</h4>
                                <div class="date">
                                    <input  name="date_timepicker_end" class="form-control" id="date_timepicker_end" type="text" >
                                </div>
                        </div>
                            <div style="color: white" class="form-group col-md-4 col-lg-4">
                                <div class="date" style="padding-top: 38px">
                                    <input id="getDates" type="button" class="btn btn-success" value="Apply">
                                </div>
                        </div>


                        {{--<div class="text-center" id="page-selection" style="color: white"></div>--}}
                        {{--<div class="text-center" style="color: white">--}}
                            {{--<h4>Please choose a week</h4>--}}
                        {{--</div>--}}
                        <script>

                            jQuery(function(){
                                jQuery('#date_timepicker_start').datetimepicker({
                                    theme:'dark',
                                    format:'d/m/Y',
                                    onShow:function( ct ){
                                        this.setOptions({
                                            maxDate:jQuery('#date_timepicker_end').val()?jQuery('#date_timepicker_end').val():false
                                            //console.log(maxDate)
                                        })
                                    },
                                    timepicker:false
                                });

                                jQuery('#date_timepicker_end').datetimepicker({
                                    theme:'dark',
                                    format:'d/m/Y',
                                    onShow:function( ct ){
                                        this.setOptions({
                                            //minDate:jQuery('#date_timepicker_start').val()?jQuery('#date_timepicker_start').val():false
                                        })
                                    },
                                    timepicker:false
                                });
                            });

                            function actual() {
                                var total = null;
                                var subTotal = null;
                                var actualCash = parseInt($('#actualCash').val());
                                var actualCard = parseInt($('#actualCard').val());
                                var actualNotPaid = parseInt($('#actualNotPaid').val());
                                var actualVIP = parseInt($('#actualVIP').val());
                                total = actualCash+actualCard+actualNotPaid+actualVIP;
                                subTotal = actualCash+actualCard+actualNotPaid;

                                $('#actualSubtotalCarCount').html(subTotal);

                                $('#actualTotal').html(total);
                                $('#actual_total').val(total);
                                //ACTUAL CASH CHANGE
                                if(actualCash==0 || $('#actualCash').val().length === 0){
                                    $('.cashtimes20').html($('#originalCashTimes20').val());

                                } else {
                                    var cash = actualCash * 20;
                                    $('.cashtimes20').html(cash.toFixed(2));

                                }
                                //ACTUAL CARD CHANGE
                                if(actualCard==0 || $('#actualCard').val().length === 0){
                                    $('#cardtimes20').html($('#originalCardTimes20').val());
                                    $('.trxFee').html($('#originaltrxFee').val());
                                    $('#totalCardIncome').html($('#originalTotalCardIncome').val());

                                } else {
                                    var card = actualCard * 20;
                                    $('#cardtimes20').html(card.toFixed(2));
                                    var trx = actualCard * 20 * 2.75 / 100;
                                    $('.trxFee').html(trx.toFixed(2));
                                    var totcardinc = (actualCard * 20)-(actualCard * 20 * 2.75 / 100);
                                    $('#totalCardIncome').html(totcardinc.toFixed(2));

                                }
                                var gt = +$('#cash20').html() + +$('#totalCardIncome').html();
                                var revcash = +$('#revcash').html() + +$('#cardtimes20').html();
                                $('#totalRevenue').html(revcash.toFixed(2));
                                $('#grandTotal').html(gt.toFixed(2));
                            }

                            $("#existing_customer").click(function () {
                                $("#existing_customer").toggleClass('btn-danger').toggleClass('btn-success');
                                if(this.value == 'In Progress')
                                {
                                    this.value = 'Completed';
                                    $('#existing').empty();
                                    $('#existing').append("<input type='text' value='1' name='complete' hidden />");
                                    $('#notes').attr("readonly", "readonly");
                                    $('#actualCash').attr("readonly", "readonly");
                                    $('#actualCard').attr("readonly", "readonly");
                                    $('#actualNotPaid').attr("readonly", "readonly");
                                    $('#actualVIP').attr("readonly", "readonly");
                                    $('#reportComplete').text(' -COMPLETED');
                                    $('#panel').removeClass('panel-default').removeClass('panel-warning').addClass('panel-success');
                                    $('#revenue').replaceWith('<th id="revenue">Revenue/£</th>');
                                    $('#trx').replaceWith('<th id="trx">Trx Fee/£</th>');
                                    $('#income').replaceWith('<th id="income">Income/£</th>');
                                    addNote();
                                }
                                else {
                                    this.value = 'In Progress';
                                    $('#existing').empty();
                                    $('#existing').append("<input type='text' value='0' name='complete' hidden />");
                                    $('#notes').removeAttr("readonly", "readonly");
                                    $('#actualCash').removeAttr("readonly", "readonly");
                                    $('#actualCard').removeAttr("readonly", "readonly");
                                    $('#actualNotPaid').removeAttr("readonly", "readonly");
                                    $('#actualVIP').removeAttr("readonly", "readonly");
                                    $('#reportComplete').text(' -IN PROGRESS');
                                    $('#panel').removeClass('panel-default').removeClass('panel-success').addClass('panel-warning');
                                    addNote();

                                    if ($("#revenue:contains(Forecast)").length == 0) {
                                        $('#revenue').prepend('Forecast ');
                                        $('#trx').prepend('Forecast ');
                                        $('#income').prepend('Forecast ');
                                    }
                                }
                            });


                            // init bootpag

                            $('#getDates').on('click', function () {
                                var start = $('#date_timepicker_start').datetimepicker('getValue');
                                var end = $('#date_timepicker_end').datetimepicker('getValue');

                                var curr_date = start.getDate();
                                var curr_month = start.getMonth() + 1; //Months are zero based
                                var curr_year = start.getFullYear();
                                var curr_date_end = end.getDate();
                                var curr_month_end  = end.getMonth() + 1; //Months are zero based
                                var curr_year_end  = end.getFullYear();
                                $.post("/reports/weekly-report",
                                        {
                                            period: 'manager',
                                            day: curr_date,
                                            month: curr_month,
                                            year: curr_year,
                                            day_end: curr_date_end,
                                            month_end: curr_month_end,
                                            year_end: curr_year_end
                                        },
                                        function(result, status){
                                            console.log(status)
                                            $('#card').html(result.card);
                                            $('#cardtimes20').html(result.card*20);
                                            var originalCard = result.card*20;
                                            $('#originalCardTimes20').val(originalCard.toFixed(2));
                                            $('#cardcharges').html(result.card*20.00*0.925);
                                            $('#cash').html(result.cash);
                                            var cash20 = result.cash*20;
                                            $('.cashtimes20').html(cash20.toFixed(2));
                                            $('#originalCashTimes20').val(cash20.toFixed(2));
                                            $('#cashcharges').html(result.cash*20);
                                            $('#notPaid').html(result.not_paid);
                                            $('#vip').html(result.vip);
                                            $('#carCount').html(result.car_count);
                                            $('#totalCarCount').html(result.card  + result.cash +  result.not_paid + result.vip);
                                            var totCardinc = (result.card * 20)-(result.card * 20 * 2.75 / 100);
                                            $('#totalCardIncome').html(totCardinc.toFixed(2));
                                            $('#originalTotalCardIncome').val(totCardinc.toFixed(2));
                                            var totgrandtot = (result.card * 20)-(result.card * 20 * 2.75 / 100) +  result.cash * 20;
                                            $('#grandTotal').html(totgrandtot.toFixed(2));
                                            $('#originalGrandTotal').val(totgrandtot.toFixed(2));

                                            var totalRev = (result.card * 20) + (result.cash * 20);
                                            $('#totalRevenue').html(totalRev.toFixed(2));
                                            $('.subtotalCarCount').html(result.card  + result.cash +  result.not_paid);
                                            var tax = result.card * 20 * 2.75 / 100;
                                            $('.trxFee').html(tax.toFixed(2));
                                            $('#originaltrxFee').val(tax.toFixed(2));
                                            $('#weekSrt').html(result.weekSrt);
                                            $('#weekE').html(result.weekE);
                                            $('#pageID').empty();
                                            $('<input>').attr('name','page_id').attr( 'value', num)
                                                    .attr('type', 'hidden').appendTo('#pageID');

                                            //console.log(result.notes);


                                                if ($("#revenue:contains(Forecast)").length == 0) {
                                                    $('#revenue').prepend('Forecast ');
                                                    $('#trx').prepend('Forecast ');
                                                    $('#income').prepend('Forecast ');
                                                }



                                        }).fail(function(xhr, status, error) {
                                    console.log( error );
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
