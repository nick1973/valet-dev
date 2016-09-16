@extends('layouts.app')

@section('content')
    <div class="container col-lg-12">

        <div class="row">
            <div class="col-md-12 col-lg-12 col-md-offset-1 col-lg-offset-0">
                <div class="panel panel-success">
                    <div class="panel-heading">Reports</div>
                    <div class="panel-body" style="background: #EEEEEE">
                        <table id="reports" class="stripe table-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">Ticket No</th>

                                <th class="text-center">valet1 Ticket No</th>
                                <th class="text-center">valet2 Ticket No</th>
                                <th class="text-center">valet3 Ticket No</th>

                                <th class="text-center">valet1 Serial No</th>
                                <th class="text-center">valet2 Serial No</th>
                                <th class="text-center">valet3 Serial No</th>

                                <th class="text-center">Name</th>
                                <th class="text-center">Reg</th>
                                <th class="text-center">Mobile</th>
                                <th class="text-center">Booked in By</th>
                                <th class="text-center">Driver</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Payment</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Created At</th>
                                <th class="text-center">Updated At</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <td width="80"></td>
                                <td width="80"></td>
                                <td width="110"></td>
                                <td width="130"></td>
                                <td width="130"></td>
                                <td width="130"></td>
                                <td width="80"></td>
                                <td width="130"></td>
                                <td width="120"></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>

    $(document).ready( function () {
        var table = $('#reports').DataTable( {

            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var select = $('<select class="form-control"><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                );
                                column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                            });
                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            },

            "ajax": "/all-tickets",
            //"paging": false,
            //dom: 'Bfrip',
            dom: '<"top"Blf>rT<"bottom"p><"clear">',
            buttons: [
                'copy', 'csv', 'excel', 'pdf'
            ],
            "columns": [
                { "data": "ticket_number" , className: "centre" },
                { "data": "valet1_ticket_id" , className: "centre" },
                { "data": "valet2_ticket_id" , className: "centre" },
                { "data": "valet3_ticket_id" , className: "centre" },

                { "data": "valet1_ticket_serial_number" , className: "centre" },
                { "data": "valet2_ticket_serial_number" , className: "centre" },
                { "data": "valet3_ticket_serial_number" , className: "centre" },

                { "data": "ticket_name" , className: "centre" },
                { "data": "ticket_registration" , className: "centandcaps" },
                { "data": "ticket_mobile" , className: "centre" },
                { "data": "booked_in_by" , className: "centre" },
                { "data": "ticket_driver" , className: "centre" },
                { "data": "ticket_price" , className: "centre" },
                { "data": "ticket_payment" , className: "centre" },
                { "data": "ticket_status" , className: "centre" },
                { "data": "created_at" , className: "centre" },
                { "data": "updated_at" , className: "centre" },
            ]
        } );
    } );
</script>

    <style>
        .centre {
            text-align: center;
        }
        .centandcaps{
            text-align: center;
            text-transform: uppercase;
        }
    </style>




@endsection