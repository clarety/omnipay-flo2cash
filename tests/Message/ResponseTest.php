<?php

namespace Omnipay\Flo2cash;

use Omnipay\Tests\TestCase;

class ResponseTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = array(
            'amount' => '10.00',
            'card' => $this->getValidCard(),
            'merchantReferenceCode' => 'Testing'
        );
    }
    
    public function testCreateCardSuccess()
    {

        $this->setMockHttpResponse('CreateCardSuccess.txt');
        $response = $this->gateway->createCard($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Flo2cash\Message\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('77719482654', $response->getCardReference());
        $this->assertEquals('Successfully Added Card', $response->getMessage());
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->gateway->purchase($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Flo2cash\Message\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('P1511W0005042864', $response->getTransactionId());
        $this->assertEquals('Transaction Successful', $response->getMessage());
        $txnDetails = $response->getDetailsArray();
        $this->assertEquals('Transaction Successful', $txnDetails['Message']);
    }
    
    public function testPurchaseByTokenSuccess()
    {
        $this->setMockHttpResponse('ProcessPurchaseByTokenSuccess.txt');
        $response = $this->gateway->purchase($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Flo2cash\Message\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('P1511W0005042863', $response->getTransactionId());
        $this->assertEquals('Transaction Successful', $response->getMessage());
    }

    public function testRemoveCardSuccess()
    {
        $this->setMockHttpResponse('RemoveCardSuccess.txt');
        $this->options['cardReference'] = '11111111111';
        $response = $this->gateway->deleteCard($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Flo2cash\Message\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('Successfully Removed Card', $response->getMessage());
    }
    
    public function testRemoveCardFailure()
    {
        $this->setMockHttpResponse('RemoveCardFailure.txt');
        $this->options['cardReference'] = '11111111111';
        $response = $this->gateway->deleteCard($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Flo2cash\Message\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('Card token not found', $response->getMessage());
    }
    
    public function testRefundSuccess()
    {
        $this->setMockHttpResponse('RefundRequestSuccess.txt');
        $this->options['transactionId'] = '11111111111';
        $this->options['amount'] = '10.00';
        $this->options['merchantReferenceCode'] = 'Test';
        $response = $this->gateway->refund($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Flo2cash\Message\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('Refund Successful', $response->getMessage());
    }
}
