<?php
    use App\Http\Controllers\JobController as JobCtrl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Print Job Report</title>
    <style>
        .wrapper {
            border:1px solid #727272;
            width: 900px;
            min-height: 300px;
            padding: 20px 0px;
        }
        .title {
            text-align: center;
        }
        table { width: 100%; }
        table td {
            padding: 5px;
            font-size: 0.8em;
            vertical-align: top;
        }
        .table {
            width: 95%;
            margin: 0 auto;
        }
        .pull-right { float: right; }
        .pull-left { float: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        h2 { margin:0px; padding: 0px;}
        .remarks, .findings, .others {
            min-height: 50px;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <img src="{{ url('/img/doh.png') }}" width="70" alt="" class="pull-left" style="margin-left: 20px;">
    <img src="{{ url('/img/logo.png') }}" width="70" alt="" class="pull-right" style="margin-right: 20px;">
    <div class="title">
        Republic of the Philippines<br />
        Department of Health<br />
        <strong>CEBU SOUTH MEDICAL CENTER</strong><br />
        San Isidro, Talisay City, Cebu<br />
        <em>“A PHIC Accredited and ISO 9001:2015 Certified Healthcare Provider”</em>
        <br>
        <br>
        <h2>I.T. Job Request Form</h2>
    </div>
    <table>
        <tr>
            <td width="50%">

                <table border="1px" cellpadding="0" cellspacing="0" class="table">
                    <tr>
                        <td colspan="2">
                            Form No: <strong>{{ $data->form_no }}</strong>
                            <span class="pull-right"><em>(To be filled by IT Personnel)</em></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Date: {{ date('M d, Y',strtotime($data->request_date)) }}</td>
                        <td>Time: {{ date('h:i A',strtotime($data->request_date)) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Requested/Instructed by:
                            <br>


                            <br>
                            <div class="text-center">
                                <strong><u>{{ $data->request_by }}</u></strong>
                                <br>
                                <em>Signature over Printed Name</em>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Office: {{ $data->request_office }}</td>
                    </tr>
                </table>
                <table border="1px" cellpadding="0" cellspacing="0" style="margin-top: 10px;" class="table">
                    <tr>
                        <td colspan="2" class="bold">Requesting to:</td>
                    </tr>
                    <tr>
                        <td width="50%"><input type="checkbox" {{ JobCtrl::checkJobService($data->id, 1) }}> Network Connection</td>
                        <td><input type="checkbox" {{ JobCtrl::checkJobService($data->id, 4) }}> Install/Check Printer</td>
                    </tr>
                    <tr>
                        <td width="50%"><input type="checkbox" {{ JobCtrl::checkJobService($data->id, 2) }}> Check Computer</td>
                        <td><input type="checkbox" {{ JobCtrl::checkJobService($data->id, 5) }}> Install Software</td>
                    </tr>
                    <tr>
                        <td width="50%"><input type="checkbox" {{ JobCtrl::checkJobService($data->id, 3) }}> iHOMIS Concern</td>
                        <td><input type="checkbox" {{ JobCtrl::checkJobService($data->id, 6) }}> Setup IT Equipment</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Other: <em>(Please Specify)</em>
                            <div class="others">
                                {!! nl2br($data->others) !!}
                            </div>
                        </td>
                    </tr>
                </table>
                <br>
                <table class="table">
                    <tr>
                        <td class="text-left">MCC-IT-FM-05 Rev.0<br>
                            10 October 2019</td>
                    </tr>
                </table>
            </td>


            <td width="50%">
                <table border="1" cellspacing="0" cellpadding="0" class="table">
                    <tr>
                        <td class="bold" colspan="2"><em>(To be accomplished by IT Personnel)</em></td>
                    </tr>
                    <tr>
                        <td colspan="2">Finding (s): <br>
                            <div class="findings">
                                {!! nl2br($data->findings) !!}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Remarks/Recommendation: <br>
                            <div class="remarks">
                                {!! nl2br($data->remarks) !!}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Service By: <br><br><br>

                        <div class="text-center">
                            <strong><u>{{ $data->service_by }}</u></strong>
                            <br>
                            <em>Signature over Printed Name</em>
                        </div>
                        <br>
                    </tr>
                    <tr>
                        <td width="50%">Date Acted: {{ ($data->acted_date) ? date('M d, Y',strtotime($data->acted_date)): null }}</td>
                        <td>Time: {{ ($data->acted_date) ? date('h:i A',strtotime($data->acted_date)) : null }}</td>
                    </tr>
                    <tr>
                        <td width="50%">Date Completed: {{ ($data->date_completed) ? date('M d, Y',strtotime($data->completed_date)): '' }}</td>
                        <td>Time: {{ ($data->date_completed) ? date('h:i A',strtotime($data->completed_date)): null }}</td>
                    </tr>
                </table>

                <br>
                <table class="table">
                    <tr>
                        <td>
                            <strong>Confirmed by (End User):</strong>
                            <br><br><br>

                            <div class="text-center">
                                <strong><u>{{ $data->request_by }}</u></strong>
                                <br>
                                <em>Signature over Printed Name</em>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>