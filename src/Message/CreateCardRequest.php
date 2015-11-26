<?php
/**
 * Created by PhpStorm.
 * User: aaron
 * Date: 26/11/2015
 * Time: 10:20 PM
 */

namespace Omnipay\Flo2cash\Message;


class CreateCardRequest extends AbstractRequest
{

    public function getData()
    {
        $this->validate('card');

        $this->getCard()->validate();

        return array('Transaction' => 'AddCard');
    }

    public function sendData($data)
    {
        if (!is_null($this->getCard())) {
            // Process request to add card detail
            $this->request->CardNumber = $this->getCard()->getNumber();
            $this->request->CardExpiry = $this->getCard()->getExpiryDate('dy');
            $this->request->CardType = $this->getCardType();
            $this->request->CardName = $this->getCard()->getName();
        }

        $this->request->purchaseTotals->grandTotalAmount = $this->getAmount();


        return parent::sendData($data);
    }
}