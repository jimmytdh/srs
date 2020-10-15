<script>
    @if(session('success'))
        lobibox('success','Success', "{{ session('success') }}");
    @endif

    @if(session('error'))
    lobibox('error','Failed', "{{ session('error') }}");
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