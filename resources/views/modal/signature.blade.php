<div class="modal fade" tabindex="-1" role="dialog" id="signatureModal" style="z-index:999991;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-lock"></i> Sign Here</h4>
            </div>
            <div class="modal-body">
                <div id="signatureparent">
                    <div>jSignature inherits colors from parent element. Text = Pen color. Background = Background. (This works even when Flash-based Canvas emulation is used.)</div>
                    <div id="signature"></div>
                </div>
                <div id="tools"></div>
                <div><p>Display Area:</p><div id="displayarea"></div></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-success">
                    <i class="fa fa-check"></i> Submit
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->