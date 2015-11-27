<?php
/**
 * Created by PhpStorm.
 * User: aaron
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
        
        $CreditCard = $this->getCard();
        
        $data = new SimpleXMLElement("<AddCard></AddCard>" , LIBXML_NOERROR, false, '', true);
        $data->addAttribute('xmlns', 'http://www.flo2cash.co.nz/webservices/paymentwebservice');
        $data->Username = $this->getUsername();
        $data->Password = $this->getPassword();
        $data->CardNumber = $CreditCard->getNumber();
        $data->CardExpiry = $CreditCard->getExpiryDate('dy');
        $data->CardType = $this->getCardType();
        $data->CardName = $CreditCard->getName();
        return array('Transaction' => 'AddCard', 'Data' => $data);
    }

    public function sendData($data)
    {
        $TransactionType = $data['Transaction'];
        $Data = $data['Data'];
        
        $document = new DOMDocument('1.0', 'UTF-8');
        $envelope = $document->appendChild(
        $document->createElementNS('http://schemas.xmlsoap.org/soap/envelope/', 'soap:Envelope')
        );
        $envelope->setAttribute('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema-instance');
        $envelope->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema');
        $body = $envelope->appendChild($document->createElement('soap:Body'));
        $body->appendChild($document->importNode(dom_import_simplexml($data), true));
        $document->preserveWhiteSpace = false;
        $document->formatOutput = true
        
        $xml = $document->saveXML();
        $xml = trim($xml);

        $headers = array(
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => $this->getNamespace() . '/' . $TransactionType);
            
        $httpRequest = $this->httpClient->post($this->getEndpoint(), 
                                               $headers, 
                                               $xml
                                               );
        $httpResponse = $httpRequest->send();
        return $this->response = new Response($this, $httpResponse->getBody());
    
    }
}
