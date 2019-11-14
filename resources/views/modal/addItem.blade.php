<div class="modal fade" tabindex="-1" role="dialog" id="addItem" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-plus"></i> Add Item</h4>
            </div>
            <form method="post" action="{{ url('/items/save') }}">
                {{ csrf_field() }}
                <div class="modal-body text-center">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="Item Name" required />
                    </div>
                    <div class="form-group">
                        <textarea name="description" rows="5" style="resize: none;" required class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group">
                        <select name="status" id="" class="form-control">
                            <option>Available</option>
                            <option>Not Available</option>
                        </select>
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