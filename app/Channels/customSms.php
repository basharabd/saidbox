<?php
namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use League\Flysystem\Config;

class customSms {
    public function send($notifiable , Notification $notification)
    {


        $config = Config('services.custom-sms');

        if (!method_exists($notifiable , 'routeNotificationForSms'))
        {

            throw new \Exception('you must define method "routeNotificationForSms" in your notifiable model');

        }

        $to= $notifiable->routeNotificationForSms($notification);

        if(!$to)
        {
            throw new \Exception('Empty Mobile Number');
        }

        if (!method_exists($notification , 'toSms'))
        {

            throw new \Exception('you must define method "toSms" in your notification model');

        }
        $message = $notification->toSms($notifiable);

          $response =  Http::baseUrl('http://www.tweetsms.ps')
             
              ->get('api.php',[
                'comm'=>'sendsms',
                'user'=>$config['user'],
                'pass'=>$config['pass'],
                'to'=>$to,
                'message'=>urlencode($message),
                'sender'=>$config['sender'],


            ]);

          $result = $response->body();
          if ($result != 1)
          {
              throw new \Exception($result);

          }


    }
}
