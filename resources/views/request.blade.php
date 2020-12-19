<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>I.T. Job Request Form</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/back') }}/css/AdminLTE.min.css">

    <!-- Google Font -->
    <style>
        .title {
            text-align: center;
            font-weight: 300;
            font-size: 25px;
            margin-bottom: 25px;
            line-height: 25px;
        }
        .sub {
            font-weight: 500;
            font-size: 20px;
        }
    </style>

</head>
<body class="hold-transition login-page">
<div class="login-box" style="margin:3% auto;">

    <div class="login-logo" style="margin-bottom: 10px;">
        <img src="{{ asset('img/doh.png') }}" width="78px" />
        <img src="{{ asset('img/logo-white.png') }}" width="80px" />
    </div>
    <div class="title">
        <font class="region">I.T. Job Request Form</font><br>
        <font class="sub">Cebu South Medical Center</font>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Please input details below!</p>

        <div class="alert alert-success alert-msg hidden">
            Request successfully sent!
        </div>
        <form action="{{ url('/request') }}" method="post" id="request_form">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Requested by" id="request_by" required name="request_by" autofocus>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Office/Section/Division" id="request_office" name="request_office" required>
            </div>
            <div class="form-group">
                <label for="">Requesting To:</label>
                <br>
                @foreach($services as $row)
                    <div class="col-sm-12 no-padding">
                        <label>
                            <input type="checkbox" name="ids[]" value="{{ $row->id }}" class="minimal"> {{ $row->name }}
                        </label>
                    </div>
                @endforeach
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <textarea name="others" rows="3" style="resize: none;" class="form-control" placeholder="Others: (Please Specify)"></textarea>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Submit Request</button>
                </div>
            </div>
        </form>

        <hr />
        <a href="{{ url('/') }}"><i class="fa fa-arrow-left"></i> Back to login Page</a><br>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ url('/back') }}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('/back') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
@include('firebase.config')
<script>
    //initialize firebase
    var dbRef = firebase.database();
    //create table
    var requestRef = dbRef.ref('requests');

    $(document).ready(function() {
        $('#request_form').submit(function(e) {
            e.preventDefault();
            var url = "{{ url('/request') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                beforeSend: function(){
                    disableSubmit('#request_form');
                    requestRef.push({
                        request_by : $('#request_by').val(),
                        request_office : $('#request_office').val()
                    });
                },
                success: function(result){
                    console.log(result);
                    setTimeout(function() {
                        enableSubmit('#request_form');
                        resetForm('request_form');
                        requestRef.on('child_added',function(data){
                            requestRef.child(data.key).remove();
                            $('.alert-msg').removeClass('hidden');
                        });
                    },500);
                }
            });
        });
    });

    function resetForm(form)
    {
        document.getElementById(form).reset();
        $('#request_by').focus();
    }

    function disableSubmit(form)
    {
        $(form).find('button[type=submit]').html('Processing...').attr('disabled',true);
    }

    function enableSubmit(form)
    {
        $(form).find('button[type=submit]').html('Submit').attr('disabled',false);
    }
</script>
</body>
</html>
