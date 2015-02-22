<?php

namespace Mcprohosting\Ccbill\Responses;


interface Response
{
    /**
     * Returns whether the response is both successful *and* valid.
     *
     * @return bool
     */
    public function isSuccessful();

    /**
     * Returns true if the response isn't successful or if it's invalid.
     *
     * @return bool
     */
    public function isFailed();

    /**
     * Returns whether the response is valid.
     *
     * @return bool
     */
    public function isValid();

    /**
     * Returns the given *key* given in the response.
     *
     * @param $key string
     * @return mixed
     */
    public function get($key);
}