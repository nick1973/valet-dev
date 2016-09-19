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
                    <a href="/reports/weekly-report" class="btn btn-default">Weekly Reports</a>
                    <a href="/reports/monthly-report" class="btn btn-primary active">Monthly Reports</a>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4>Monthly Report <span id="weekSrt" style="font-weight: bold;"></span> to
                            <span id="weekE" style="font-weight: bold;"></span></h4>
                    </div>
                    <div class="panel-body">
                        <div id="content">
                            <table id="" class="table table-bordered" cellspacing="0" width="100%" style="color: white">
                                <thead>
                                <tr>
                                    <th>FEE</th>
                                    <th>Payment Method</th>
                                    <th>Valet App Car Count</th>
                                    <th>Revenue/£</th>
                                    <th>Trx. %age Charge</th>
                                    <th>Trx Fee/£</th>
                                    <th>Income/£</th>
                                </tr>
                                </thead>
                                <tr>
                                    <td>£20</td>
                                    <td>Cash</td>
                                    <td id="cash">0</td>
                                    <td class="cashtimes20">0</td>
                                    <td>0</td>
                                    <td>-</td>
                                    <td class="cashtimes20">0</td>
                                </tr>
                                <tr>
                                    <td>£20</td>
                                    <td>Card</td>
                                    <td id="card">0</td>
                                    <td id="cardtimes20">0</td>
                                    <td>2.75%</td>
                                    <td class="trxFee">0</td>
                                    <td id="totalCardIncome">0</td>
                                </tr>

                                <tr>
                                    <td>£20</td>
                                    <td>Not Paid</td>
                                    <td id="notPaid">0</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td><div class="pull-right"><b>Subtotal</b></div></td>
                                    <td id="subtotalCarCount">0</td>
                                </tr>

                                <tr>
                                    <td>VIP-FREE</td>
                                    <td>N/A</td>
                                    <td id="vip">0</td>
                                </tr>

                                <tfoot style="font-weight: bold">
                                <td></td>
                                <td><div class="pull-right"><b>TOTAL</b></div></td>
                                <td id="carCount">0</td>
                                <td id="totalRevenue">0</td>
                                <td>0</td>
                                <td class="trxFee">0</td>
                                <td id="grandTotal">0</td>
                                </tfoot>
                            </table>
                        </div>
                        <div class="text-center" id="page-selection" style="color: white"></div>
                        <div class="text-center" style="color: white">
                            <h4>Please choose a tax month</h4>
                        </div>
                        <script>

                            // init bootpag
                            $('#page-selection').bootpag({
                                total: 13,
                                page: 1,
                                maxVisible: 13
                            }).on("page", function(event, /* page number here */ num){
                                var d = new Date("3/7/2016");
                                d.setDate(d.getDate() + 28 * num);
                                console.log(num);
                                var curr_date = d.getDate();
                                var curr_month = d.getMonth() + 1; //Months are zero based
                                var curr_year = d.getFullYear();

                                $.post("/reports/weekly-report",
                                        {
                                            period: 'monthly',
                                            day: curr_date,
                                            month: curr_month,
                                            year: curr_year
                                        },
                                        function(result, status){
                                            $('#card').html(result.card);
                                            $('#cardtimes20').html(result.card*20);
                                            $('#cardcharges').html(result.card*20*0.925);
                                            $('#cash').html(result.cash);
                                            $('.cashtimes20').html(result.cash*20);
                                            $('#cashcharges').html(result.cash*20);
                                            $('#notPaid').html(result.not_paid);
                                            $('#vip').html(result.vip);
                                            $('#carCount').html(result.car_count);
                                            $('#totalCarCount').html(result.card  + result.cash +  result.not_paid + result.vip);
                                            $('#totalCardIncome').html((result.card * 20 * 0.925));
                                            $('#grandTotal').html((result.card * 20 * 0.925) + (result.cash * 20));
                                            $('#totalRevenue').html((result.card * 20) + (result.cash * 20));
                                            $('#subtotalCarCount').html(result.card  + result.cash +  result.not_paid);
                                            $('.trxFee').html(result.card * 20 * 2.75 / 100);
                                            $('#weekSrt').html(result.weekSrt);
                                            $('#weekE').html(result.weekE);
                                            console.log("car_count: " + result.car_count + "\nvip: " + result.vip);
                                        });

                                console.log(curr_year + "/" + curr_month + "/" + curr_date);
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection