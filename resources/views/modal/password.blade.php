<div class="modal fade" tabindex="-1" role="dialog" id="changePassword" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-lock"></i> Change Password</h4>
            </div>
            <form method="post" action="{{ url('/user/change/password') }}">
                {{ csrf_field() }}
                <div class="modal-body text-center">
                    <div class="form-group">
                        <input type="password" class="form-control" name="current" placeholder="Current Password" />
                    </div>
                    <div class="form-group">
                        <input type="password" minlength="6" class="form-control" name="password" placeholder="New Password" />
                    </div>
                    <div class="form-group">
                        <input type="password" minlength="6" class="form-control" name="confirm" placeholder="Confirm Password" />
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