<?php

namespace Mcprohosting\Ccbill\Forms\Builders;

use Mcprohosting\Ccbill\Client\Client;
use Mcprohosting\Ccbill\Forms\Form;

class InputBuilder implements Builder
{
    public function build(Client $client, Form $form)
    {
        $output = '';
        foreach ($form->serialize() as $key => $value) {
            $output .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
        }

        return $output;
    }
}