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
<div id="signatureparent">
    <div id="signature"></div>
    <button type="button" onclick="saveFunc()" class="btn btn-success btn-block btn-lg" style="margin-top: 20px;">
        Save Signature
    </button>
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
    var $sigdiv;
    $(document).ready(function() {
        $sigdiv = $("#signature").jSignature({
            'UndoButton':true,
            'background-color': 'transparent',
            'decor-color': 'transparent',
        });

    });
    function saveFunc()
    {
        var data = $sigdiv.jSignature("getData", "image");
        var img = "data:"+data[0]+","+data[1];
        console.log(img);
    }

</script>