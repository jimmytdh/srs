<div class="modal fade" tabindex="-1" role="dialog" id="addTask" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-plus"></i> Add Task</h4>
            </div>
            <form method="post" action="{{ url('/tasks/save') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Due Date:</label>
                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="due_date" required />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="description" placeholder="Description" required />
                    </div>
                    <div class="form-group">
                        <select name="assign_to" id="" class="form-control" required>
                            <option value="">Assign Personnel...</option>
                            <option>Wairley Von Cabiluna</option>
                            <option>Ian Aaron Manugas</option>
                            <option>Jimmy Lomocso</option>
                            <option>Ariel Nocos</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="remarks" rows="3" style="resize: none;" class="form-control" placeholder="Remarks: (Please Specify)"></textarea>
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

<div class="modal fade" tabindex="-1" role="dialog" id="update_task" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-edit"></i> Update Task</h4>
            </div>
            <div class="task_section">
                <div class="text-center" style="padding:20px">
                    <img src="{{ url('img/loading.gif') }}" /><br />
                    <small class="text-muted">Loading...Please wait...</small>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="update" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
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