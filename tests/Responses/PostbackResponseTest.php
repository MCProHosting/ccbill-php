<?php

use Mcprohosting\Ccbill\Client\CcbillClient;
use Mcprohosting\Ccbill\Client\Client;
use Mcprohosting\Ccbill\Responses\PostbackResponse;

class PostbackResponseTest extends PHPUnit_Framework_TestCase
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
        $r = new PostbackResponse($this->client, [ 'a' => 'b' ]);
        $this->assertEquals('b', $r->get('a'));
        $this->assertEquals(null, $r->get('c'));
    }

    public function test_status_when_successful()
    {
        $r = new PostbackResponse($this->client, []);
        $this->assertEquals(true, $r->isSuccessful());
        $this->assertEquals(false, $r->isFailed());
        $this->assertEquals(true, $r->isValid());
    }

    public function test_status_when_failed()
    {
        $r = new PostbackResponse($this->client, [ 'denialId' => 2 ]);
        $this->assertEquals(false, $r->isSuccessful());
        $this->assertEquals(true, $r->isFailed());
        $this->assertEquals(true, $r->isValid());
    }
}
