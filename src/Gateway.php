<?php

namespace Omnipay\Flo2cash;

use Omnipay\Common\AbstractGateway;
use Omnipay\Flo2cash\Message\AuthorizeRequest;

/**
 * Dummy Gateway
 *
 * This gateway is useful for testing. It simply authorizes any payment made using a valid
 * credit card number and expiry.
 *
 * Any card number which passes the Luhn algorithm and ends in an even number is authorized,
 * for example: 4242424242424242
 *
 * Any card number which passes the Luhn algorithm and ends in an odd number is declined,
 * for example: 4111111111111111
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Flo2cash Payments WS';
    }

    public function getDefaultParameters()
    {
        return array('AccountId' => 'myAccountId',
                     'Username' => 'myUsername',
                     'Password' => 'myPassword',
                     );
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Flo2cash\Message\AuthorizeRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->authorize($parameters);
    }
    
    public function setAccountId($value)
    {
         return $this->setParameter('AccountId', $value);
    }
    
    public function getAccountId()
    {
         return $this->getParameter('AccountId');
    }
    
    public function setUsername($value)
    {
         return $this->setParameter('Username', $value);
    }
    
    public function getUsername()
    {
         return $this->getParameter('Username');
    }
    
    public function setPassword($value)
    {
         return $this->setParameter('Password', $value);
    }
    
    public function getPassword()
    {
         return $this->getParameter('Password');
    }
}
