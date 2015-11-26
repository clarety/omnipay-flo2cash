<?php

namespace Omnipay\Flo2cash\Message;

use DOMDocument;
use Guzzle\Http\ClientInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use SimpleXMLElement;

use Omnipay\Flo2cash;

/**
 * Flo2cash Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $namespace = "http://ics2ws.com/";

    const LIVE_ENDPOINT = 'https://demo.flo2cash.co.nz/ws/paymentws.asmx?wsdl';
    const TEST_ENDPOINT = 'https://demo.flo2cash.co.nz/ws/paymentws.asmx?wsdl';

    const VERSION = '0.1';

    /**
     * @var \stdClass The generated SOAP request, saved immediately before a transaction is run.
     */
    protected $request;

    /**
     * @var \stdClass The retrieved SOAP response, saved immediately after a transaction is run.
     */
    protected $response;

    /**
     * @var float The amount of time in seconds to wait for both a connection and a response.
     * Total potential wait time is this value times 2 (connection + response).
     */
    public $timeout = 10;


    /**
     * Create a new Request
     *
     * @param ClientInterface $httpClient  A Guzzle client to make API calls with
     * @param HttpRequest     $httpRequest A Symfony HTTP request object
     */
    public function __construct(ClientInterface $httpClient, HttpRequest $httpRequest)
    {
        parent::__construct($httpClient, $httpRequest);
        $this->request = new \stdClass();
    }


    #region Flo2cash Soap Transaction

    public function sendData($data)
    {
        $data = $this->getData();

        $this->request->Reference = $this->getReference();
        $this->request->AccountId = $this->getAccountId();
        $this->request->Username = $this->getUsername();
        $this->request->Password = $this->getPassword();

        $context_options = array(
            'http' => array(
                'timeout' => $this->timeout,
            ),
        );

        $context = stream_context_create($context_options);

        // options we pass into the soap client
        $soap_options = array(
            'compression' => SOAP_COMPRESSION_ACCEPT |
                             SOAP_COMPRESSION_GZIP |
                             SOAP_COMPRESSION_DEFLATE,  // turn on HTTP compression
            'encoding' => 'utf-8',        // set the internal character encoding to avoid random conversions
            'exceptions' => true,        // throw SoapFault exceptions when there is an error
            'connection_timeout' => $this->timeout,
            'stream_context' => $context,
        );

        // if we're in test mode, don't cache the wsdl
        if ($this->getTestMode()) {
            $soap_options['cache_wsdl'] = WSDL_CACHE_NONE;
        } else {
            $soap_options['cache_wsdl'] = WSDL_CACHE_BOTH;
        }


        try {
            // create the soap client
            $soap = new \SoapClient($this->getEndpoint(), $soap_options);
        } catch (SoapFault $sf) {
            throw new \Exception($sf->getMessage(), $sf->getCode());
        }

        // save the request so you can get back what was generated at any point
        $response = $soap->$data['Transaction']($this->request);

        return $this->response = new Response($this->request, $response);
    }


    /**
     * @return \stdClass
     */
    protected function createCard()
    {
        /** @var \Omnipay\Common\CreditCard $creditCard */
        $creditCard = $this->getCard();

        $cyberSourceCreditCard = new \stdClass();
        $cyberSourceCreditCard->accountNumber = $creditCard->getNumber();
        $cyberSourceCreditCard->expirationMonth = $creditCard->getExpiryMonth();
        $cyberSourceCreditCard->expirationYear = $creditCard->getExpiryYear();

        if (!is_null($creditCard->getCvv())) {
            $cyberSourceCreditCard->cvNumber = $creditCard->getCvv();
        }

        if (!is_null($this->getCardType())) {
            $cyberSourceCreditCard->cardType = $this->getCardType();
        }

        return $cyberSourceCreditCard;
    }

    #region CyberSource Parameters

    /**
     * @param string $merchantId
     */
    public function setMerchantId($merchantId)
    {
        $this->setParameter('merchantId', $merchantId);
    }

    /**
     * return string
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->setParameter('username', $username);
    }

    /**
     * return string
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->setParameter('password', $password);
    }

    /**
     * return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * @param string $transactionKey
     */
    public function setTransactionKey($transactionKey)
    {
        $this->setParameter('transactionKey', $transactionKey);
    }

    /**
     * return string
     */
    public function getTransactionKey()
    {
        return $this->getParameter('transactionKey');
    }

    /**
     * @param BankAccount $bankAccount
     */
    public function setBankAccount($bankAccount)
    {
        $this->setParameter('bankAccount', $bankAccount);
    }

    /**
     * return BankAccount
     */
    public function getBankAccount()
    {
        return $this->getParameter('bankAccount');
    }

    /**
     * The reference number that we set on the Klinche side.
     *
     * @param string $merchantReferenceCode
     */
    public function setMerchantReferenceCode($merchantReferenceCode)
    {
        $this->setParameter('merchantReferenceCode', $merchantReferenceCode);
    }

    /**
     * return string
     */
    public function getMerchantReferenceCode()
    {
        return $this->getParameter('merchantReferenceCode');
    }


    #endregion


    #region Omnipay Stuff

    public function getEndpoint()
    {
        return $this->getTestMode() ? self::TEST_ENDPOINT : self::LIVE_ENDPOINT;
    }

    public function getCardTypes()
    {
        return array(
            'visa' => '001',
            'mastercard' => '002',
            'amex' => '003',
            'discover' => '004',
            'diners_club' => '005',
            'carte_blanche' => '006',
            'jcb' => '007',
        );
    }

    public function getCardType()
    {
        $types = $this->getCardTypes();
        $brand = $this->getCard()->getBrand();
        return empty($types[$brand]) ? null : $types[$brand];
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? self::TEST_ENDPOINT : self::LIVE_ENDPOINT;
    }
    #endregion
}
