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
                            <h3 class="box-title">Add User</h3>
                        </div>
                        <div class="box-body">
                            <form method="post" action="{{ url('admin/users/save') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="fname">First Name</label>
                                        <input type="text" required autocomplete="off" name="fname" class="form-control" id="fname" placeholder="Enter First Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="lname">Last Name</label>
                                        <input type="text" required autocomplete="off" name="lname" class="form-control" id="lname" placeholder="Enter Last Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="sex">Sex</label>
                                        <select id="sex" name="sex" class="form-control" required>
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" required autocomplete="off" name="dob" class="form-control" id="dob" placeholder="mm/dd/YYYY">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact">Contact</label>
                                        <input type="text" required autocomplete="off" name="contact" class="form-control" id="contact" placeholder="Enter Contact #">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" autocomplete="off" name="email" class="form-control" id="email" placeholder="Enter Email Address">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea name="address" required id="address" class="form-control" style="resize: none;" rows="3" placeholder="Complete Address"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="section">Section/Unit</label>
                                        <select id="section" name="section" class="form-control" required>
                                            <option value="">Select Section/Unit...</option>
                                            @foreach($section as $s)
                                                <option value="{{ $s->id }}">{{ $s->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="designation">Designation</label>
                                        <select id="designation" name="designation" class="form-control" required>
                                            <option value="">Select Designation...</option>
                                            @foreach($designation as $d)
                                                <option value="{{ $d->id }}">{{ $d->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" required autocomplete="off" name="username" class="form-control" id="username" placeholder="Enter Username">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" minlength="6" required autocomplete="off" name="password" class="form-control" id="password" placeholder="Enter Password">
                                    </div>
                                    {{--<div class="form-group hide">--}}
                                        {{--<div class="picture">--}}
                                            {{--<input type='file' required class="form-control" placeholder="Profile Picture" name="picture" onchange="readProfURL(this);" />--}}
                                            {{--<img id="prof_pic" src="{{ asset('back/img/default.jpg') }}" width="100%" height="" />--}}

                                        {{--</div>--}}
                                    {{--</div>--}}
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
                            <h3 class="box-title">Update User</h3>
                        </div>
                        <div class="box-body">
                            <form role="form" method="post" action="{{ url('admin/users/update/'.$info->id) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="fname">First Name</label>
                                        <input type="text" required autocomplete="off" name="fname" class="form-control" id="fname" value="{{ $info->fname }}" placeholder="Enter First Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="lname">Last Name</label>
                                        <input type="text" required autocomplete="off" name="lname" class="form-control" id="lname" value="{{ $info->lname }}" placeholder="Enter Last Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="sex">Sex</label>
                                        <select id="sex" name="sex" class="form-control" required>
                                            <option @if($info->sex=='Male') selected @endif>Male</option>
                                            <option @if($info->sex=='Female') selected @endif>Female</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" required autocomplete="off" name="dob" class="form-control" id="dob" value="{{ $info->dob }}" placeholder="mm/dd/YYYY">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact">Contact</label>
                                        <input type="text" required autocomplete="off" name="contact" class="form-control" id="contact" value="{{ $info->contact }}" placeholder="Enter Contact #">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" autocomplete="off" name="email" class="form-control" id="email" value="{{ $info->email }}" placeholder="Enter Email Address">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" class="form-control" style="resize: none;" rows="3" placeholder="Complete Address">{{ $info->address }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="section">Section/Unit</label>
                                        <select id="section" name="section" class="form-control" required>
                                            <option value="">Select Section/Unit...</option>
                                            @foreach($section as $s)
                                                <option {{ ($info->section==$s->id) ? 'selected': '' }} value="{{ $s->id }}">{{ $s->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="designation">Designation</label>
                                        <select id="designation" name="designation" class="form-control" required>
                                            <option value="">Select Designation...</option>
                                            @foreach($designation as $d)
                                                <option {{ ($info->designation==$d->id) ? 'selected': '' }} value="{{ $d->id }}">{{ $d->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" required autocomplete="off" name="username" class="form-control" id="username" value="{{ $info->username }}" placeholder="Enter Username">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" minlength="6" autocomplete="off" name="password" class="form-control" id="password" placeholder="Unchange">
                                    </div>
                                    {{--<div class="form-group">--}}
                                        {{--<div class="picture">--}}
                                            {{--<input type='file' class="form-control" placeholder="Profile Picture" name="picture" onchange="readProfURL(this);" />--}}
                                            {{--<img id="prof_pic" src="{{ asset('upload/'.$info->picture) }}" width="100%" height="" />--}}

                                        {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <a href="{{ url('admin/users') }}" class="pull-left btn btn-default">
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
                        <h3 class="box-title">List of Users</h3>

                        <div class="box-tools">
                            <form method="post" action="{{ url('admin/users/search') }}">
                                {{ csrf_field() }}
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="keyword" value="{{ \Illuminate\Support\Facades\Session::get('search_users') }}" class="form-control pull-right" placeholder="Search">

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
                                    <th>Name</th>
                                    <th>Sex</th>
                                    <th>Age</th>
                                    <th>Contact</th>
                                    <th>Level</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $row)
                                    <tr>
                                        <td title="Email: {{ $row->email }}&#xA;Date of Birth: {{ date('F d, Y',strtotime($row->dob)) }}&#xA;Username: {{ $row->username }}&#xA;Address: {{ $row->address }}&#xA;Section: {{ $row->section_name }}&#xA;Designation: {{ $row->designation_name }}">
                                            <a href="{{ url('admin/users/edit/'.$row->id) }}" class="editable">
                                                {{ str_pad($row->id,'4','0',STR_PAD_LEFT) }}
                                            </a>
                                        </td>
                                        <td class="text-success">
                                            {{ $row->lname }}, {{ $row->fname }}
                                        </td>
                                        <td>{{ $row->sex }}</td>
                                        <td>{{ \App\Http\Controllers\ParamController::getAge($row->dob) }} y/o</td>
                                        <td>{{ $row->contact }}</td>
                                        <td>Standard
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
                                <p>Opps. No user found!</p>
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
                    <p>Are you sure you want to delete this reviewee?</p>
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
            $('#delete_link').attr('href',"{{ url('admin/users/delete/') }}/"+id);
        });

        function readProfURL(input)
        {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#prof_pic').attr('src', e.target.result);
                    $('#prof_pic').addClass('img-responsive');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection