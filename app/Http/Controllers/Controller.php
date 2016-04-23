<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public function helpError($message, $validator = false) {
        
        if($validator) {
            return array('response' => [], 'error' => true, 'message' => $message, 'validator' => $validator->errors()->all());
        }
        return array('response' => [], 'error' => true, 'message' => $message);
    }

    public function helpReturn($response, $info = false, $message = false) {
        $arrayForResponse['response'] = $response;
        if($info) {
            $arrayForResponse['info'] = $info;
        }
        if($message) {
            $arrayForResponse['message'] = $message;
        }
        $arrayForResponse['error'] = false;
        if(!$response) {
            $arrayForResponse['error'] = true;
            $arrayForResponse['message'] = 'Resource not found';
        }

        return $arrayForResponse;
    }
    
    public static function helpReturnS($response, $info = false, $message = false) {
        $arrayForResponse['response'] = $response;
        if($info) {
            $arrayForResponse['info'] = $info;
        }
        if($message) {
            $arrayForResponse['message'] = $message;
        }
        $arrayForResponse['error'] = false;
        if(!$response) {
            $arrayForResponse['error'] = true;
            $arrayForResponse['message'] = 'Resource not found';
        }

        return $arrayForResponse;
    }

    public function helpInfo($message = false) {
        if($message) {
            $arrayForResponse['message'] = $message;
        }
        $arrayForResponse['response'] = [];
        $arrayForResponse['error'] = false;
        return $arrayForResponse;
    }

    /**
     * @device_ids string sa
     * @message arrray message,type,id
     */
    public function sendPushToAndroid(array $device_ids, $message = false) {
        define('API_ACCESS_KEY', 'AIzaSyCJb8kzYjf6vTu1gyet0ZS_4v4MoiaqVEA');
        if(!$message) {
            $message = array
                (
                'message' => 'here is a message. message',
                'title' => 'This is a title. title',
                'subtitle' => 'This is a subtitle. subtitle',
                'tickerText' => 'Ticker text here...Ticker text here...Ticker text here',
                'vibrate' => 1,
                'sound' => 1,
                'largeIcon' => 'large_icon',
                'smallIcon' => 'small_icon'
            );
        } else {
            $message = array
                (
                'message' => $message['message'],
                'image' => $message['image']
            );
        }

        $fields = array
            (
            'registration_ids' => $device_ids,
            'data' => $message
        );
        $headers = array
            (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        //print_r($result);
        curl_close($ch);
        return $result;
    }

    public function sendPushToIos($device_ids, $message) {
        return 'Now not work';
    }

    public function sendPushToUser($user, $message) {
        if($user->deviceType == 'android') {
            $response = $this->sendPushToAndroid(array($user->deviceToken), $message);
        } elseif($user->deviceType == 'ios') {
            $response = $this->sendPushToIos(array($user->deviceToken), $message);
        } else {
            $response = false;
        }
        return $response;
    }

}
