<?php

use Mcprohosting\Ccbill\Client\CcbillClient;
use Mcprohosting\Ccbill\Client\Client;
use Mcprohosting\Ccbill\Forms\DynamicPricingForm;

class DynamicPricingFormTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var DynamicPricingForm
     */
    private $form;

    public function setUp()
    {
        $this->client = new CcbillClient();
        $this->client->setClient([ 'accnum' => '123', 'subacc' => '456', 'salt' => '789' ]);
        $this->form = new DynamicPricingForm($this->client, [
            'formName' => '75cc',
            'formPrice' => '18.00',
            'formPeriod' => 10,
            'currencyCode' => 840
        ]);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function test_recurring()
    {
        $this->assertEquals(false, $this->form->isRecurring());
        $this->form->set('formRebills', 1);
        $this->assertEquals(true, $this->form->isRecurring());
    }

    public function test_gets_nonrecurring()
    {
        $this->assertEquals([
            'clientAccnum' => '123',
            'clientSubacc' => '456',
            'formName' => '75cc',
            'formPrice' => '18.00',
            'formPeriod' => 10,
            'currencyCode' => 840,
            'formDigest' => 'd9d6e044d6663cd05d07e15735205a7f'
        ], $this->form->serialize());
    }

    public function test_gets_recurring()
    {
        $this->form->set([
            'formRecurringPrice' => '25.00',
            'formRecurringPeriod' => 30,
            'formRebills' => 1
        ]);

        $this->assertEquals([
            'clientAccnum' => '123',
            'clientSubacc' => '456',
            'formName' => '75cc',
            'formPrice' => '18.00',
            'formPeriod' => 10,
            'currencyCode' => 840,
            'formRecurringPrice' => '25.00',
            'formRecurringPeriod' => 30,
            'formRebills' => 1,
            'formDigest' => 'c72e144a9b1136c5851413a2fe6d46d4'
        ], $this->form->serialize());
    }

    public function test_builds()
    {
        $m = Mockery::mock('Mcprohosting\Ccbill\Forms\Builders\Builder');
        $m->shouldReceive('build')->with($this->client, $this->form)->andReturn('foo');
        $this->assertEquals('foo', $this->form->build($m));
    }
}