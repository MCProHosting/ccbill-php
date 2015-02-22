<?php

namespace Mcprohosting\Ccbill\Forms;


use Mcprohosting\Ccbill\Forms\Builders\Builder;
use Mcprohosting\Ccbill\Responses\Response;

interface Form
{
    /**
     * Sets key/value pairs on the form. Can take a single $key, $value as
     * arguments or an associative array of keys and values.
     *
     * @param $input string
     * @param $value string
     * @return Form
     */
    public function set($input, $value);

    /**
     * Returns the URL path that the form should be sent to.
     *
     * @return string
     */
    public function getPath();

    /**
     * Returns an array of all key/value pairs on the form. This also does
     * necessary digests so that the form data is ready for submission.
     *
     * @return array
     */
    public function serialize();

    /**
     * Returns a URL to fulfill a transaction requested by the form.
     *
     * @param Builder $builder
     * @return string
     */
    public function build(Builder $builder);

    /**
     * Should be called when you expect the form response to be returned.
     * Captures data from the input, or $_POST if undefined, returning
     * a Response object.
     *
     * @param array|null $input
     * @return Response
     */
    public function capture($input = null);
}