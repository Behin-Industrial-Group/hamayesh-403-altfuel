<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SmsLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SMSController extends Controller
{
    private $url;
    private $user;
    private $pass;
    private $org;

    public function __construct() {
        $this->url = 'https://payamsms.com/services/rest/index.php';
        $this->org = 'irngv';
        $this->user = 'irngv';
        $this->pass = 'irngv123';
    }
    public function send($to, $msg)
    {
        $data = array(
            'organization' => $this->org,
            'username' => $this->user,
            'password' => $this->pass,
            'method' => 'send',
            'messages' => array([
                'sender' => '9820003807',
                'recipient' => $to,
                'body' => $msg,
                'customerId' => 1,
            ]
            )
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        # Setup request to send json via GET.
        $payload = json_encode($data);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, False);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);

        # Return response instead of printing.
        # Send request.
        $er = curl_error($ch);
        if($er)
            Log::info("send sms curl error: $er ");
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);
        if(isset($result->data[0]->serverId)){
            // SmsLog::set(Auth::user(), $to, $msg);
            return 'ok';
        }
        return 'not ok';
    }

    public function send_multiple(array $messages)
    {
        $data = array(
            'organization' => $this->org,
            'username' => $this->user,
            'password' => $this->pass,
            'method' => 'send',
            'messages' => $messages
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        # Setup request to send json via GET.
        $payload = json_encode($data);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, False);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);

        # Return response instead of printing.
        # Send request.
        $er = curl_error($ch);
        if($er)
            Log::info("send sms curl error: $er ");
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);
        if(isset($result->data[0]->serverId))
            return 'ok';
        return $result;
    }

}
