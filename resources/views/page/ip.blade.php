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
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">IP Address <small class="text-danger">(192.168.5.* )</small></h3>
                        <div class="box-tools pull-right">
                            <div class="has-feedback">
                                <input type="text" name="keyword" id="search" class="form-control input-sm" placeholder="Search IP/Owner/Area">
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                            </div>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="table-responsive mailbox-messages" style="margin:5px 0px; border-top:1px solid #d6d6d6;border-bottom:1px solid #d6d6d6;">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-gray-active">
                                    <tr>
                                        <th>IP</th>
                                        <th>Owner</th>
                                        <th>Section/Area</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i=2; $i<255; $i++)
                                    <?php $user = \App\Http\Controllers\IPController::getName('net',$i) ?>
                                    <tr class="search_item @if(session('success')=="net$i") bg-yellow @endif">
                                        <td><a href="#update_ip" data-ip="{{ $i }}" data-type="net" data-toggle="modal" class="editable">
                                                <i class="fa fa-desktop"></i> 192.168.5.{{ $i }}
                                            </a>
                                        </td>
                                        <td>{{ $user->owner }}</td>
                                        <td>{{ $user->section }}</td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">IP Address <small class="text-danger">(192.168.10.* )</small></h3>
                        <div class="box-tools pull-right">
                            <div class="has-feedback">
                                <input type="text" name="keyword" class="form-control input-sm" id="search2" placeholder="Search IP...">
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                            </div>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="table-responsive mailbox-messages" style="margin:5px 0px; border-top:1px solid #d6d6d6;border-bottom:1px solid #d6d6d6;">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-gray-active">
                                <tr>
                                    <th>IP</th>
                                    <th>Owner</th>
                                    <th>Section/Area</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i=2; $i<255; $i++)
                                    <?php $user = \App\Http\Controllers\IPController::getName('homis',$i) ?>
                                    <tr class="search_item2 @if(session('success')=="homis$i") bg-yellow @endif">
                                        <td><a href="#update_ip" data-ip="{{ $i }}" data-type="homis" data-toggle="modal" class="editable">
                                                <i class="fa fa-desktop"></i> 192.168.10.{{ $i }}
                                            </a>
                                        </td>
                                        <td>{{ $user->owner }}</td>
                                        <td>{{ $user->section }}</td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="update_ip" style="z-index:999991;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 5px 20px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4><i class="fa fa-desktop"></i> <font id="title_ip"></font></h4>
                </div>
                <form method="post" id="formIP">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="owner">Owner</label>
                            <input type="text" id="owner" name="owner" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="section">Section</label>
                            <input type="text" id="section" name="section" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fa fa-check"></i> Update
                        </button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('js')
    <script>
        $("a[href='#update_ip']").on('click',function () {
            var ip = $(this).data('ip');
            var type = $(this).data('type');
            var url = "{{ url('/') }}/ip/update/"+type+"/"+ip;
            $("#formIP").attr('action',url);
        });

        $('#search').on('keyup', function () {
            searchFunction();
        });

        $('#search2').on('keyup', function () {
            searchFunction2();
        });

        function searchFunction() {
            // Declare variables
            var input, filter, td, tr, a, i;
            input = document.getElementById('search');
            filter = input.value.toUpperCase();
            td = document.getElementsByTagName('td');
            tr = document.getElementsByClassName('search_item');

            for(i=0; i < tr.length; i++){
                a = tr[i].innerHTML;
                if(a.toUpperCase().indexOf(filter) > -1){
                    tr[i].style.display = "";
                }else{
                    tr[i].style.display = "none";
                }
            }

        }

        function searchFunction2() {
            // Declare variables
            var input, filter, td, tr, a, i;
            input = document.getElementById('search2');
            filter = input.value.toUpperCase();
            td = document.getElementsByTagName('td');
            tr = document.getElementsByClassName('search_item2');

            for(i=0; i < tr.length; i++){
                a = tr[i].innerHTML;
                if(a.toUpperCase().indexOf(filter) > -1){
                    tr[i].style.display = "";
                }else{
                    tr[i].style.display = "none";
                }
            }

        }

    </script>
@endsection