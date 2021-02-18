<div class="modal fade" tabindex="-1" role="dialog" id="addItem" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-plus"></i> Add Job</h4>
            </div>
            <form method="post" action="{{ url('/job/save') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Date Requested:</label>
                        <div class="row" style="margin: 0px;">
                            <div class="col-xs-7" style="padding: 0px;">
                                <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="requested_date" required />
                            </div>
                            <div class="col-xs-5" style="padding: 0px;">
                                <input type="time" class="form-control" value="{{ date('H:i') }}" name="requested_time" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="requested_by" placeholder="Requested By" required />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="office" placeholder="Office" required />
                    </div>
                    <div class="form-group">
                        <label for="">Requesting To:</label>
                        <br>
                        @foreach($services as $row)
                            <div class="col-sm-12 no-padding">
                                <label>
                                    <input type="checkbox" name="ids[]" value="{{ $row->id }}" class="minimal"> {{ $row->name }}
                                </label>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <textarea name="others" rows="3" style="resize: none;" class="form-control" placeholder="Others: (Please Specify)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="fa fa-check"></i> Submit
                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="updateServices" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-user"></i> IT Personnel</h4>
            </div>
            <div class="serviceSection">
                <div class="text-center" style="padding:20px">
                    <img src="{{ url('img/loading.gif') }}" /><br />
                    <small class="text-muted">Loading...Please wait...</small>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="update" style="z-index:999991;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-edit"></i> Update Job</h4>
            </div>
            <div class="updateSection">
                <div class="text-center" style="padding:20px">
                    <img src="{{ url('img/loading.gif') }}" /><br />
                    <small class="text-muted">Loading...Please wait...</small>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->