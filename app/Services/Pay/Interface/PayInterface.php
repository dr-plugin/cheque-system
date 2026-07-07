<?php

namespace App\Services\Pay\Interface;

interface PayInterface
{
    public function generatePayUrl(int $transactionId, int $amount): false|string;
    public function handleGatewayAnswer(): bool;
    // public function getPaymentId(): string;
    // public function getPaymentForm(): string;
}
