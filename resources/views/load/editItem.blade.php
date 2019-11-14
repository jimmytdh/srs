<form method="post" action="{{ url('/items/update/'.$id) }}">
    {{ csrf_field() }}
    <div class="modal-body text-center">
        <div class="form-group">
            <input type="text" value="{{ $data->name }}" class="form-control" name="name" placeholder="Item Name" required />
        </div>
        <div class="form-group">
            <textarea name="description" id="" rows="5" style="resize: none;" required class="form-control" placeholder="Description">{!! $data->description !!}</textarea>
        </div>
        <div class="form-group">
            <select name="status"  @if($data->status=='Borrowed') disabled @endif class="form-control">
                <option @if($data->status=='Available') selected @endif>Available</option>
                <option @if($data->status=='Not Available') selected @endif>Not Available</option>
                @if($data->status=='Borrowed')
                    <option selected>{{ $data->status }}</option>
                @endif
            </select>
        </div>
    </div>
    <div class="modal-footer">
        @if($data->status!='Borrowed')
            <a href="{{ url('items/delete/'.$id) }}" class="btn btn-danger">
                <i class="fa fa-trash"></i> Delete
            </a>
        @endif
        <button type="submit" class="btn btn-sm btn-success">
            <i class="fa fa-check"></i> Update
        </button>
    </div>
</form>