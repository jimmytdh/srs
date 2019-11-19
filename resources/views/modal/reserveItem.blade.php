<div class="modal fade" role="dialog" id="reserveItem" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-share"></i> Borrow Item(s)</h4>
            </div>
            <form method="post" action="{{ url('/reservation/save') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" value="" name="ids" id="inputReservedItems"  />
                    </div>
                    <div class="form-group">
                        <label for="">Start Date</label>
                        <div class="row" style="margin: 0px;">
                            <div class="col-xs-7" style="padding: 0px;">
                                <input type="date" readonly="" class="form-control" value="{{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}" name="date_start" required />
                            </div>
                            <div class="col-xs-5" style="padding: 0px;">
                                <input type="time" class="form-control" value="08:00" name="time_start" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">End Date</label>
                        <div class="row no-margin">
                            <div class="col-xs-7 no-padding">
                                <input type="date" class="form-control" value="{{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}" name="date_end" required />
                            </div>
                            <div class="col-xs-5 no-padding">
                                <input type="time" class="form-control" value="17:00" name="time_end" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="user" placeholder="Borrower's Name" required />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="Event Title" required />
                    </div>
                    <div class="form-group">
                        <textarea name="description" rows="3" style="resize: none;" class="form-control" placeholder="Description/Location" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Items:</label>
                        <br>
                        @foreach($items as $row)
                            <div class="col-sm-12 no-padding">
                                <label>
                                    <input type="checkbox" name="ids[]" value="{{ $row->id }}" class="minimal"> {{ $row->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success btn-flat btn-block">
                        <i class="fa fa-check"></i> Reserve
                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="getItem" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-tv"></i> Confirmation</h4>
            </div>

            <form method="post" action="{{ url('/reservation/save') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <a href="#cancel" class="btn btn-sm btn-danger btn-flat col-xs-6">
                            <i class="fa fa-times fa-3x"></i>
                            <br>
                            Cancel Reservation
                        </a>
                        <a href="#borrow" class="btn btn-sm btn-success btn-flat col-xs-6">
                            <i class="fa fa-check fa-3x"></i>
                            <br>
                            Get Items
                        </a>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="editItem" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-tv"></i> Confirmation</h4>
            </div>
            <div class="reservationSection">
                Loading...
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->