@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ url('/back/plugins/iCheck/flat/blue.css') }}">
    <link rel="stylesheet" href="{{ url('/back/plugins/iCheck/all.css') }}">
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
                        <h3 class="box-title">List of Job Request <small class="text-danger">(Result: {{ $data->total() }})</small></h3>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <form action="{{ url('job/search') }}" class="form-inline" method="post">
                            {{ csrf_field() }}
                            <div class="mailbox-controls">
                                <div class="form-group">
                                    <button type="button" data-toggle="modal" data-target="#addItem" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Job</button>
                                </div>
                                <div class="form-group">
                                    <div class="has-feedback">
                                        <input type="text" name="keyword" class="form-control input-sm" value="{{ Session::get('searchJob') }}" placeholder="Search Keyword...">
                                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                    </div>
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
                                        <td class="text-bold">
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
    <script>
        $(function () {
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