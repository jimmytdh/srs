@include('firebase.config')
<script>
    var dbRef = firebase.database();
    var reqRef = dbRef.ref('requests');
    reqRef.on('child_added', function(snapshot){
        var data = snapshot.val();
        Lobibox.notify('success', {
            delay: false,
            title: 'Job Request',
            msg: 'Receive a job request from '+data.request_by+' of '+ data.request_office+'.',
            sound: false,
        });
    });

</script>