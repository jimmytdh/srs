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
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List of Task <small class="text-danger">(Result: )</small></h3>
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
                                        <option value="">Assigned to...</option>
                                        <option @if($search['service_by']=='Wairley Von Cabiluna') selected @endif>Wairley Von Cabiluna</option>
                                        <option @if($search['service_by']=='Ian Aaron Manugas') selected @endif>Ian Aaron Manugas</option>
                                        <option @if($search['service_by']=='Jimmy Lomocso') selected @endif>Jimmy Lomocso</option>
                                        <option @if($search['service_by']=='Ariel Nocos') selected @endif>Ariel Nocos</option>
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
                                    <button type="button" data-toggle="modal" data-target="#addTask" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add Task</button>
                                </div>

                                <!-- /.pull-right -->
                            </div>
                        </form>
                        <div class="table-responsive mailbox-messages" style="margin:5px 0px; border-top:1px solid #d6d6d6;border-bottom:1px solid #d6d6d6;">
                            <table class="table table-hover table-striped table-bordered">
                                <thead class="bg-green-gradient">
                                <tr>
                                    <th>Task</th>
                                    <th>Date Created</th>
                                    <th>Due Date</th>
                                    <th>Assigned to</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $row)

                                @endforeach

                                @if(count($data)==0)
                                    <tr>
                                        <td class="text-center text-danger text-bold" colspan="10"><br>No Task Found<br><br></td>
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
    @include('modal.addTask')
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
@endsection