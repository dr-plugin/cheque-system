<?php

namespace App\Services\Pay\Abstract;

use App\Services\Pay\Interface\PayInterface;
use Illuminate\Support\Facades\Http;

abstract class PayGatewayAbstract implements PayInterface
{
    public $username;
    public $terminal;
    public $password;
    public $success_massage;
    public $cancelled_massage;

    public $request;

    public function __construct() {}


    protected function sendRequest()
    {
        // $this->request = Http::withoutVerifying()->withHeaders([
        //     'Authorization' => "Bearer $this->zohalToken",
        //     'Content-Type' => 'application/json',
        // ])->post($this->getApiUrl(), $this->data);

        return json_decode($this->request->body(), true);
    }
}
