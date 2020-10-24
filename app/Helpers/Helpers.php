<?php

//Json array response
function responseJson($status, $code, $msg, $data = null, $state = 200)
{
    $response = [
        'status' => (int)$status,
        'code' => (int)$code,
        'message' => $msg,
        'data' => $data,
    ];
    return response()->json($response, $state);
}

function switch_notify_message($notifiable_type){
    $message = '';
    switch($notifiable_type) {
        case 'test':
            $message = "Welcome to Our New Hotel Search Solution.";
            break;
        case 'new_hotel':
            $message = "A new hotel has been added.";
            break;
    }
    return $message;
}
function sendNotification( $user_id, $notifiable_id = 0, $notifiable_type, $type) 
{
    //send via firebase
    $notify_sent = firebasePushNotification($user_id, $type);
    if ($notify_sent) {
        return true;
    } else {
        return false;
    }
}

function firebasePushNotification($user_id, $type) 
{
    //get user
    $user = \App\User::find($user_id);
    if (!empty($user) && isset($user->id)) {
        //get player or device id
        $tokenId = $user->device_id;
        if (empty($tokenId)) {
            return false;
        }
    } else {
        return false;
    }
    $notification_text = switch_notify_message($type);
    if (!empty($notification_text)) {
        $message = $notification_text;
    } else {
        $message = "";
    }
    //dump_exit(" MSG : ".$notify_obj);
    if (!defined('API_ACCESS_KEY')) {
        define('API_ACCESS_KEY', '');
    }
    $registrationIds = array($tokenId);
    $title = " ";
    $msg = array(
        "to" => $tokenId,
        "notification" => array(
            "title" => $title,
            "body" => $message,
            "sound" => "default",
            "is_background" => FALSE,
        //"icon" => ci_site_url('assets/images/favicon.png')
        ),
        /*
          To send additional data
          "data" : {
          "volume" : "3.21.15",
          "contents" : "http://www.news-magazine.com/world-week/21659772"
          },
         */
        "priority" => "high",
    );
    $firebase_fields = array(
        'registration_ids' => $registrationIds,
        'data' => $msg
    );
    //dump_exit(json_encode( $firebase_fields ));
    $headers = array(
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );
    $url = 'https://fcm.googleapis.com/fcm/send';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($msg));
    $result = curl_exec($ch);
    curl_close($ch);
    $result_obj = json_decode($result);
    //if(!empty($this->_debug_mode)) dump_exit($result_array);
    if (!empty($result_obj)) {
        return (!empty($result_obj->success)) ? true : false;
    } else {
        return $result;
    }
}

