<?php
$user =  \Illuminate\Support\Facades\Session::get('user');
?>
@extends('app')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            @if(!isset($edit))
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Section</h3>
                        </div>
                        <div class="box-body">
                            <form method="post" action="{{ url('admin/section/save') }}">
                                {{ csrf_field() }}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="code">Initial</label>
                                        <input type="text" required autocomplete="off" maxlength="3" name="initial" id="initial" class="form-control" placeholder="Enter Initial">
                                    </div>
                                    <div class="form-group">
                                        <label for="code">Code</label>
                                        <input type="text" required autocomplete="off" name="code" id="code" class="form-control" placeholder="Enter Code">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" required autocomplete="off" name="description" id="description" class="form-control" placeholder="Enter Description">
                                    </div>
                                    <div class="form-group">
                                        <label for="division">Division</label>
                                        <select name="division" class="form-control" id="division" required>
                                            <option value="">Select Division...</option>
                                            @foreach($divisions as $d)
                                                <option value="{{ $d->id }}">{{ $d->description }}</option>
                                            @endforeach
                                        </select>
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
                            <h3 class="box-title">Update Division</h3>
                        </div>
                        <div class="box-body">
                            <form method="post" action="{{ url('admin/section/update/'.$info->id) }}">
                                {{ csrf_field() }}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="code">Initial</label>
                                        <input type="text" required autocomplete="off" maxlength="3" name="initial" value="{{ $info->initial }}" id="initial" class="form-control" placeholder="Enter Initial">
                                    </div>
                                    <div class="form-group">
                                        <label for="code">Code</label>
                                        <input type="text" required autocomplete="off" name="code" value="{{ $info->code }}" id="code" class="form-control" placeholder="Enter Code">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" required autocomplete="off" name="description" value="{{ $info->description }}" id="description" class="form-control" placeholder="Enter Description">
                                    </div>
                                    <div class="form-group">
                                        <label for="division">Division</label>
                                        <select name="division" class="form-control" id="division" required>
                                            <option value="">Select Division...</option>
                                            @foreach($divisions as $d)
                                                <option {{ ($info->division_id==$d->id) ? 'selected':'' }} value="{{ $d->id }}">{{ $d->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <a href="{{ url('admin/section') }}" class="pull-left btn btn-default">
                                        <i class="fa fa-arrow-left"></i> Cancel
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
                        <h3 class="box-title">Sections</h3><br />
                        <?php $keyword = \Illuminate\Support\Facades\Session::get('search_section'); ?>
                        @if($keyword)
                            <small class="text-danger">Keyword: {{ $keyword }}</small>
                        @endif
                        <div class="box-tools">
                            <form method="post" action="{{ url('admin/section/search') }}">
                                {{ csrf_field() }}
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="keyword" value="{{ $keyword }}" class="form-control pull-right" placeholder="Search">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body table-responsive">
                        @if(count($data)>0)
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Initial</th>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Division</th>
                                    <th class="text-center"># of Users</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $row)
                                    <tr>
                                        <td>
                                            <a href="{{ url('admin/section/edit/'.$row->id) }}" class="editable">
                                                {{ str_pad($row->id,'4','0',STR_PAD_LEFT) }}
                                            </a>
                                        </td>
                                        <td class="text-success">{{ $row->initial }}</td>
                                        <td class="text-success">{{ $row->code }}</td>
                                        <td class="text-warning">{{ $row->description }}</td>
                                        <td class="text-warning">{{ $row->division }}</td>
                                        <td class="text-success text-center">
                                            {{ $row->num }}
                                            <a class="pull-right text-danger" href="#delete" data-id="{{ $row->id }}">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        @endif
                    </div>
                    <div class="box-footer">
                        @if(count($data)>0)
                            {{ $data->links() }}
                        @else
                            <div class="callout callout-warning">
                                <p>Opps. No section found!</p>
                            </div>
                        @endif
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
                    <p>Are you sure you want to delete this section?</p>
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
    <script>
        $('a[href="#delete"]').on('click',function(){
            var id = $(this).data('id');
            $('#delete').modal('show');
            $('#delete_link').attr('href',"{{ url('admin/section/delete/') }}/"+id);
        });
    </script>
@endsection