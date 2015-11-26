<?php

namespace Omnipay\Flo2cash\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Dummy Authorize Request
 */
class AuthorizeRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'card');

        $this->getCard()->validate();

        return array('amount' => $this->getAmount());
    }

    public function sendData($data)
    {
        $data['reference'] = uniqid();
        $data['success'] = 0 === substr($this->getCard()->getNumber(), -1, 1) % 2;
        $data['message'] = $data['success'] ? 'Success' : 'Failure';

        return $this->response = new Response($this, $data);
    }
	public function setAccountId($value){
		 return $this->setParameter('AccountId', $value);
	}	
	public function getAccountId(){
		 return $this->getParameter('AccountId', $value);
	}	
	public function setUsername($value){
		 return $this->setParameter('Username', $value);
	}	
	public function getUsername(){
		 return $this->getParameter('Username', $value);
	}	
	public function setPassword($value){
		 return $this->setParameter('Password', $value);
	}	
	public function getPassword(){
		 return $this->getParameter('Password', $value);
	}
}
