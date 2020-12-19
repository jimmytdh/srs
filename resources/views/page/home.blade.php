<?php
    $user =  \Illuminate\Support\Facades\Session::get('user');
?>
@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/morris.js/morris.css">
    <style>
        .tooltip {
            z-index: 9999 !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-home"></i> Dashboard
                    </h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>{{ number_format($countReserved) }}</h3>

                                    <p>Reserved Today</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <a href="{{ url('/reservation') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>{{ number_format(\App\Http\Controllers\JobController::countPendingJob()) }}</h3>

                                    <p>Job Request</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-calendar-plus-o"></i>
                                </div>
                                <a href="{{ url('/job') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>{{ number_format(\App\Http\Controllers\TaskController::countPendingTask()) }}</h3>

                                    <p>Task</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-file-text-o"></i>
                                </div>
                                <a href="{{ url('/tasks') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>{{ number_format($countSystemRequest) }}</h3>

                                    <p>System Request</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-chrome"></i>
                                </div>
                                <a href="{{ url('/request/system') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Last 7 Days Activity</h3>
                        </div>
                        <div class="box-body chart-responsive">
                            <div class="chart" id="line-chart" style="height: 300px;"></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Current Job Request</h3>
                        </div>
                        <div class="box-body">
                            <?php
                                $jobs = \App\Http\Controllers\JobController::getPendingJob();
                            ?>
                            @if(count($jobs)==0)
                            <div class="alert text-success text-center">
                                No pending job! :)
                            </div>
                            @else
                            <ul class="products-list product-list-in-box">
                                @foreach($jobs as $job)
                                <li class="item">
                                    <div class="">
                                        <a href="javascript:void(0)" class="product-title">
                                            {{ $job->request_by }} ({{ $job->request_office }})
                                        </a>
                                        <span class="product-description">
                                            {{ $job->others }}
                                        </span>
                                        <small class="text-danger">
                                            {{ date('m/d/y h:i a',strtotime($job->request_date)) }}
                                        </small>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
<script src="{{ url('/back') }}/bower_components/moment/moment.js"></script>
<script src="{{ url('/back') }}/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="{{ url('/back') }}/bower_components/raphael/raphael.min.js"></script>
<script src="{{ url('/back') }}/bower_components/morris.js/morris.min.js"></script>
<script>
    $.ajax({
        url: "{{ url('/home/chart') }}",
        type: "GET",
        success: function(data){
            var line = new Morris.Line({
                element: 'line-chart',
                resize: true,
                data: data,
                xkey: 'day',
                ykeys: ['job','task'],
                labels: ['Job','Task'],
                lineColors: ['#39bc47','#3c8dbc'],
                hideHover: 'auto',
                parseTime:false,
            });
        }
    });
    $(function () {
        "use strict";

        // LINE CHART

    });
</script>


@endsection