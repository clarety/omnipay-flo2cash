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
        );
    }
    
    public function testCreateCardSuccess()
    {
        $this->setMockHttpResponse('CreateCardSuccess.txt');
        $response = $this->gateway->createCard($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Flo2cash\Message\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('77719482654', $response->getCardReference());
        $this->assertEquals('Success', $response->getMessage());
    }
    //public function testSuccess()
    //{
    //    $response = new Response(
    //        $this->getMockRequest(),
    //        array('reference' => 'abc123', 'success' => 1, 'message' => 'Success')
    //    );
    //
    //    $this->assertTrue($response->isSuccessful());
    //    $this->assertFalse($response->isRedirect());
    //    $this->assertSame('abc123', $response->getTransactionReference());
    //    $this->assertSame('Success', $response->getMessage());
    //}
    //
    //public function testFailure()
    //{
    //    $response = new Response(
    //        $this->getMockRequest(),
    //        array('reference' => 'abc123', 'success' => 0, 'message' => 'Failure')
    //    );
    //
    //    $this->assertFalse($response->isSuccessful());
    //    $this->assertFalse($response->isRedirect());
    //    $this->assertSame('abc123', $response->getTransactionReference());
    //    $this->assertSame('Failure', $response->getMessage());
    //}
}
