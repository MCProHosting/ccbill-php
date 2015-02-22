<?php

use Mcprohosting\Ccbill\CurrencyCode;

class CurrencyCodeTest extends PHPUnit_Framework_TestCase
{
    public function test_takes_common_name()
    {
        $this->assertEquals('840', (new CurrencyCode('USD'))->__toString());
    }

    public function test_takes_numeric()
    {
        $this->assertEquals('840', (new CurrencyCode('840'))->__toString());
    }

    public function test_throws_error_on_unknown()
    {
        $this->setExpectedException('Exception', 'Unknown currency code "foo"');
        new CurrencyCode('foo');
    }

    public function test_static_helper()
    {
        $this->assertEquals('840', CurrencyCode::from('USD')->__toString());
    }
}
