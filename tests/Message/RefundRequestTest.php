<?php

namespace Omnipay\Flo2cash\Message;

use Omnipay\Tests\TestCase;
use SimpleXMLElement;

class RefundRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testGetData()
    {
        $this->request->initialize(array(
            'transactionId' => '111111111111',
            'merchantReferenceCode' => 'Test Suite',
            'amount' => 10.00
        ));
        $response = $this->request->getData();
        $data = $response['Data'];
        $this->assertSame($this->request->getNamespace(), 'http://www.flo2cash.co.nz/webservices/paymentwebservice');
        $this->assertEquals('ProcessRefund', (string) $response['Transaction']);
        $this->assertEquals('Test Suite', (string) $data->{'Reference'});
        $this->assertEquals('111111111111', (string) $data->{'OriginalTransactionId'});
        $this->assertEquals('10.00', (string) $data->{'Amount'});
        $this->assertArrayHasKey('Transaction', $response );
        $this->assertArrayHasKey('Data', $response );
    }

}
