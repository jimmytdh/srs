<?php
    $status = session('status');
?>
<script>
    @if($status)
        lobibox("{{ $status['status'] }}","{{ $status['title'] }}","{{ $status['msg'] }}");
    @endif

    function lobibox(status,title,msg)
    {
        Lobibox.notify(status, {
            title: title,
            rounded: true,
            delay: 3000,
            msg: msg
        });
    }
</script>