<form method="post" action="{{ url('/tasks/update/'.$info->id) }}">
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="form-group">
            <label for="">Due Date:</label>
            <input type="date" class="form-control" value="{{ $info->due_date }}" name="due_date" required />
        </div>
        <div class="form-group">
            <input type="text" class="form-control" value="{{ $info->description }}" name="description" placeholder="Description" required />
        </div>
        <div class="form-group">
            <select name="assign_to" class="form-control" required>
                <option value="">Assign Personnel...</option>
                <option @if($info->assign_to=='Wairley Von Cabiluna') selected @endif>Wairley Von Cabiluna</option>
                <option @if($info->assign_to=='Ian Aaron Manugas') selected @endif>Ian Aaron Manugas</option>
                <option @if($info->assign_to=='Jimmy Lomocso') selected @endif>Jimmy Lomocso</option>
                <option @if($info->assign_to=='Ariel Nocos') selected @endif>Ariel Nocos</option>
            </select>
        </div>
        <div class="form-group">
            <select name="status" class="form-control" required>
                <option @if($info->status=='Pending') selected @endif>Pending</option>
                <option @if($info->status=='Complete') selected @endif>Complete</option>
            </select>
        </div>
        <div class="form-group">
            <textarea name="remarks" rows="3" style="resize: none;" class="form-control" placeholder="Remarks: (Please Specify)">{!! $info->remarks !!}</textarea>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#delete" class="btn btn-danger btn-sm" data-toggle="modal" data-id="{{ $info->id }}">
            <i class="fa fa-trash"></i> Delete
        </a>
        <button type="submit" class="btn btn-sm btn-success">
            <i class="fa fa-check"></i> Update
        </button>
    </div>
</form>