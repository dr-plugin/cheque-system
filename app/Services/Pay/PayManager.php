<?php

namespace App\Services\Pay;

use App\Services\Pay\Abstract\PayGatewayAbstract;
use App\Services\Pay\Gateway\RefahGateway;

class PayManager
{
    protected PayGatewayAbstract $payGateway;

    public function __construct()
    {
        // $defaultGateway = config("sms.gateways.$defaultGateway");
        // $class = $defaultGateway['class'];

        $this->payGateway = new RefahGateway();
    }

    /**
     * Generate pay url for user
     * 
     * @param int $transId
     * @param int $amount
     */
    public function generatePayUrl($transId, $amount)
    {
        return $this->payGateway->generatePayUrl($transId, $amount);
    }
}
