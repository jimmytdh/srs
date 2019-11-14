@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ url('/back/plugins/iCheck/flat/blue.css') }}">
    <link rel="stylesheet" href="{{ url('/back/plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reservation</h3>

                        <br>
                        <div class="text-danger text-bold">
                            Selected Date: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <form action="{{ url('reservation/search') }}" method="post" class=" form-inline">
                            {{ csrf_field() }}
                            <div class="mailbox-controls">
                                <!-- Check all button -->
                                <div class="btn-group">
                                    <button type="button" data-toggle="modal" data-target="#reserveItem" id="btnReserve" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Reserve</button>
                                </div>
                                <!-- /.btn-group -->

                                <div class="input-group input-group-sm">
                                    <input type="date" name="date" value="{{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}" class="form-control">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-calendar"></i> Change Date</button>
                                    </span>
                                </div>

                                <!-- /.pull-right -->
                            </div>
                        </form>
                        <div class="table-responsive mailbox-messages" style="margin:5px 0px; border-top:1px solid #d6d6d6;border-bottom:1px solid #d6d6d6;">
                            <table class="table table-hover table-striped table-bordered">
                                @if(count($reserved)>0)
                                <thead>
                                    <tr class="bg-red">
                                        <td colspan="10">RESERVED ITEMS</td>
                                    </tr>
                                    <tr class="bg-gray-active">
                                        <th>Ref # / Borrower</th>
                                        <th>Description</th>
                                        <th>Items</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reserved as $row)
                                    <tr>
                                        <td>
                                            @if($row->status=='Reserved')
                                            <a href="#editItem" data-toggle="modal" data-code="{{ $row->code }}" class="text-bold"><i class="fa fa-edit"></i> </a>
                                            <a href="#getItem" data-toggle="modal" data-code="{{ $row->code }}" class="text-bold">{{ $row->code }}</a>
                                            @else
                                            <a href="#" data-toggle="modal" class="text-bold">{{ $row->code }}</a>
                                            @endif
                                            <br>
                                            <small class="text-muted">({{ $row->user }})</small>
                                        </td>
                                        <td>
                                            <font class="text-bold">{{ $row->title }}</font>
                                            <br>
                                            <small class="text-danger">
                                                {!! $row->description !!}
                                            </small>
                                        </td>
                                        <td>{{ \App\Http\Controllers\ReservationController::getItems($row->code)->pluck('name')->implode(', ') }}</td>
                                        <td>
                                            <span class="badge bg-green">{{ \Carbon\Carbon::parse($row->time_start)->format('h:i A') }}</span>
                                            <br>
                                            <span class="badge bg-red">{{ \Carbon\Carbon::parse($row->time_end)->format('h:i A') }}</span>
                                        </td>
                                        <td>
                                            @if($row->status=='Reserved')
                                                <span class="badge bg-red">Reserved</span>
                                            @elseif($row->status=='Borrowed')
                                                <span class="badge bg-warning">{{ $row->status }}</span>
                                            @else
                                                <span class="badge bg-green">Done</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @else
                                    <tr>
                                        <td class="text-center text-danger text-bold" colspan="10"><br>No Reserved Items on Selected Date<br><br></td>
                                    </tr>
                                @endif
                            </table>

                            <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Reservation Calendar</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div id="calendar"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="clearfix"></div>
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('modal')
    @include('modal.reserveItem')
    <div class="modal fade" tabindex="-1" role="dialog" id="delete" style="z-index:999991;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 5px 20px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4><i class="fa fa-times-circle"></i> Delete Item</h4>
                </div>
                <form method="post" action="{{ url('/reservation/delete') }}">
                    {{ csrf_field() }}
                    <div class="modal-body text-center">
                        <div class="form-group">
                            <input type="hidden" class="form-control" value="" name="ids" id="inputDelete"  />
                        </div>
                        <div class="deleteMsg text-bold text-danger">
                            Are you sure you want to delete selected items?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-danger btnDeleteSubmit">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@endsection

@section('js')
    <script src="{{ url('/back') }}/bower_components/moment/min/moment.min.js"></script>
    <script src="{{ url('/back/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ url('/back') }}/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script>
        $(function () {
            loadAvailable();
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass   : 'iradio_minimal-blue'
            });
            //Enable iCheck plugin for checkboxes
            //iCheck for checkbox and radio inputs
            $('.mailbox-messages input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });

            $("#btnDelete").click(function () {
                var ids = $(".item_id:checked").map(function(){
                    return $(this).val();
                }).toArray();
                var msg = "Are you sure you want to delete selected item(s)?";
                var msg2 = "Please select items to delete.";
                if(ids.length==0){
                    $('.btnDeleteSubmit').addClass('hidden');
                    $('.deleteMsg').html(msg2);
                }else{
                    $('.btnDeleteSubmit').removeClass('hidden');
                    $('.deleteMsg').html(msg);
                }
                $("#inputDelete").val(ids);
            });

            $("a[href='#editItem']").click(function () {
                var code = $(this).data('code');
                var cancelUrl = "{{ url('reservation/cancel') }}/"+code;
                var borrowUrl = "{{ url('reservation/borrow') }}/"+code;
                var url = "{{ url('reservation/edit') }}/"+code;

                $('a[href="#cancel"]').attr('href',cancelUrl);
                $('a[href="#borrow"]').attr('href',borrowUrl);

                $('.reservationSection').load("{{ url('/loading') }}");
                setTimeout(function () {
                    $('.reservationSection').load(url);
                },1300);

            });

            $("a[href='#getItem']").click(function () {
                var code = $(this).data('code');
                var cancelUrl = "{{ url('reservation/cancel') }}/"+code;
                var borrowUrl = "{{ url('reservation/borrow') }}/"+code;

                $('a[href="#cancel"]').attr('href',cancelUrl);
                $('a[href="#borrow"]').attr('href',borrowUrl);

            });

            $('input[name="time_start"],input[name="time_end"]').change(function () {
                loadAvailable();
            });

            $.ajax({
                url: "{{ url('/reservation/calendar') }}",
                type: "GET",
                success: function(data){
                    console.log(data);
                    $('#calendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },
                        editable: false,
                        eventSources: [data],
                        eventMouseover: function(calEvent, jsEvent) {
                            if(calEvent.title){
                                var tooltip = '<div class="tooltipevent" style="max-width:200px;color:#fff;padding:5px;background:#000;position:absolute;z-index:10001;">' + calEvent.description + '</div>';
                                $("body").append(tooltip);
                                $(this).mouseover(function(e) {
                                    $(this).css('z-index', 10000);
                                    $('.tooltipevent').fadeIn('500');
                                    $('.tooltipevent').fadeTo('10', 1.9);
                                }).mousemove(function(e) {
                                    $('.tooltipevent').css('top', e.pageY + 10);
                                    $('.tooltipevent').css('left', e.pageX + 20);
                                });
                            }
                        },

                        eventMouseout: function(calEvent, jsEvent) {
                            $(this).css('z-index', 8);
                            $('.tooltipevent').remove();
                        },
                        validRange: {
                            start: "{{ date('Y') }}-01-01",
                            end: "{{ date('Y') }}-12-31"
                        }
                    });
                }
            });

        });

        function loadAvailable() {
            $('.availableItem').load("{{ url('loading') }}");
            var date = $('input[name="date_end"]').val();
            var time_start = $('input[name="time_start"]').val();
            var time_end = $('input[name="time_end"]').val();
            var url = "{{ url('reservation/available/') }}/"+date+"/"+time_start+"/"+time_end+"/";
            setTimeout(function () {
                $('.availableItem').load(url);
            },500);
            console.log(url);
        }
    </script>
@endsection