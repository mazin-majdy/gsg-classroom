<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HadaraSms
{

    protected $baseUrl = 'http://smsservice.hadara.ps:4545/SMS.ashx/bulkservice/sessionvalue';

    protected $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function send($to, $message)
    {
        $response = Http::baseUrl($this->baseUrl)
            // ->withHeaders([
            //     'x-api-key' => $this->key,
            //     'Authorization' => 'Bearer' . $this->key,  // same for ->withToken()
            // ])
            // ->withToken($this->key)
            ->get('sendmessage', [
                'apikey' => $this->key,
                'to' => '$to',
                'msg' => $message
            ]);

        $json = $response->json();
        // $json = $response->body();
        dd($json);
    }
}
