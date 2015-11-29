<?php
/**
 * Created by PhpStorm.
 * User: aaron
 * Date: 26/11/2015
 * Time: 10:21 PM
 */

namespace Omnipay\Flo2cash\Message;

use DOMDocument;
use SimpleXMLElement;

class DeleteCardRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('cardReference');
        $TransactionType = 'RemoveCard';


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
        $data->CardToken = $this->getCardReference();
        return array(
                     'Transaction' => $TransactionType,
                     'Data' => $data
                     );
    }
}
