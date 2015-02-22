<?php

use Mcprohosting\Ccbill\Client\CcbillClient;
use Mcprohosting\Ccbill\Client\Client;
use Mcprohosting\Ccbill\Responses\DynamicPricingResponse;

class DynamicPricingResponseTest extends PHPUnit_Framework_TestCase
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

    public function test_is_invalid_without_code()
    {
        $r = new DynamicPricingResponse($this->client, [
            'subscriptionId' => '123'
        ]);
        $this->assertEquals(false, $r->isValid());
    }

    public function test_is_invalid_with_invalid_code()
    {
        $r = new DynamicPricingResponse($this->client, [
            'subscriptionId' => '123',
            'responseDigest' => 'd41d8cd98f00b204e9800998ecf8427e'
        ]);
        $this->assertEquals(false, $r->isValid());
    }

    public function test_success_valid()
    {
        $r = new DynamicPricingResponse($this->client, [
            'subscriptionId' => '123',
            'responseDigest' => '588cb02e280672000bdd5144b9148182'
        ]);
        $this->assertEquals(true, $r->isValid());
    }

    public function test_error_valid()
    {
        $r = new DynamicPricingResponse($this->client, [
            'subscriptionId' => '123',
            'denialId' => 2,
            'responseDigest' => '7396330c6ba8953e267957e1b1fdc7fe'
        ]);
        $this->assertEquals(true, $r->isValid());
    }
}
