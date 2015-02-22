<?php

namespace Mcprohosting\Ccbill;

use Exception;

class CurrencyCode
{
    /**
     * @var array mapping of human-readable codes to numeric currency codes
     *            as defined in ccbill's wiki.
     */
    public static $mapping = [
        'AUD' => '036',
        'CAD' => '124',
        'JPY' => '392',
        'GBP' => '826',
        'USD' => '840',
        'EUR' => '978'
    ];

    /**
     * @var string currency code
     */
    protected $code;

    function __construct($code)
    {
        if (is_numeric($code)) {
            $this->code = $code;
        } elseif (array_key_exists($code, $this::$mapping)) {
            $this->code = $this::$mapping[$code];
        } else {
            throw new Exception('Unknown currency code "' . $code . '"');
        }
    }

    public function __toString()
    {
        return $this->code;
    }

    /**
     * Helper function to create a new currency code.
     *
     * @param $code string
     * @return CurrencyCode
     */
    public static function from($code)
    {
        return new self($code);
    }
}