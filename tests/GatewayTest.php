<?php

namespace Omnipay\Flo2cash;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
	public $gateway = null;
	
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = array(
            'amount' => '10.00',
            'card' => $this->getValidCard(),
        );
    }

	public function testInitializeSuccess()
	{
		$this->assertInstanceOf('\Omnipay\Flo2cash\Gateway', $this->gateway, 'Check gateway is instance of Omnipay\Flo2cash\Gateway');
	}
  /*   public function testAuthorizeSuccess()
    {
        // card numbers ending in even number should be successful
        $this->options['card']['number'] = '4242424242424242';
        $response = $this->gateway->authorize($this->options)->send();

        $this->assertInstanceOf('\Omnipay\Dummy\Message\Response', $response);
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

        $this->assertInstanceOf('\Omnipay\Dummy\Message\Response', $response);
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

        $this->assertInstanceOf('\Omnipay\Dummy\Message\Response', $response);
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

        $this->assertInstanceOf('\Omnipay\Dummy\Message\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotEmpty($response->getTransactionReference());
        $this->assertSame('Failure', $response->getMessage());
    } */
}
