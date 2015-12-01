<?php

namespace Omnipay\Flo2cash\Message;

use Omnipay\Tests\TestCase;
use SimpleXMLElement;

class CreateCardRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new CreateCardRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testGetData()
    {
        $card = $this->getValidCard();
        $this->request->initialize(array(
            'card' => $card,
        ));
        $response = $this->request->getData();
        $this->assertSame($this->request->getNamespace(), 'http://www.flo2cash.co.nz/webservices/paymentwebservice');
        $this->assertEquals('AddCard', (string) $response['Transaction']);
        $this->assertArrayHasKey('Transaction', $response);
        $this->assertArrayHasKey('Data', $response);
    }
}
