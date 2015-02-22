<?php

namespace Mcprohosting\Ccbill\Forms;


use Mcprohosting\Ccbill\Client\Client;
use Mcprohosting\Ccbill\Forms\Builders\Builder;
use Mcprohosting\Ccbill\Hasher;

abstract class AbstractForm implements Form
{
    /**
     * @var Client ccbill client associated with the form.
     */
    protected $client;

    /**
     * @var array record of current form data
     */
    protected $data = [];

    /**
     * @var string the path to the endpoint used to submit the form.
     */
    public $path;

    function __construct($client, $data = [])
    {
        $this->client = $client;
        $this->set($data);
    }

    public function set($input, $value = null)
    {
        if (!is_array($input)) {
            return $this->set([ $input => $value ]);
        }
        $this->data = array_merge($this->data, $input);

        return $this;
    }

    public function serialize()
    {
        return $this->data;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function build(Builder $builder)
    {
        return $builder->build($this->client, $this);
    }

    /**
     * Adds the client account and subaccount numbers to the data.
     * @param $data array
     * @return array
     */
    protected function addClientData($data)
    {
        $data['clientSubacc'] = $this->client->getSubAccNumber();
        $data['clientAccnum'] = $this->client->getAccNumber();
        return $data;
    }

    /**
     * Takes a list of keys and returns an md5 digest
     * of their concatenated values.
     *
     * @param $data array
     * @param $keys array
     * @return string
     */
    protected function digestValues($data, $keys)
    {
        return Hasher::digest(
            array_merge($data, [ 'salt' => $this->client->getSalt() ]),
            array_merge($keys, [ 'salt' ])
        );
    }
}