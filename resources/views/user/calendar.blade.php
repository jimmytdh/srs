<?php
$user =  \Illuminate\Support\Facades\Session::get('user');
?>
@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ url('/back') }}/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ url('/back') }}/plugins/iCheck/all.css">

    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            @if(!isset($edit))
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Event</h3>
                        </div>
                        <div class="box-body">
                            <form method="post" action="{{ url('user/calendar/save') }}">
                                {{ csrf_field() }}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="title">Event Title</label>
                                        <input type="text" required autocomplete="off" autofocus name="title" id="title" class="form-control" placeholder="Enter Event Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea id="description" required name="description" class="form-control" rows="5" style="resize: none;" placeholder="Enter Description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="daterange">Date and Time Range</label>
                                        <input type="text" required autocomplete="off" name="daterange" id="daterange" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="daterange">Repeat Every</label>
                                        <br />
                                        <label>
                                            <input type="radio" name="repeat_every" value="none" class="minimal" checked> Single Event
                                        </label>
                                        <br />
                                        <label>
                                            <input type="radio" name="repeat_every" value="monthly" class="minimal"> Month
                                        </label>
                                        <br />
                                        <label>
                                            <input type="radio" name="repeat_every" value="annual" class="minimal"> Year
                                        </label>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="pull-right btn btn-primary">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-4">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Update Event</h3>
                        </div>
                        <div class="box-body">
                            <form method="post" action="{{ url('user/calendar/update/'.$info->id) }}">
                                {{ csrf_field() }}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="title">Event Title</label>
                                        <input type="text" required autocomplete="off" value="{{ $info->title }}" autofocus name="title" id="title" class="form-control" placeholder="Enter Event Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea id="description" required name="description" class="form-control" rows="5" style="resize: none;" placeholder="Enter Description">{!! nl2br($info->description) !!}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="daterange">Date and Time Range</label>
                                        <input type="text" required autocomplete="off" name="daterange" id="daterange" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="daterange">Repeat Every</label>
                                        <br />
                                        <label>
                                            <input type="radio" name="repeat_every" value="none" class="minimal" {{ ($info->repeat_every=='none') ? 'checked':'' }}> Single Event
                                        </label>
                                        <br />
                                        <label>
                                            <input type="radio" name="repeat_every" value="monthly" class="minimal" {{ ($info->repeat_every=='monthly') ? 'checked':'' }}> Month
                                        </label>
                                        <br />
                                        <label>
                                            <input type="radio" name="repeat_every" value="annual" class="minimal" {{ ($info->repeat_every=='annual') ? 'checked':'' }}> Year
                                        </label>
                                    </div>
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <a href="{{ url('user/calendar') }}" class="pull-left btn btn-default">
                                        <i class="fa fa-arrow-left"></i> Cancel
                                    </a>
                                    <a href="#delete" data-id="{{ $info->id }}" class="pull-right btn btn-danger" style="margin-left:5px;">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                    <button type="submit" class="pull-right btn btn-primary">
                                        <i class="fa fa-save"></i> Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-8">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">My Calendar</h3>
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
    <div class="modal fade" id="delete">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this event?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                    <a id="delete_link" class="btn btn-primary"><i class="fa fa-check"></i> Yes</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('js')
    <script src="{{ url('/back') }}/bower_components/moment/min/moment.min.js"></script>
    <script src="{{ url('/back') }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ url('/back') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="{{ url('/back') }}/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{ url('/back') }}/plugins/iCheck/icheck.min.js"></script>
    <script src="{{ url('/back') }}/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script>
        $('a[href="#delete"]').on('click',function(){
            var id = $(this).data('id');
            $('#delete').modal('show');
            $('#delete_link').attr('href',"{{ url('user/calendar/delete/') }}/"+id);
        });

        var start_date = "{{ date('m/d/Y H:i:s') }}";
        var end_date = "{{ date('m/d/Y H:i:s') }}";
        @if(isset($edit))
              var start_date = "{{ date('m/d/Y H:i:s',strtotime($info->start_date)) }}";
              var end_date = "{{ date('m/d/Y H:i:s',strtotime($info->end_date)) }}";
        @endif
        console.log(start_date);
        console.log(moment().startOf('hour'));
        //Date range picker with time picker
        $('#daterange').daterangepicker({
            timePicker: true,
            timePickerIncrement: 5,
            startDate: start_date,
            endDate: end_date,
            locale: {
                format: 'M/DD/YYYY hh:mm A'
            }
        });

        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        });

        $.ajax({
            url: "{{ url('/user/events/personal') }}",
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
    </script>
@endsection