<?php

namespace Mcprohosting\Ccbill\Responses;


class DynamicPricingResponse extends PostbackResponse
{
    public function isValid()
    {
        $hash = null;

        if ($this->get('denialId')) {
            $hash = md5($this->get('denialId') . '0' . $this->client->getSalt());
        } else {
            $hash = md5($this->get('subscriptionId') . '1' . $this->client->getSalt());
        }

        return $hash === $this->get('responseDigest');
    }
}