<?php

namespace App\Services\Sms\Gateway;

use App\Services\Sms\Abstract\SmsGatewayAbstract;
use App\Services\Sms\Contracts\SmsGateway;

class RayganSms extends SmsGatewayAbstract implements SmsGateway
{

    public function sendSms($number, $text): bool
    {
        return false;
    }

    public function sendSmsByPattern($number, $text): bool
    {
        $curlObject = curl_init();

        curl_setopt($curlObject, CURLOPT_URL, $this->getApiUrl());
        curl_setopt($curlObject, CURLOPT_POST, 1);

        curl_setopt(
            $curlObject,
            CURLOPT_POSTFIELDS,
            http_build_query($this->getDataForsend($number, $code))
        );

        curl_setopt($curlObject, CURLOPT_RETURNTRANSFER, true);
        $result = (int) curl_exec($curlObject);
        curl_close($curlObject);

        if ($result > 2000) {
            return true;
        }

        return false;
    }

    private function getApiUrl()
    {
        return 'https://smspanel.trez.ir/SendPatternCodeWithUrl.ashx';
    }

    private function getDataForsend(&$number, &$code)
    {
        //password use intead of pattern
        $accessToken = '6a5db8b4-d7df-45d0-92c8-abc8d806145f';
        $patternId =  '28730d71-d10f-4d81-b307-815cad747488';

        $dataForSend['token1'] = $code;

        return array_merge(array(
            'AccessHash' => $accessToken,
            'Mobile' => $number,
            'PatternId' => $patternId,
        ), $dataForSend);
    }
}
