<?php

use Mcprohosting\Ccbill\Client\CcbillClient;
use Mcprohosting\Ccbill\Client\Client;
use Mcprohosting\Ccbill\Forms\DynamicPricingForm;
use Mcprohosting\Ccbill\Forms\Builders\UrlBuilder;
use Mcprohosting\Ccbill\Forms\Builders\InputBuilder;

class BuildersTest extends PHPUnit_Framework_TestCase
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

    public function test_url_builder()
    {
        $this->assertEquals('https://bill.ccbill.com/jpost/signup.cgi?formName=75cc&formPrice=18.00&formPeriod=10&' .
            'currencyCode=840&clientSubacc=456&clientAccnum=123&formDigest=d9d6e044d6663cd05d07e15735205a7f',
            $this->form->build(new UrlBuilder())
        );
    }

    public function test_input_builder()
    {
        $this->assertEquals('<input type="hidden" name="formName" value="75cc">' .
            '<input type="hidden" name="formPrice" value="18.00">' .
            '<input type="hidden" name="formPeriod" value="10">' .
            '<input type="hidden" name="currencyCode" value="840">' .
            '<input type="hidden" name="clientSubacc" value="456">' .
            '<input type="hidden" name="clientAccnum" value="123">' .
            '<input type="hidden" name="formDigest" value="d9d6e044d6663cd05d07e15735205a7f">',
            $this->form->build(new InputBuilder())
        );
    }
}