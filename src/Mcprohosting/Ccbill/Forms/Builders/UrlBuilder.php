<?php

namespace Mcprohosting\Ccbill\Forms\Builders;

use Mcprohosting\Ccbill\Client\Client;
use Mcprohosting\Ccbill\Forms\Form;

class UrlBuilder implements Builder
{
    public function build(Client $client, Form $form)
    {
        return $client->buildUrl($form->getPath()) . '?' . http_build_query($form->serialize());
    }
}