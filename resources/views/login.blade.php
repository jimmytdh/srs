    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CSMC:IHOMP Service Request</title>
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
        <img src="{{ asset('img/logo.png') }}" width="80px" />
    </div>
    <div class="title">
        <font class="region">Cebu South Medical Center</font><br>
        <font class="sub">Service Request System</font>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?php $status = session('status'); ?>

        <p class="login-box-msg">Sign in to start your session</p>
        @if(session('status')=='error')
            <div class="alert alert-warning text-warning">
                <i class="fa fa-warning"></i> Incorrect Username/Password.
            </div>
        @elseif($status=='inactive' || $status=='banned')
            <div class="alert alert-danger text-danger">
                <i class="fa fa-warning"></i> Login failed! Your account is {{ $status }}.
            </div>
        @elseif($status=='denied')
            <div class="alert alert-danger text-danger">
                <i class="fa fa-warning"></i> Access Denied!
            </div>
        @endif
        <form action="{{ url('login') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Username" name="username" autofocus>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <a href="{{ url('/request') }}" class="btn btn-success btn-block btn-flat">Send Request</a>
                </div>
                <!-- /.col -->
                <div class="col-xs-6">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <hr />
        <a href="{{ url('/forgot/password') }}">I forgot my password</a><br>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ url('/back') }}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('/back') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
