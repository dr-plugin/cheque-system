<?php

namespace App\Actions;

use App\Enums\TransStatus;
use App\Enums\TransType;
use App\Models\InquiryRequest;
use App\Models\Transaction;
use App\Models\User;

class InquiryRequestAction
{
    public function execute(User $user, $inquiryId, int $price, $resultData, array $payloadData)
    {
        # Update Wallet balance
        $user->updateWallet($price, 'des');

        InquiryRequest::create([
            'user_id'         => $user->id,
            'inquiry_id'      => $inquiryId,
            'price'           => $price,
            'request_payload' => json_encode($payloadData),
            'response_status' => 200,
            'response_body'   => json_encode($resultData),
            'error_message'   => null,
        ]);

        Transaction::create(
            [
                'user_id'   => $user->id,
                'type'      => TransType::InquiryFee->value,
                'desc'      => 'استعلام',
                'amount'    => $price,
                'status'    => TransStatus::Paid->value
            ],
        );
    }
}
