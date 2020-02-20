<form method="post" action="{{ url('/job/services/'.$id) }}">
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="form-group">
            <textarea name="findings" rows="3" style="resize: none;" class="form-control" placeholder="Findings" required>{{ $data->findings }}</textarea>
        </div>
        <div class="form-group">
            <textarea name="remarks" rows="3" style="resize: none;" class="form-control" placeholder="Remarks/Recommendation" required>{{ $data->remarks }}</textarea>
        </div>
        <div class="form-group">
            <select name="service_by" id="" class="form-control" required>
                <option value="">Select Personnel...</option>
                <option>Wairley Von Cabiluna</option>
                <option>Ian Aaron Manugas</option>
                <option>Jimmy Lomocso</option>
                <option>Ariel Nocos</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Date Acted:</label>
            <div class="row" style="margin: 0px;">
                <div class="col-xs-7" style="padding: 0px;">
                    <input type="date" class="form-control" value="{{ \Carbon\Carbon::parse($data->request_date)->format('Y-m-d') }}" name="acted_date" required />
                </div>
                <div class="col-xs-5" style="padding: 0px;">
                    <input type="time" class="form-control" value="{{ \Carbon\Carbon::parse($data->request_date)->format('H:i') }}" name="acted_time" required />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">Date Completed:</label>
            <div class="row" style="margin: 0px;">
                <div class="col-xs-7" style="padding: 0px;">
                    <input type="date" class="form-control" value="{{ \Carbon\Carbon::parse($data->request_date)->format('Y-m-d') }}" name="completed_date" required />
                </div>
                <div class="col-xs-5" style="padding: 0px;">
                    <input type="time" class="form-control" value="{{ \Carbon\Carbon::parse($data->request_date)->format('H:i') }}" name="completed_time" required />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-flat btn-block btn-success">
            <i class="fa fa-check"></i> Update
        </button>
    </div>
</form>