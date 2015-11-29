<?php
/**
 * CreateCardRequest.
 * User: Aaron Guise
 * Date: 26/11/2015
 * Time: 10:20 PM
 */

namespace Omnipay\Flo2cash\Message;

use DOMDocument;
use SimpleXMLElement;

class CreateCardRequest extends AbstractRequest
{

    public function getData()
    {
        $this->validate('card');
        $this->getCard()->validate();
        $TransactionType = 'AddCard';

        $CreditCard = $this->getCard();

        $data = new SimpleXMLElement(
            "<$TransactionType></$TransactionType>",
            LIBXML_NOERROR,
            false,
            '',
            true
        );
        $data->addAttribute(
            'xmlns',
            'http://www.flo2cash.co.nz/webservices/paymentwebservice'
        );
        $data->Username = $this->getUsername();
        $data->Password = $this->getPassword();
        $data->CardNumber = $CreditCard->getNumber();
        $data->CardExpiry = $CreditCard->getExpiryDate('my');
        $data->CardType = $this->getCardType();
        $data->CardName = $CreditCard->getName();
        return array(
                     'Transaction' => $TransactionType,
                     'Data' => $data
                     );
    }
}
