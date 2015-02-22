<?php

use Mcprohosting\Ccbill\Client\CcbillClient as Client;
use Mcprohosting\Ccbill\Forms\DynamicPricingForm;
use Mcprohosting\Ccbill\CurrencyCode;
use Mcprohosting\Ccbill\Forms\Builders\UrlBuilder;

// First, make the ccbill client
$client = new Client([ 'accnum' => '123', 'subacc' => '456', 'salt' => '789' ]);

// Then create the form for a dynamic pricing request.
$form = new DynamicPricingForm($client, [
    'formName' => '75cc',
    'formPrice' => '18.00',
    'formPeriod' => 10,
    'currencyCode' => CurrencyCode::from('USD')
]);

// If we're returning from ccbill, try to verify the form.
if (count($_POST)) {
    if ($form->capture()->isSuccessful()) {
        echo 'Your payment has been processed!';
    } else {
        echo 'Oh no, something went wrong!';
    }
}
// Otherwise show a link for the client.
else {
    echo 'Go to this address to purchase: ' . $form->build(new UrlBuilder());
}