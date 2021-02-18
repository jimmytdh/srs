<!DOCTYPE html>
<html>
<head>
    <title>Sign Here</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ url('/back/bower_components') }}/bootstrap/dist/css/bootstrap.min.css">
    <style>
        #signatureparent {
            color:#000;
            background-color:darkgrey;
            /*max-width:600px;*/
            padding:20px;
        }

        /*This is the div within which the signature canvas is fitted*/
        #signature {
            border: 2px dotted black;
            background-color:lightgrey;
        }

        /* Drawing the 'gripper' for touch-enabled devices */
        html.touch #content {
            float:left;
            width:92%;
        }
        html.touch #scrollgrabber {
            float:right;
            width:4%;
            margin-right:2%;
            background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAFCAAAAACh79lDAAAAAXNSR0IArs4c6QAAABJJREFUCB1jmMmQxjCT4T/DfwAPLgOXlrt3IwAAAABJRU5ErkJggg==)
        }
        html.borderradius #scrollgrabber {
            border-radius: 1em;
        }

    </style>
</head>
<body>
    <div id="signatureparent">
        <div id="signature"></div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-sm-6">
                <button type="button" onclick="closeForm()" class="btn btn-warning btn-block btn-lg">
                    Close Form
                </button>
            </div>
            <div class="col-sm-6">
                <button type="button" onclick="saveFunc()" class="btn btn-success btn-block btn-lg">
                    Save Signature
                </button>
            </div>
        </div>

    </div>
    <script src="{{ url('/back/bower_components') }}/jquery/dist/jquery.min.js"></script>
    <script src="{{ url('/back/plugins/jSignature') }}/libs/modernizr.js"></script>
    <!--[if lt IE 9]>
        <script type="text/javascript" src="{{ url('/back/plugins/jSignature') }}/libs/flashcanvas.js"></script>
        <![endif]-->
    <script src="{{ url('/back/plugins/jSignature') }}/src/jSignature.js"></script>
    <script src="{{ url('/back/plugins/jSignature') }}/src/plugins/jSignature.CompressorBase30.js"></script>
    <script src="{{ url('/back/plugins/jSignature') }}/src/plugins/jSignature.CompressorSVG.js"></script>
    <script src="{{ url('/back/plugins/jSignature') }}/src/plugins/jSignature.UndoButton.js"></script>
    <script src="{{ url('/back/plugins/jSignature') }}/src/plugins/signhere/jSignature.SignHere.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        var $sigdiv;
        $(document).ready(function() {
            $sigdiv = $("#signature").jSignature({
                'UndoButton':true,
                'background-color': 'transparent',
                'decor-color': 'transparent',
                lineWidth: 10,

            });

        });
        function saveFunc()
        {
            var data = $sigdiv.jSignature("getData", "image");
            var img = "data:"+data[0]+","+data[1];
            var url = "{{ request()->url() }}";
            $.ajax({
                url: url,
                data: {
                    signature: img
                },
                type: "post",
                cache: false,
                success: function (res){
                    closeForm();
                }
            })
        }

        function closeForm()
        {
            window.top.close();
        }

    </script>
</body>
