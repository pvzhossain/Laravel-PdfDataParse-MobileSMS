<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Nexmo\Laravel\Facade\Nexmo;

use Vonage\Client\Credentials\Basic;

class smsController extends Controller
{
    public function sendMessage(){
        $basic  = new \Nexmo\Client\Credentials\Basic('26c144cc', 'Y7WVbukqkkfcAiRG');
        $client = new \Nexmo\Client($basic);

        $message = $client->message()->send([
            'to' => '8801772880239',
            'from' => 'Deshi Fruits',
            'text' => 'Hi, Mr. Parvez Hossain. Please Follow Us On Facebook "Deshi Fruits" '
        ]);
    }
}
