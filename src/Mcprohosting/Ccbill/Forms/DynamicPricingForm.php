<?php

namespace Mcprohosting\Ccbill\Forms;


use Mcprohosting\Ccbill\Responses\DynamicPricingResponse;

class DynamicPricingForm extends AbstractForm implements Form
{
    public $path = '/jpost/signup.cgi';

    /**
     * Returns whether the Dynamic Form is recurring, or not...
     *
     * @return bool
     */
    public function isRecurring()
    {
        return array_key_exists('formRebills', $this->data) && $this->data['formRebills'] !== 0;
    }

    public function serialize()
    {
        $data = $this->addClientData($this->data);

        if ($this->isRecurring()) {
            $data['formDigest'] = $this->digestValues($data, [
                'formPrice', 'formPeriod', 'formRecurringPrice',
                'formRecurringPeriod', 'formRebills', 'currencyCode'
            ]);
        } else {
            $data['formDigest'] = $this->digestValues($data, ['formPrice', 'formPeriod', 'currencyCode']);
        }

        return $data;
    }

    public function capture($data = null)
    {
        return new DynamicPricingResponse($this->client, $data ?: $_POST);
    }
}