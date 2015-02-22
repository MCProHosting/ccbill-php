<?php

namespace Mcprohosting\Ccbill\Client;


interface Client
{
    /**
     * Expects an associative array with three values set: the "accnum",
     * the "subacc", and the "salt". These will be used when building
     * out forms.
     *
     * @param $client array
     * @return Client
     */
    public function setClient($client);

    /**
     * Returns the account number
     * @return string
     */
    public function getAccNumber();

    /**
     * Returns the sub-account number
     * @return string
     */
    public function getSubAccNumber();

    /**
     * Returns the salt
     * @return string
     */
    public function getSalt();

    /**
     * Returns the client array set previously.
     * @return array
     */
    public function getClient();

    /**
     * Returns the base URL of the ccbill portal.
     *
     * @return string
     */
    public function getBaseUrl();

    /**
     * Sets the base url for building requests.
     *
     * @param $url string
     * @return Client
     */
    public function setBaseUrl($url);

    /**
     * Creates a URL from a "path" fragment, relative to the base url.
     *
     * @param $path string
     * @return string
     */
    public function buildUrl($path);
}