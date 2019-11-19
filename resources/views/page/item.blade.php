<?php
$user =  \Illuminate\Support\Facades\Session::get('user');
use App\Monitoring;
?>
@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ url('/back/plugins/iCheck/flat/blue.css') }}">
    <link rel="stylesheet" href="{{ url('/back/plugins/iCheck/all.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List of Equipments <small class="text-danger">(Result: {{ $data->total() }})</small></h3>

                        <div class="box-tools pull-right">
                            <form method="post" action="{{ url('/items/search') }}">
                            {{ csrf_field() }}
                            <div class="has-feedback">
                                <input type="text" name="keyword" class="form-control input-sm" value="{{ Session::get('searchItem') }}" placeholder="Search Keyword...">
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                            </div>
                            </form>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <div class="btn-group">
                                <button type="button" data-toggle="modal" data-target="#addItem" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                                <button data-target="#borrowItem" data-toggle="modal" type="button" class="btn btn-info btn-sm"><i class="fa fa-share"></i> Borrow</button>
                                <button data-target="#returnItem" data-toggle="modal" type="button" class="btn btn-danger btn-sm"><i class="fa fa-exchange"></i> Return</button>
                            </div>

                            <!-- /.pull-right -->
                        </div>

                        <div class="table-responsive mailbox-messages" style="margin:5px 0px; border-top:1px solid #d6d6d6;border-bottom:1px solid #d6d6d6;">
                            <table class="table table-hover table-striped table-bordered">
                                <thead class="bg-green-gradient">
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Date Borrowed/Returned</th>
                                        <th>Borrowed/Returned By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $row)
                                    <?php $info = \App\Http\Controllers\ItemController::borrowInfo($row->id);?>
                                    <tr>
                                        <td class="mailbox-name text-bold">
                                            <a href="#update" data-toggle="modal" data-id="{{ $row->id }}">
                                                @if($row->status=='Available')
                                                    <i class="fa fa-circle text-success"></i>
                                                @else
                                                    <i class="fa fa-circle-o text-danger"></i>
                                                @endif
                                                &nbsp;&nbsp;&nbsp;{{ $row->name }}
                                            </a>
                                        </td>
                                        <td class="mailbox-subject">{{ \App\Http\Controllers\ParamController::string_limit_words($row->description,35) }}</td>
                                        <td class="mailbox-attachment">
                                            {!! \App\Http\Controllers\ItemController::status($row->status) !!}
                                        </td>
                                        @if($info)
                                            @if($row->status=='Borrowed')
                                            <td class="mailbox-date">@if($info->date_borrowed!='0000-00-00 00:00:00'){{ \Carbon\Carbon::parse($info->date_borrowed)->format('M d, h:i A') }}@endif</td>
                                            <td class="mailbox-date">{{ $info->user_borrowed }}</td>
                                            @else
                                            <td class="mailbox-date">@if($info->date_returned!='0000-00-00 00:00:00'){{ \Carbon\Carbon::parse($info->date_returned)->format('M d, h:i A') }}@endif</td>
                                            <td class="mailbox-date">{{ $info->user_returned }}</td>
                                            @endif
                                        @else
                                            <td></td>
                                            <td></td>
                                        @endif
                                    </tr>
                                    @endforeach

                                    @if(count($data)==0)
                                    <tr>
                                        <td class="text-center text-danger text-bold" colspan="10"><br>No Items Found<br><br></td>
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
@include('modal.addItem')
@include('modal.borrowItem')
<div class="modal fade" tabindex="-1" role="dialog" id="delete" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-times-circle"></i> Delete Item</h4>
            </div>
            <form method="post" action="{{ url('/items/delete') }}">
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

<div class="modal fade" tabindex="-1" role="dialog" id="update" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-pencil"></i> Edit Item</h4>
            </div>
            <div class="editSection">
                <div class="text-center" style="padding:20px">
                    <img src="{{ url('img/loading.gif') }}" /><br />
                    <small class="text-muted">Loading...Please wait...</small>
                </div>
            </div>
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
            //Enable iCheck plugin for checkboxes
            //iCheck for checkbox and radio inputs
            $('.mailbox-messages input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });

            //Enable check and uncheck all functionality
            $(".checkbox-toggle").click(function () {
                var clicks = $(this).data('clicks');
                if (clicks) {
                    //Uncheck all checkboxes
                    $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
                    $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                } else {
                    //Check all checkboxes
                    $(".mailbox-messages input[type='checkbox']").iCheck("check");
                    $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
                }
                $(this).data("clicks", !clicks);
            });

            //Handle starring for glyphicon and font awesome
            $(".mailbox-star").click(function (e) {
                e.preventDefault();
                //detect type
                var $this = $(this).find("a > i");
                var glyph = $this.hasClass("glyphicon");
                var fa = $this.hasClass("fa");

                //Switch states
                if (glyph) {
                    $this.toggleClass("glyphicon-star");
                    $this.toggleClass("glyphicon-star-empty");
                }

                if (fa) {
                    $this.toggleClass("fa-star");
                    $this.toggleClass("fa-star-o");
                }
            });

            $("#btnBorrow").click(function () {
                var ids = $(".item_id:checked").map(function(){
                    return $(this).val();
                }).toArray();
                if(ids.length==0){
                    $('.btnBorrowSubmit').addClass('hidden');
                }else{
                    $('.btnBorrowSubmit').removeClass('hidden');
                }
                $("#inputBorrowItemsHidden").val(ids);
            });

            $("#btnReturn").click(function () {
                var ids = $(".item_id:checked").map(function(){
                    return $(this).val();
                }).toArray();
                if(ids.length==0){
                    $('.btnReturnSubmit').addClass('hidden');
                }else{
                    $('.btnReturnSubmit').removeClass('hidden');
                }
                $("#inputReturnItemsHidden").val(ids);
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

            $('a[href="#update"]').click(function () {
                var id = $(this).data('id');
                var url = "{{ url('items/edit/') }}/"+id;
                $('.editSection').load("{{ url('/loading') }}");
                setTimeout(function () {
                    $('.editSection').load(url);
                },1000);
            });
        });
    </script>
@endsection