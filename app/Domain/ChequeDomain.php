<?php

namespace App\Domain;

use App\Domain\ValueObjects\Bank;
use App\Domain\ValueObjects\ChequeStatus;

/**
 * Domain cheque
 */
class ChequeDomain
{
    // Cheque details
    private string $_date;
    private string $_price;
    private string $_sayadi_number;
    private string $_exporter;
    private string $_comment;
    private string $_bank;
    private string $_img_url;

    // Cheque status
    private string $_status; //in_cartable, moved, backed, 

    // Cheque type
    private string $_type; //paper, digital

    private ClientDomain $_owner_client;

    public function __construct(
        string $price,
        string $sayadiNumber,
        string $exporter,
        Bank $bank,
        ClientDomain $payerClient
    ) {
        $this->_price = $price;
        $this->_sayadi_number = $sayadiNumber;
        $this->_exporter = $exporter;
        $this->_bank = $bank->value;
        $this->_owner_client = $payerClient;
    }

    public function updateOwner(ClientDomain $client): void
    {
        $this->_owner_client = $client;
    }

    public function updateStatus(ChequeStatus $status)
    {
        $this->_status = $status->value;
    }

    public function getOwner(): ClientDomain
    {
        return $this->_owner_client;
    }
}
