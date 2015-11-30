<?php

namespace Omnipay\Flo2cash\Message;

use SimpleXMLElement;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {

        if (!is_null($this->getCard())) {
            $this->validate(
                'amount',
                'card',
                'merchantReferenceCode'
            );
            $this->getCard()->validate();
            $TransactionType = 'ProcessPurchase';
            $data = new SimpleXMLElement(
                "<$TransactionType></$TransactionType>",
                LIBXML_NOERROR,
                false,
                '',
                true
            );
            $data->addAttribute(
                'xmlns',
                $this->getNamespace()
            );
            $CreditCard = $this->getCard();
            $data->Username = $this->getUsername();
            $data->Password = $this->getPassword();
            $data->AccountId = $this->getAccountId();
            $data->Amount = $this->getAmount();
            $data->Reference = $this->getMerchantReferenceCode();
            $data->Particular = $this->getParticular();
            $data->Email = $this->getEmail();
            $data->CardNumber = $CreditCard->getNumber();
            $data->CardExpiry = $CreditCard->getExpiryDate('my');
            $data->CardType = $this->getCardType();
            $data->CardHolderName = $CreditCard->getName();
            $data->CardCSC = $CreditCard->getCvv();
            $data->StoreCard = $this->getStoreCard();
        } elseif (!is_null($this->getCardReference())) {
            $this->validate(
                'cardReference',
                'amount',
                'merchantReferenceCode'
            );
            $TransactionType = 'ProcessPurchaseByToken';
            $data = new SimpleXMLElement(
                "<$TransactionType></$TransactionType>",
                LIBXML_NOERROR,
                false,
                '',
                true
            );
            $data->addAttribute(
                'xmlns',
                $this->getNamespace()
            );
            $data->Username = $this->getUsername();
            $data->Password = $this->getPassword();
            $data->AccountId = $this->getAccountId();
            $data->Amount = $this->getAmount();
            $data->Reference = $this->getMerchantReferenceCode();
            $data->Particular = $this->getParticular();
            $data->Email = $this->getEmail();
            $data->CardToken = $this->getCardReference();
        }
            return array(
                         'Transaction' => $TransactionType,
                         'Data' => $data
                         );
    }
}
