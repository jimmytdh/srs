<?php
    $search = \Illuminate\Support\Facades\Session::get('searchJob');
    if(!$search){
        $start = \Carbon\Carbon::today()->startOfMonth()->format('Y-m-d');
        $end = \Carbon\Carbon::today()->endOfMonth()->format('Y-m-d');
        $search = array(
            'keyword' => '',
            'date_range' => "$start-$end",
            'service_by' => '',
            'service_id' => ''
        );
    }
?>
@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ url('/back/plugins/iCheck/flat/blue.css') }}">
    <link rel="stylesheet" href="{{ url('/back/plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="{{ url("/back/bower_components/bootstrap-daterangepicker/daterangepicker.css") }}">
    <style>
        th {
            vertical-align: middle !important;
        }
        #signatureparent {
            color:#000;
            background-color:darkgrey;
            /*max-width:600px;*/
            padding:20px;
        }

        /*This is the div within which the signature canvas is fitted*/
        #signature {
            border: 2px dotted black;
            background-color:lightgrey;
        }

        /* Drawing the 'gripper' for touch-enabled devices */
        html.touch #content {
            float:left;
            width:92%;
        }
        html.touch #scrollgrabber {
            float:right;
            width:4%;
            margin-right:2%;
            background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAFCAAAAACh79lDAAAAAXNSR0IArs4c6QAAABJJREFUCB1jmMmQxjCT4T/DfwAPLgOXlrt3IwAAAABJRU5ErkJggg==)
        }
        html.borderradius #scrollgrabber {
            border-radius: 1em;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List of Job Request <small class="text-danger">(Result: {{ $data->total() }})</small></h3>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <form action="{{ url('job/search') }}" class="form-inline" method="post">
                            {{ csrf_field() }}
                            <div class="mailbox-controls">
                                <div class="form-group">
                                    <input type="text" name="keyword" class="form-control input-sm" value="{{ $search['keyword'] }}" placeholder="Search Keyword...">
                                </div>
                                <div class="form-group">
                                    <select name="service_by" class="form-control input-sm">
                                        <option value="">Serviced by...</option>
                                        <option @if($search['service_by']=='Wairley Von Cabiluna') selected @endif>Wairley Von Cabiluna</option>
                                        <option @if($search['service_by']=='Ian Aaron Manugas') selected @endif>Ian Aaron Manugas</option>
                                        <option @if($search['service_by']=='Jimmy Lomocso') selected @endif>Jimmy Lomocso</option>
                                        <option @if($search['service_by']=='Ariel Nocos') selected @endif>Ariel Nocos</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="service_id" class="form-control input-sm" id="">
                                        <option value="">View All...</option>
                                        @foreach($services as $r)
                                            <option value="{{ $r->id }}" @if($r->id==$search['service_id']) selected @endif>{{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" value="{{ $search['date_range'] }}" name="date_range" class="form-control input-sm pull-right" id="reservation">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success btn-sm" type="submit">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>
                                </div>
                                <div class="form-group">
                                    <button type="button" data-toggle="modal" data-target="#addItem" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add Job</button>
                                </div>
                                <div class="form-group">
                                    <a href="{{ url('/job/print') }}" class="btn btn-sm btn-default" target="_blank">
                                        <i class="fa fa-print"></i> Print Report
                                    </a>
                                </div>
                                <div class="form-group">
                                    <button type="button" data-toggle="modal" data-target="#signatureModal" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Add Job</button>
                                </div>
                                <!-- /.pull-right -->
                            </div>
                        </form>
                        <div class="table-responsive mailbox-messages" style="margin:5px 0px; border-top:1px solid #d6d6d6;border-bottom:1px solid #d6d6d6;">
                            <table class="table table-hover table-striped table-bordered">
                                <thead class="bg-green-gradient">
                                    <tr>
                                        <th>Form No.</th>
                                        <th>Requestd By</th>
                                        <th>Services</th>
                                        <th>Findings/<br>Recommendations</th>
                                        <th>Serviced By</th>
                                        <th>Date Acted/<br>Completed</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $row)
                                    <?php $info = \App\Http\Controllers\ItemController::borrowInfo($row->id);?>
                                    <tr>
                                        <td class="text-bold" style="white-space: nowrap;">
                                            <a href="#update" data-toggle="modal" data-id="{{ $row->id }}">
                                                @if($row->status=='Completed')
                                                    <i class="fa fa-circle text-success"></i>
                                                @else
                                                    <i class="fa fa-circle-o text-danger"></i>
                                                @endif
                                                &nbsp;{{ $row->form_no }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $row->request_by }}
                                            <br>
                                            <small class="text-success">{{ $row->request_office }}</small>
                                            <br>
                                            <small class="text-danger">{{ \Carbon\Carbon::parse($row->request_date)->format('Y M d') }}</small>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($row->request_date)->format('h:i A') }}</small>
                                        </td>
                                        <td>
                                            <?php $service = \App\JobService::leftJoin('services','services.id','=','job_services.service_id')->where('job_id',$row->id)->get(); ?>
                                            @if($service)
                                                <ul>
                                                @foreach($service as $s)
                                                    <li>{{ $s->name }}</li>
                                                @endforeach

                                                @if($row->others)
                                                    <li class="text-green">Ohers: {{ $row->others }}</li>
                                                @endif
                                                </ul>
                                            @endif
                                        </td>
                                        <td>
                                            @if($row->findings || $row->remarks)
                                                <font class="text-info">
                                                    Findings: {{ $row->findings }}
                                                </font>
                                                <br>
                                                <font class="text-danger">
                                                    Recommendations: {{ $row->remarks }}
                                                </font>
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td>
                                            {{ ($row->service_by) ? $row->service_by: '--' }}
                                        </td>
                                        <td>
                                            @if($row->acted_date || $row->completed_date)
                                                <font class="text-info">
                                                    Acted: {{ \Carbon\Carbon::parse($row->acted_date)->format('M d h:i A') }}
                                                </font>
                                                <br>
                                                <font class="text-danger">
                                                    Completed: {{ \Carbon\Carbon::parse($row->completed_date)->format('M d h:i A') }}
                                                </font>
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#updateServices" data-toggle="modal" data-id="{{ $row->id }}">
                                            @if($row->status=='Completed')
                                                <span class="badge bg-green">
                                                    Completed
                                                </span>
                                            @else
                                                <span class="badge bg-red">
                                                    Pending
                                                </span>
                                            @endif
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                @if(count($data)==0)
                                    <tr>
                                        <td class="text-center text-danger text-bold" colspan="10"><br>No Job Request Found<br><br></td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer no-padding">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('modal')
    @include('modal.addJob')
    @include('modal.signature')
    <div class="modal fade" tabindex="-1" role="dialog" id="delete" style="z-index:999991;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 5px 20px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4><i class="fa fa-times-circle"></i> Delete Item</h4>
                </div>
                <form method="post" action="{{ url('/job/delete') }}">
                    {{ csrf_field() }}
                    <div class="modal-body text-center">
                        <div class="form-group">
                            <input type="hidden" class="form-control" value="" name="id" id="inputDelete"  />
                        </div>
                        <div class="deleteMsg text-bold text-danger">
                            Are you sure you want to delete this job request?
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
    <script src="{{ url('/back/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ url('/back/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ url('/back/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ url('/back/plugins/jSignature') }}/libs/modernizr.js"></script>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ url('/back/plugins/jSignature') }}/libs/flashcanvas.js"></script>
    <![endif]-->
    <script src="{{ url('/back/plugins/jSignature') }}/src/jSignature.js"></script>
    <script src="{{ url('/back/plugins/jSignature') }}/src/plugins/jSignature.CompressorBase30.js"></script>
    <script src="{{ url('/back/plugins/jSignature') }}/src/plugins/jSignature.CompressorSVG.js"></script>
    <script src="{{ url('/back/plugins/jSignature') }}/src/plugins/jSignature.UndoButton.js"></script>
    <script src="{{ url('/back/plugins/jSignature') }}/src/plugins/signhere/jSignature.SignHere.js"></script>
    <script>
        $(function () {
            $('#reservation').daterangepicker();

            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass   : 'iradio_minimal-blue'
            });


            $('a[href="#updateServices"]').click(function () {
                var id = $(this).data('id');
                var url = "{{ url('job/services/') }}/"+id;
                $('.serviceSection').load("{{ url('/loading') }}");
                setTimeout(function () {
                    $('.serviceSection').load(url);
                },1000);
            });

            $('a[href="#update"]').click(function () {
                var id = $(this).data('id');
                var url = "{{ url('job/edit/') }}/"+id;
                $('.updateSection').load("{{ url('/loading') }}");
                setTimeout(function () {
                    $('.updateSection').load(url);
                },1000);
            });
            $(document).on('click','a[href="#delete"]',function () {
                var id = $(this).data('id');
                var url = "{{ url('job/delete/') }}/"+id;
                console.log(url);
                $('#update').modal('hide');
                $('#inputDelete').val(id);
            });
        });
    </script>
    <script>
        (function($) {
            var topics = {};
            $.publish = function(topic, args) {
                if (topics[topic]) {
                    var currentTopic = topics[topic],
                        args = args || {};

                    for (var i = 0, j = currentTopic.length; i < j; i++) {
                        currentTopic[i].call($, args);
                    }
                }
            };
            $.subscribe = function(topic, callback) {
                if (!topics[topic]) {
                    topics[topic] = [];
                }
                topics[topic].push(callback);
                return {
                    "topic": topic,
                    "callback": callback
                };
            };
            $.unsubscribe = function(handle) {
                var topic = handle.topic;
                if (topics[topic]) {
                    var currentTopic = topics[topic];

                    for (var i = 0, j = currentTopic.length; i < j; i++) {
                        if (currentTopic[i] === handle.callback) {
                            currentTopic.splice(i, 1);
                        }
                    }
                }
            };
        })(jQuery);
    </script>
    <script>
        $(document).ready(function() {

            // This is the part where jSignature is initialized.
            var $sigdiv = $("#signature").jSignature({'UndoButton':true})

                // All the code below is just code driving the demo.
                , $tools = $('#tools')
                , $extraarea = $('#displayarea')
                , pubsubprefix = 'jSignature.demo.'

            var export_plugins = $sigdiv.jSignature('listPlugins','export')
                , chops = ['<span><b>Extract signature data as: </b></span><select>','<option value="">(select export format)</option>']
                , name
            for(var i in export_plugins){
                if (export_plugins.hasOwnProperty(i)){
                    name = export_plugins[i]
                    chops.push('<option value="' + name + '">' + name + '</option>')
                }
            }
            chops.push('</select><span><b> or: </b></span>')

            $(chops.join('')).bind('change', function(e){
                if (e.target.value !== ''){
                    var data = $sigdiv.jSignature('getData', e.target.value)
                    $.publish(pubsubprefix + 'formatchanged')
                    if (typeof data === 'string'){
                        $('textarea', $tools).val(data)
                    } else if($.isArray(data) && data.length === 2){
                        $('textarea', $tools).val(data.join(','))
                        $.publish(pubsubprefix + data[0], data);
                    } else {
                        try {
                            $('textarea', $tools).val(JSON.stringify(data))
                        } catch (ex) {
                            $('textarea', $tools).val('Not sure how to stringify this, likely binary, format.')
                        }
                    }
                }
            }).appendTo($tools)


            $('<input type="button" value="Reset">').bind('click', function(e){
                $sigdiv.jSignature('reset')
            }).appendTo($tools)

            $('<div><textarea style="width:100%;height:7em;"></textarea></div>').appendTo($tools)

            $.subscribe(pubsubprefix + 'formatchanged', function(){
                $extraarea.html('')
            })

            $.subscribe(pubsubprefix + 'image/svg+xml', function(data) {

                try{
                    var i = new Image()
                    i.src = 'data:' + data[0] + ';base64,' + btoa( data[1] )
                    $(i).appendTo($extraarea)
                } catch (ex) {

                }

                var message = [
                    "If you don't see an image immediately above, it means your browser is unable to display in-line (data-url-formatted) SVG."
                    , "This is NOT an issue with jSignature, as we can export proper SVG document regardless of browser's ability to display it."
                    , "Try this page in a modern browser to see the SVG on the page, or export data as plain SVG, save to disk as text file and view in any SVG-capabale viewer."
                ]
                $( "<div>" + message.join("<br/>") + "</div>" ).appendTo( $extraarea )
            });

            $.subscribe(pubsubprefix + 'image/svg+xml;base64', function(data) {
                var i = new Image()
                i.src = 'data:' + data[0] + ',' + data[1]
                $(i).appendTo($extraarea)

                var message = [
                    "If you don't see an image immediately above, it means your browser is unable to display in-line (data-url-formatted) SVG."
                    , "This is NOT an issue with jSignature, as we can export proper SVG document regardless of browser's ability to display it."
                    , "Try this page in a modern browser to see the SVG on the page, or export data as plain SVG, save to disk as text file and view in any SVG-capabale viewer."
                ]
                $( "<div>" + message.join("<br/>") + "</div>" ).appendTo( $extraarea )
            });

            $.subscribe(pubsubprefix + 'image/png;base64', function(data) {
                var i = new Image()
                i.src = 'data:' + data[0] + ',' + data[1]
                $('<span><b>As you can see, one of the problems of "image" extraction (besides not working on some old Androids, elsewhere) is that it extracts A LOT OF DATA and includes all the decoration that is not part of the signature.</b></span>').appendTo($extraarea)
                $(i).appendTo($extraarea)
            });

            $.subscribe(pubsubprefix + 'image/jsignature;base30', function(data) {
                $('<span><b>This is a vector format not natively render-able by browsers. Format is a compressed "movement coordinates arrays" structure tuned for use server-side. The bonus of this format is its tiny storage footprint and ease of deriving rendering instructions in programmatic, iterative manner.</b></span>').appendTo($extraarea)
            });

            if (Modernizr.touch){
                $('#scrollgrabber').height($('#content').height())
            }

        })
    </script>
@endsection