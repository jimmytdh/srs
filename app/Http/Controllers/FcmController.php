<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FcmController extends Controller
{
    function sendMessage()
    {
        $to = '/topics/jobrequest';
        $notif = array(
            'title' => 'A new Job Request',
            'body' => 'Requested by Dee Resma of HR Office'
        );
        return $this->sendPushNotification($to, $notif);
    }
    function sendPushNotification($to, $notif) {
        $apiKey = "AAAAXz8qDr8:APA91bHNcm_sWctzo4ADdf8fGL4GnX8-K9RI10yXwOYZ8-LadKRnhPxrgZ0knkm9jDP3-4B9txvN8u6qonfzLNk0BHGrc_3rHPY7quwPl-NhWf3psYLt10cnkZC0NRWGJnivw5MSeBe9";
        $ch = curl_init();

        $url = "https://fcm.googleapis.com/fcm/send";
        $fields = json_encode(array(
                    'to' => $to,
                    'notification' => $notif
                ));

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $headers = array();
        $headers[] = 'Authorization: key ='.$apiKey;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
    }
}
