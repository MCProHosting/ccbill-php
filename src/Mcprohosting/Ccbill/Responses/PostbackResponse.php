<?php

namespace Mcprohosting\Ccbill\Responses;


use Mcprohosting\Ccbill\Client\Client;

class PostbackResponse implements Response
{
    /**
     * @var array data given back from the response.
     */
    protected $data;

    /**
     * @var Client the client associated with the postback
     */
    protected $client;

    function __construct(Client $client, $data)
    {
        $this->client = $client;
        $this->data = $data;
    }

    public function isSuccessful()
    {
        return $this->isValid() && !$this->get('denialId');
    }

    public function isFailed()
    {
        return !$this->isSuccessful();
    }

    public function isValid()
    {
        return true;
    }

    public function get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else {
            return null;
        }
    }
}