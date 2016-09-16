@extends('layouts.app')

@section('content')
    <style>
        td,th{
            text-align: center;
        }
    </style>
    @if(Auth::user()->name=='bvfinance')
        <script>
            $( document ).ready(function() {
                $("fieldset").attr("disabled", true);
            });
        </script>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-lg-12 col-md-offset-1 col-lg-offset-0">
                <div class="form-group">
                    <a href="/reports/weekly-report" class="btn btn-default active">Weekly Reports</a>
                    <a href="/reports/monthly-report" class="btn btn-primary">Monthly Reports</a>
                </div>
                <div id="panel" class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Weekly Report <span id="weekSrt" style="font-weight: bold;"></span> to
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
                                    {{--@if(Auth::user()->name=='ctmfinance')--}}
                                        <th>Actual</th>
                                    {{--@endif--}}
                                    <th id="revenue">Revenue/£</th>
                                    <th>Trx. %age Charge</th>
                                    <th id="trx">Trx Fee/£</th>
                                    <th id="income">Income/£</th>
                                </tr>
                                </thead>
                                <tr>
                                    <td>£20</td>
                                    <td>Cash</td>
                                    <td id="cash">0</td>
                                    {{--@if(Auth::user()->name=='ctmfinance')--}}
                                        <th class="col-lg-1"><input name="actual_cash" onkeyup="actual()" id="actualCash" class="form-control text-center" placeholder="TBA"></th>
                                    {{--@endif--}}
                                    <td id="revcash" class="cashtimes20">0</td>
                                    <td>0</td>
                                    <td>-</td>
                                    <td id="cash20" class="cashtimes20">0</td>
                                </tr>
                                <tr>
                                    <td>£20</td>
                                    <td>Card</td>
                                    <td id="card">0</td>
{{--                                    @if(Auth::user()->name=='ctmfinance')--}}
                                        <th class="col-lg-1"><input name="actual_card" onkeyup="actual()" id="actualCard" class="form-control text-center" placeholder="TBA"></th>
                                    {{--@endif--}}
                                    <td id="cardtimes20">0</td>
                                    <td>2.75%</td>
                                    <td class="trxFee">0</td>
                                    <td id="totalCardIncome">0</td>
                                </tr>

                                <tr>
                                    <td>£20</td>
                                    <td>Not Paid</td>
                                    <td id="notPaid">0</td>
                                    {{--@if(Auth::user()->name=='ctmfinance')--}}
                                        <th class="col-lg-1"><input name="actual_not_paid" onkeyup="actual()" id="actualNotPaid" class="form-control text-center" placeholder="TBA"></th>
                                    {{--@endif--}}
                                </tr>

                                <tr>
                                    <td></td>
                                    <td><div class="pull-right"><b>Subtotal</b></div></td>
                                    <td class="subtotalCarCount">0</td>
                                    {{--@if(Auth::user()->name=='ctmfinance')--}}
                                        <th id="actualSubtotalCarCount">0</th>
                                    {{--@endif--}}
                                </tr>

                                <tr>
                                    <td>VIP-FREE</td>
                                    <td>N/A</td>
                                    <td id="vip">0</td>
                                    {{--@if(Auth::user()->name=='ctmfinance')--}}
                                        <th class="col-lg-1"><input name="actual_vip" onkeyup="actual()" id="actualVIP" class="form-control text-center" placeholder="TBC"></th>
                                    {{--@endif--}}
                                </tr>
                                <tfoot style="font-weight: bold">
                                    <td></td>
                                    <td><div class="pull-right"><b>TOTAL</b></div></td>
                                    <td id="carCount">0</td>
{{--                                    @if(Auth::user()->name=='ctmfinance')--}}
                                        <th id="actualTotal">0</th>
                                    {{--@endif--}}
                                    <td id="totalRevenue">0</td>
                                    <td></td>
                                    <td class="trxFee">0</td>
                                    <td id="grandTotal">0</td>
                                </tfoot>
                                </table>
                                <textarea id="notes" name="weekly_notes" placeholder="NOTES:" class="form-control" rows="5"></textarea>
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
                            <div class="" style="padding-top: 10px">
                                @if(Auth::user()->name=='ctmfinance')
                                    @if($weekly_report->isEmpty())
                                        <input id="existing_customer" type="button" class="btn btn-danger"
                                               value="In Progress">
                                        @else
                                            <input id="existing_customer" type="button" class="btn btn-success"
                                                   value="Completed">
                                    @endif
                                        {{--<button onclick="addNote()" class="btn btn-success pull-right">Save Report</button>--}}
                                @endif
                            </div>
                        </div>
                        <div class="text-center" id="page-selection" style="color: white"></div>
                        <div class="text-center" style="color: white">
                            <h4>Please choose a week</h4>
                        </div>
                        <script>
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

                            function addNote() {
                                var formData = $("#weeklynotes").serializeArray();
                                $.ajax({
                                    url : "/reports/weekly_notes",
                                    type: "POST",
                                    data : formData,
                                    success: function(data, textStatus, jqXHR)
                                    {
                                        //data - response from server
                                    },
                                    error: function (jqXHR, textStatus, errorThrown)
                                    {
                                    }
                                });
                            }

                            // init bootpag
                            $('#page-selection').bootpag({
                                total: 52,
                                page: 1,
                                maxVisible: 13
                            }).on("page", function(event, /* page number here */ num){
                                var d = new Date("3/28/2016");
                                d.setDate(d.getDate() + 7 * num);
                                var curr_date = d.getDate();
                                var curr_month = d.getMonth() + 1; //Months are zero based
                                var curr_year = d.getFullYear();

                                $.post("/reports/weekly-report",
                                        {
                                            page_id: num,
                                            period: 'weekly',
                                            day: curr_date,
                                            month: curr_month,
                                            year: curr_year
                                        },
                                        function(result, status){
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

                                            console.log(result.notes);
                                            if(result.notes.length > 0)
                                            {
                                                for (var i = 0; i < result.notes.length; i++)
                                                {
                                                    if(result.notes[i]['actual_total'] > '0'){
                                                        $('#actualCash').val(result.notes[i]['actual_cash']);
                                                        $('#actualCard').val(result.notes[i]['actual_card']);
                                                        $('#actualNotPaid').val(result.notes[i]['actual_not_paid']);
                                                        $('#actualVIP').val(result.notes[i]['actual_vip']);
                                                        $('#actualTotal').html(result.notes[i]['actual_total']);
                                                    } else {
                                                        $('#actualTotal').html('0');
                                                        $('#actualCash').val('0');
                                                        $('#actualCard').val('0');
                                                        $('#actualNotPaid').val('0');
                                                        $('#actualVIP').val('0');
                                                    }

                                                    if(result.notes[i]['complete']==1)
                                                    {
                                                        //COMPLETE
                                                        $('#panel').removeClass('panel-default').removeClass('panel-warning').addClass('panel-success');
                                                        $('#notes').attr("readonly", "readonly");
                                                        $("#existing_customer").addClass('btn-success').removeClass('btn-danger').val('Completed');
                                                        $('#reportComplete').text(' -COMPLETED');
                                                        $('#actualCash').attr("readonly", "readonly");
                                                        $('#actualCard').attr("readonly", "readonly");
                                                        $('#actualNotPaid').attr("readonly", "readonly");
                                                        $('#actualVIP').attr("readonly", "readonly");
                                                        $('#revenue').replaceWith('<th id="revenue">Revenue/£</th>');
                                                        $('#trx').replaceWith('<th id="trx">Trx Fee/£</th>');
                                                        $('#income').replaceWith('<th id="income">Income/£</th>');
                                                    } else {
                                                        //IN PROGRESS
                                                        $('#panel').removeClass('panel-default').removeClass('panel-success').addClass('panel-warning');
                                                        $('#notes').removeAttr("readonly", "readonly");
                                                        $('#actualCash').removeAttr("readonly", "readonly");
                                                        $('#actualCard').removeAttr("readonly", "readonly");
                                                        $('#actualNotPaid').removeAttr("readonly", "readonly");
                                                        $('#actualVIP').removeAttr("readonly", "readonly");
                                                        $("#existing_customer").addClass('btn-danger').removeClass('btn-success').val('In Progress');
                                                        $('#reportComplete').text(' -IN PROGRESS');
//                                                        $('#revenue').replaceWith('<th id="revenue">Revenue/£</th>');
//                                                        $('#trx').replaceWith('<th id="trx">Trx Fee/£</th>');
//                                                        $('#income').replaceWith('<th id="income">Income/£</th>');
                                                        //console.log('boo');
                                                        if ($("#revenue:contains(Forecast)").length == 0) {
                                                            $('#revenue').prepend('Forecast ');
                                                            $('#trx').prepend('Forecast ');
                                                            $('#income').prepend('Forecast ');
                                                        }

                                                    }
                                                    //NOTES BUT IN PROGRESS
                                                    //$('#panel').removeClass('panel-default').removeClass('panel-success').addClass('panel-warning');
                                                    $('#notes').val('');
                                                    $('#notes').val(result.notes[i]['weekly_notes']);
//                                                    $('#revenue').replaceWith('<th id="revenue">Revenue/£</th>');
//                                                    $('#trx').replaceWith('<th id="trx">Trx Fee/£</th>');
//                                                    $('#income').replaceWith('<th id="income">Income/£</th>');
                                                }
                                            } else {
                                                //NO NOTES AND IN PROGRESS
                                                $('#panel').removeClass('panel-default').removeClass('panel-success').addClass('panel-warning');
                                                $('#notes').val('');
                                                $('#notes').removeAttr("readonly", "readonly");
                                                $('#actualCash').removeAttr("readonly", "readonly");
                                                $('#actualCard').removeAttr("readonly", "readonly");
                                                $('#actualNotPaid').removeAttr("readonly", "readonly");
                                                $('#actualVIP').removeAttr("readonly", "readonly");
                                                $("#existing_customer").addClass('btn-danger').removeClass('btn-success').val('In Progress');
                                                $('#reportComplete').text(' -IN PROGRESS');
                                                $('#actualTotal').html('TBA');
                                                $('#actualCash').attr('placeholder','TBA').val('');
                                                $('#actualCard').attr('placeholder','TBA').val('');
                                                $('#actualNotPaid').attr('placeholder','TBA').val('');
                                                $('#actualVIP').attr('placeholder','TBA').val('');
                                                //console.log($("#revenue:contains(Forecast)").length);

                                                    if ($("#revenue:contains(Forecast)").length == 0) {
                                                        $('#revenue').prepend('Forecast ');
                                                        $('#trx').prepend('Forecast ');
                                                        $('#income').prepend('Forecast ');
                                                    }

                                            }
                                            actual();
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection