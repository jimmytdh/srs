<div class="modal fade" tabindex="-1" role="dialog" id="borrowItem" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-share"></i> Borrow Item(s)</h4>
            </div>
            <form method="post" action="{{ url('/items/borrow') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" value="" name="ids" id="inputBorrowItemsHidden"  />
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="date" required />
                    </div>
                    <div class="form-group">
                        <input type="time" class="form-control" value="{{ date('H:i') }}" name="time" required />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="user" placeholder="Borrower's Name" required />
                    </div>
                    <div class="form-group">
                        <textarea name="remarks" rows="3" style="resize: none;" class="form-control" placeholder="Remarks (optional)"></textarea>
                    </div>
                    <div class="form-group">
                        @if(count($available)>0)
                            <label for="">Items Available:</label>
                            <br>
                            @foreach($available as $row)
                                <div class="col-sm-6 no-padding">
                                    <label>
                                        <input type="checkbox" name="ids[]" value="{{ $row->id }}" class="minimal">&nbsp; {{ $row->name }}
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <div class="alert bg-danger">
                                No available items!
                            </div>
                        @endif
                    </div>
                </div>
                @if(count($available)>0)
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success btnBorrowSubmit">
                        <i class="fa fa-check"></i> Borrow
                    </button>
                </div>
                @endif
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="returnItem" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-exchange"></i> Return Item(s)</h4>
            </div>
            <form method="post" action="{{ url('/items/return') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" value="" name="ids" id="inputReturnItemsHidden"  />
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="date" required />
                    </div>
                    <div class="form-group">
                        <input type="time" class="form-control" value="{{ date('H:i') }}" name="time" required />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="user" placeholder="Borrower's Name" required />
                    </div>
                    <div class="form-group">
                        <textarea name="remarks" rows="3" style="resize: none;" class="form-control" placeholder="Remarks (optional)"></textarea>
                    </div>
                    <div class="form-group">
                        @if(count($borrowed)>0)
                            <label for="">Borrowed Items:</label>
                            <br>
                            @foreach($borrowed as $row)
                                <div class="col-sm-6 no-padding">
                                    <label>
                                        <input type="checkbox" name="ids[]" value="{{ $row->id }}" class="minimal">&nbsp; {{ $row->name }}
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <div class="alert bg-danger">
                                No borrowed items!
                            </div>
                        @endif
                    </div>
                </div>
                @if(count($borrowed)>0)
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success btnReturnSubmit">
                        <i class="fa fa-check"></i> Return
                    </button>
                </div>
                @endif
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->