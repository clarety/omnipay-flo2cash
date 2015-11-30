<?php

namespace Omnipay\Flo2cash;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
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

    public function testSupportsAuthorize()
    {
        $this->assertFalse($this->gateway->supportsAuthorize());
    }

    public function testSupportsCompleteAuthorize()
    {
        $this->assertFalse($this->gateway->supportsCompleteAuthorize());
    }

    public function testSupportsCapture()
    {
        $this->assertFalse($this->gateway->supportsCapture());
    }

    public function testSupportsPurchase()
    {
        $this->assertTrue($this->gateway->supportsPurchase());
    }

    public function testSupportsCompletePurchase()
    {
        $this->assertFalse($this->gateway->supportsCompletePurchase());
    }

    public function testSupportsRefund()
    {
        $this->assertTrue($this->gateway->supportsRefund());
    }

    public function testSupportsVoid()
    {
        $this->assertFalse($this->gateway->supportsVoid());
    }

    public function testSupportsCreateCard()
    {
        $this->assertTrue($this->gateway->supportsCreateCard());
    }

    public function testSupportsDeleteCard()
    {
        $this->assertTrue($this->gateway->supportsDeleteCard());
    }

    public function testSupportsUpdateCard()
    {
        $this->assertFalse($this->gateway->supportsUpdateCard());
    }

    public function testSupportsAcceptNotification()
    {
        $this->assertFalse($this->gateway->supportsAcceptNotification());
    }

/*    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('TwoPartyPurchaseSuccess.txt');
        $response = $this->gateway->purchase($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Flo2cash\Message\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('12345', $response->getTransactionReference());
        $this->assertSame('Approved', $response->getMessage());
    }
    public function testPurchaseFailure()
    {
        $this->setMockHttpResponse('TwoPartyPurchaseFailure.txt');
        $response = $this->gateway->purchase($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Flo2cash\Message\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('12345', $response->getTransactionReference());
        $this->assertEquals('Declined', $response->getMessage());
    }*/

/*    public function testAuthorizeSuccess()
    {
        // card numbers ending in even number should be successful
        $this->options['card']['number'] = '4242424242424242';
        $response = $this->gateway->authorize($this->options)->send();

        $this->assertInstanceOf('\Omnipay\Flo2cash\Message\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotEmpty($response->getTransactionReference());
        $this->assertSame('Success', $response->getMessage());
    }

    public function testAuthorizeFailure()
    {
        // card numbers ending in odd number should be declined
        $this->options['card']['number'] = '4111111111111111';
        $response = $this->gateway->authorize($this->options)->send();

        $this->assertInstanceOf('\Omnipay\Flo2cash\Message\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotEmpty($response->getTransactionReference());
        $this->assertSame('Failure', $response->getMessage());
    }

    public function testPurchaseSuccess()
    {
        // card numbers ending in even number should be successful
        $this->options['card']['number'] = '4242424242424242';
        $response = $this->gateway->purchase($this->options)->send();

        $this->assertInstanceOf('\Omnipay\Flo2cash\Message\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotEmpty($response->getTransactionReference());
        $this->assertSame('Success', $response->getMessage());
    }

    public function testPurcahseFailure()
    {
        // card numbers ending in odd number should be declined
        $this->options['card']['number'] = '4111111111111111';
        $response = $this->gateway->purchase($this->options)->send();

        $this->assertInstanceOf('\Omnipay\Flo2cash\Message\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotEmpty($response->getTransactionReference());
        $this->assertSame('Failure', $response->getMessage());
    }*/
}
