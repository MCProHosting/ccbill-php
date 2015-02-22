<?php

namespace Mcprohosting\Ccbill\Forms\Builders;


use Mcprohosting\Ccbill\Client\Client;
use Mcprohosting\Ccbill\Forms\Form;

interface Builder
{
    /**
     * Creates some sort of built string out of the client and form.
     *
     * @param $client Client
     * @param $form Form
     * @return string
     */
    public function build(Client $client, Form $form);
}