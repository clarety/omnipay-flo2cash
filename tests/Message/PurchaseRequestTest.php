<?php

namespace Omnipay\Flo2cash\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'amount' => '10.00',
            'merchantReferenceCode' => 'TestSuite'
        ));
    }

    public function testGetData()
    {
        $this->request->data['card'] = $this->getValidCard();
        $data = $this->request->getData();
        $this->assertSame('10.00', $data['amount']);
        $this->assertSame('TestSuite', $data['merchantReferenceCode']);
    }
    
    public function testGetDataToken()
    {
        $this->request->data['cardReference'] = '11111111';
        $data = $this->request->getData();
        $this->assertSame('10.00', $data['amount']);
        $this->assertSame('TestSuite', $data['merchantReferenceCode']);
        $this->assertSame('11111111', $data['cardReference']);
    }
}
