<form method="post" action="{{ url('/reservation/update/'.$code) }}">
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="form-group">
            <input type="hidden" class="form-control code" value="{{ $code }}" />
        </div>
        <div class="form-group">
            <label for="">Start Date</label>
            <div class="row" style="margin: 0px;">
                <div class="col-xs-7" style="padding: 0px;">
                    <input type="date" class="form-control" value="{{ \Carbon\Carbon::parse($info->date_start)->format('Y-m-d') }}" name="date_start" required />
                </div>
                <div class="col-xs-5" style="padding: 0px;">
                    <input type="time" class="form-control edit_time_start" value="{{ \Carbon\Carbon::parse($info->time_start)->format('H:i') }}" name="time_start" required />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">End Date</label>
            <div class="row no-margin">
                <div class="col-xs-7 no-padding">
                    <input type="date" class="form-control edit_date_end" value="{{ \Carbon\Carbon::parse($info->date_end)->format('Y-m-d') }}" name="date_end" required />
                </div>
                <div class="col-xs-5 no-padding">
                    <input type="time" class="form-control edit_time_end" value="{{ \Carbon\Carbon::parse($info->time_end)->format('H:i') }}" name="time_end" required />
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="user" value="{{ $info->user }}" placeholder="Borrower's Name" required />
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="title" value="{{ $info->title }}" placeholder="Event Title" required />
        </div>
        <div class="form-group">
            <textarea name="description" rows="3" style="resize: none;" class="form-control" placeholder="Description/Location" required>{!! $info->description !!}</textarea>
        </div>
        <div class="editAvailableItem">
        <div class="form-group">
            @if(count($items)>0)
                <label for="">Items Borrowed:</label>
                <br>
                @foreach($items as $row)
                    <div class="col-sm-12 no-padding">
                        <label>
                            <?php $check = \App\Http\Controllers\ReservationController::isItemByCode($row->id,$code); ?>
                            <input type="checkbox" @if($check) checked @endif name="ids[]" value="{{ $row->id }}" class="minimal"> {{ $row->name }}
                        </label>
                    </div>
                @endforeach
            @else
                <div class="alert bg-danger">
                    No Borrowed items!
                </div>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="clearfix"></div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-flat btn-block btn-success">
            <i class="fa fa-check"></i> Update
        </button>
    </div>
</form>