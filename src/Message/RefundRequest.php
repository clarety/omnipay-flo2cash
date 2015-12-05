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

class RefundRequest extends AbstractRequest
{

    public function getData()
    {
        $this->validate(
            'transactionId',
            'amount',
            'merchantReferenceCode'
        );
        $transactionType = 'ProcessRefund';

        $data = new SimpleXMLElement(
            "<$transactionType></$transactionType>",
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
        $data->OriginalTransactionId = $this->getTransactionId();
        $data->Amount = $this->getAmount();
        $data->Reference = $this->getMerchantReferenceCode();
        $data->Particular = $this->getParticular();
        $data->Email = $this->getEmail();
        return array(
                     'Transaction' => $transactionType,
                     'Data' => $data
                     );
    }
}
