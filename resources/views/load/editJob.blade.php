<form method="post" action="{{ url('/job/update/'.$id) }}">
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="form-group">
            <label for="">Date Requested:</label>
            <div class="row" style="margin: 0px;">
                <div class="col-xs-7" style="padding: 0px;">
                    <input type="date" class="form-control" value="{{ \Carbon\Carbon::parse($data->request_date)->format('Y-m-d') }}" name="requested_date" required />
                </div>
                <div class="col-xs-5" style="padding: 0px;">
                    <input type="time" class="form-control" value="{{ \Carbon\Carbon::parse($data->request_date)->format('H:i') }}" name="requested_time" required />
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" value="{{ $data->request_by }}" name="requested_by" placeholder="Requested By" required />
        </div>
        <div class="form-group">
            <input type="text" class="form-control" value="{{ $data->request_office }}" name="office" placeholder="Office" required />
        </div>
        <div class="form-group">
            <label for="">Requesting To:</label>
            <br>
            @foreach($services as $row)
                <?php $check = \App\Http\Controllers\JobController::ifService($id,$row->id); ?>
                <div class="col-sm-12 no-padding">
                    <label>
                        <input type="checkbox" @if($check) checked @endif name="ids[]" value="{{ $row->id }}" class="minimal"> {{ $row->name }}
                    </label>
                </div>
            @endforeach
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
            <textarea name="others" rows="3" style="resize: none;" class="form-control" placeholder="Others: (Please Specify)">{{ $data->others }}</textarea>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#delete" class="btn btn-danger btn-sm" data-toggle="modal" data-id="{{ $id }}">
            <i class="fa fa-trash"></i> Delete
        </a>
        <button type="submit" class="btn btn-sm btn-success">
            <i class="fa fa-check"></i> Update
        </button>
    </div>
</form>