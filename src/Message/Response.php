<?php

namespace Omnipay\Flo2cash\Message;

use Omnipay\Common\Message\AbstractResponse;
use SimpleXMLElement;

/**
 * Flo2cash Response
 */
class Response extends AbstractResponse
{
    private $status = false;
    private $cardReference;
    private $message;
    private $xml; /* Response XML from Gateway */


    /**
     * Constructor
     *
     * @param $request the initiating request.
     * @param mixed $data
     */
    public function __construct($request, $data)
    {
        $this->request = $request;
        $this->response = $data;
        $this->processResponse($this->response);
    }

    /**
     * Response Processor
     * Take response from the gateway and give result
     *
     * @param mixed $data
     */
    public function processResponse($data)
    {
        /* Strip soap:Body tags so can be parsed
         * by SimpleXMLElement
         *
         */
        $replacements = array('<soap:Body>','</soap:Body>');
        $data = str_replace($replacements,'',$data);
        $xml = new SimpleXMLElement($data);
        /*
         *  Data from the request can now be processed.
         */
        if (isset($xml->AddCardResponse)){
            # Response from AddCard returned
            $response = (array) $xml->AddCardResponse; # Cast the result as array
            if (isset($response['AddCardResult'])
                && strlen($response['AddCardResult']) > 0)
            {
                $this->status = "true";
                $this->cardReference = $response['AddCardResult'];
                $this->message = 'Success';
            }

        }
        elseif (isset($xml->RemoveCardResponse))
        {
            # Response from RemoveCard returned
            $response = (array) $xml->RemoveCardResponse; # Cast the result as array
            if (isset($response['RemoveCardResult']))
            {
                $this->status = "true";
                $this->message = 'Success';
            }
        }
        elseif (isset($data->ProcessPurchaseResponse)
                or isset($data->ProcessPurchaseByTokenResponse))
        {
            # Response from ProcessPurchase returned
            $xml = (array)isset($data->ProcessPurchaseResponse) ?
                                $data->ProcessPurchaseResponse->transactionresult :
                                $data->ProcessPurchaseByTokenResponse->transactionresult;
            # SOAP response is identical between two types so we can process alike.
            $this->message = $xml['Message'];
            if ($xml['Status'] == 'SUCCESSFUL')
            {
                $this->status = "true";
            }
        }
        elseif (isset($data->ProcessRefundResponse))
        {
            # Response from ProcessRefund returned
            $xml_array = (array) $data->ProcessRefundResponse;
        }
    }

    /**
     *
     * Return whether the response is successful or not
     *
     * @returns bool $status
     */
    public function isSuccessful()
    {
        return isset($this->status) && $this->status;
    }
    /**
     *
     * Return the transaction reference from the gateway
     *
     * @returns string $transactionReference
     */
    public function getTransactionReference()
    {
        return isset($this->response['TransactionId']) ? $this->response['TransactionId'] : null;
    }
    /**
     *
     * Return the message from the gateway
     *
     * @returns string $gatewayMessage
     */
    public function getMessage()
    {
        return isset($this->response['Message']) ?
               $this->response['Message'] : $this->message;
    }
    /**
     *
     * Return the card reference (token) from the gateway
     *
     * @returns string $cardReference
     */
    public function getCardReference()
    {
        $data = $this->data;
        return isset($this->cardReference) &&
                     strlen($this->cardReference)
                     ? $this->cardReference
                     : null;
    }
}
