<?php

namespace App\Services\Pay\Gateway;

use App\Enums\UserRoute;
use App\Services\Pay\Abstract\PayGatewayAbstract;
use Illuminate\Support\Facades\Http;

class RefahGateway extends PayGatewayAbstract
{
    private $purchaseUrl = 'https://pna.shaparak.ir/refipg/api/purchase';
    private $paymentUrl = 'https://pna.shaparak.ir/refui?token=';

    public $terminalNumber = 45512;

    public function __construct()
    {
        $this->username = env("REFAH_USER_NAME");
        $this->password = env("REFAH_PASSWORD");
        $this->terminalNumber = env("REFAH_TERMINAL_NUMBER");
    }

    public function getPayForm(): string
    {
        return '<form action="" method="POST" class="Refah-checkout-form" id="Refah-checkout-form">
					<input type="submit" name="refah_submit" class="button alt" id="refah-payment-button" value="پرداخت"/>
					<a class="button cancel" href="' . '$woocommerce->cart->get_checkout_url()' . '">2بازگشت</a>
				</form>';
    }

    protected function getRefahToken(int $transactionId, int $amount): false|string
    {
        $data = array(
            "userName" => $this->username,
            "password" => $this->password,
            "terminalNumber" => $this->terminalNumber,
            "amount" => $amount,
            "orderId" => date('ymdHis'),
            "callBack" => UserRoute::getFullUrl(UserRoute::PayCallback) . http_build_query(['transactionid', $transactionId])
        );

        $request = Http::withoutVerifying()
            ->withHeaders(
                [
                    'Content-Type' => 'application/json',
                    'Cookie' => 'cookiesession1=678B28A8A9990742D7412CE00BD0687F'
                ],
            )->post($this->purchaseUrl, $data);

        $response = $request->object();

        if (!($response->success ?? false)) {
            logger()->error('refah: ' . $response->errors[0]->message);
            return false;
        }

        return $response->data->token;
    }

    public function handleGatewayAnswer(): bool
    {
        return true;
    }

    public function generatePayUrl(int $transactionId, int $amount): false|string
    {
        $token = $this->getRefahToken($transactionId, $amount);

        if (!$token)
            return false;

        return $this->paymentUrl . urlencode($token);
    }
}
