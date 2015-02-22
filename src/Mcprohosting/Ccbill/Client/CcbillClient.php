<?php

namespace Mcprohosting\Ccbill\Client;

class CcbillClient implements Client
{
    /**
     * @var string the base url fo the ccbill gateway
     */
    protected $baseUrl = 'https://bill.ccbill.com/';

    /**
     * @var array stores client details
     */
    protected $client;

    function __construct($client = null)
    {
        $this->client = $client;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getAccNumber()
    {
        return $this->client['accnum'];
    }

    public function getSubAccNumber()
    {
        return $this->client['subacc'];
    }

    public function getSalt()
    {
        return $this->client['salt'];
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    public function buildUrl($path)
    {
        return rtrim($this->baseUrl, '/') . '/' . ltrim($path, '/');
    }
}