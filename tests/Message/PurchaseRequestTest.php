<?php

namespace Omnipay\Flo2cash\Message;

use Omnipay\Tests\TestCase;
use SimpleXMLElement;

class PurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testGetData()
    {
        $this->request->initialize(array(
            'amount' => '10.00',
            'merchantReferenceCode' => 'TestSuite',
            'Particular' => 'Testing',
            'storeCard' => 'false',
            'card' => $this->getValidCard(),
        ));
        $response = $this->request->getData();
        $data = $response['Data'];
        $this->assertSame($this->request->getNamespace(), 'http://www.flo2cash.co.nz/webservices/paymentwebservice');
        $this->assertSame('10.00', (string) $data->{'Amount'});
        $this->assertSame('TestSuite', (string) $data->{'Reference'});
        $this->assertSame('Testing', (string) $data->{'Particular'});
        $this->assertEquals('ProcessPurchase', (string) $response['Transaction']);
        $this->assertArrayHasKey('Transaction', $response );
        $this->assertArrayHasKey('Data', $response );
    }
    
    public function testGetDataToken()
    {
        $this->request->initialize(array(
            'amount' => '10.00',
            'merchantReferenceCode' => 'TestSuite',
            'cardReference' => '11111111',
        ));
        $response = $this->request->getData();
        $data = $response['Data'];
        $this->assertSame($this->request->getNamespace(), 'http://www.flo2cash.co.nz/webservices/paymentwebservice');
        $this->assertSame('10.00', (string) $data->Amount);
        $this->assertSame('TestSuite', (string) $data->Reference);
        $this->assertSame('11111111', (string) $data->CardToken);
        $this->assertEquals('ProcessPurchaseByToken', (string) $response['Transaction']);

    }
}
