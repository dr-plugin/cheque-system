<?php

namespace App\Domain;

class ChequeLogsDomain
{

    private ChequeDomain $_cheque;
    private ClientDomain $_payer_client;
    private ClientDomain $_receiver_client;

    public function addLog(ChequeDomain $cheque, ClientDomain $payer, ClientDomain $receiver): void
    {
        if ($cheque->getOwner()->id !== $payer->id)
            throw new \InvalidArgumentException("He is not owner of this cheque");

        $cheque->updateOwner($payer);

        $this->_payer_client = $payer;
        $this->_receiver_client = $receiver;
    }
}
