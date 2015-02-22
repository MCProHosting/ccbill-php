<?php

use Mcprohosting\Ccbill\Client\CcbillClient;
use Mcprohosting\Ccbill\Client\Client;

class ClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        $this->client = new CcbillClient();
        $this->client->setClient([ 'accnum' => '123', 'subacc' => '456', 'salt' => '789' ]);
    }

    public function test_getters()
    {
        $this->assertEquals([ 'accnum' => '123', 'subacc' => '456', 'salt' => '789' ], $this->client->getClient());
        $this->assertEquals('123', $this->client->getAccNumber());
        $this->assertEquals('456', $this->client->getSubAccNumber());
        $this->assertEquals('789', $this->client->getSalt());
    }

    public function test_base_url()
    {
        $this->client->setBaseUrl('https://mcprohosting.com');
        $this->assertEquals('https://mcprohosting.com/foo/bar', $this->client->buildUrl('/foo/bar'));
        $this->assertEquals('https://mcprohosting.com/foo/bar', $this->client->buildUrl('foo/bar'));
        $this->client->setBaseUrl('https://mcprohosting.com/');
        $this->assertEquals('https://mcprohosting.com/foo/bar', $this->client->buildUrl('/foo/bar'));
        $this->assertEquals('https://mcprohosting.com/foo/bar', $this->client->buildUrl('foo/bar'));
    }
}
