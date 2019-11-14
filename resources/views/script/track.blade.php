<script>
    $("#trackForm").on('submit',function (e) {
        e.preventDefault();
        var data = $(this).serializeArray()[0];
        var route_no = data.value;
        var url = "{{ url('track') }}/"+route_no;
        var loading = "{{ url('loading') }}";
        if(route_no.length > 0){
            $('#trackDocument').modal('show');
            $('span#route_no').html(route_no);

            $('.track_content').load(loading);
            setTimeout(function(){
                $('.track_content').load(url);
            },1000);
        }
    })
</script>