<?php



function ccbill_config() {
    return [
        'FriendlyName' => [ 'Type' => 'System', 'Value' => 'CCBill Gateway'],
        'accnum'       => [ 'FriendlyName' => 'Account Number', 'Type' => 'text', 'Size' => '6' ],
        'subacc'       => [ 'FriendlyName' => 'Subaccount Number', 'Type' => 'text', 'Size' => '4' ],
        'salt'         => [ 'FriendlyName' => 'Salt', 'Type' => 'text', 'Size' => '32' ],
        'formName'     => [ 'FriendlyName' => 'Form Name', 'Type' => 'text', 'Size' => '3' ],

        'dleuser'      => [ 'FriendlyName' => 'Username', 'Type' => 'text', 'Size' => '32',
                            'Description' => 'This is the username that was setup for authentication on the Data ' .
                                             'Link Extract system. Required for refund functionality.' ],
        'dlepass'      => [ 'FriendlyName' => 'Password', 'Type' => 'text', 'Size' => '32',
                            'Description' => 'This is the password that was setup for authentication on the Data ' .
                                             'Link Extract system. Required for refund functionality.' ]
    ];

    $a = [
        "FriendlyName" => array("Type" => "System", "Value"=>"My Custom Module"),
        "username" => array("FriendlyName" => "Login ID", "Type" => "text", "Size" => "20", ),
        "transmethod" => array("FriendlyName" => "Transaction Method", "Type" => "dropdown", "Options" => "Option1,Value2,Method3", ),
        "instructions" => array("FriendlyName" => "Payment Instructions", "Type" => "textarea", "Rows" => "5", "Description" => "Do this then do that etc...", ),
        "testmode" => array("FriendlyName" => "Test Mode", "Type" => "yesno", "Description" => "Tick this to test", ),
    ];
}

function ccbill_link($params) {

    $currencyMapping = [
        'AUD' => '036',
        'CAD' => '124',
        'JPY' => '392',
        'GBP' => '826',
        'USD' => '840',
        'EUR' => '978'
    ];

    // Make sure the currency is supported by ccbill.
    if (!array_key_exists($params['currency'], $currencyMapping)) {
        return '<p>Currency ' . $params['currency'] . ' not supported.</p>';
    }

    // WHMCS doesn't provide the period. Just default to 30 days :(
    $period = 30;
    $currencyCode = $currencyMapping[$params['currency']];

    // Create the list of form values to encode
    $encode = [
        'clientAccnum' => $params['accnum'],
        'clientSubacc' => $params['subacc'],
        'formName'     => $params['formName'],
        'formPrice'    => $params['amount'],
        'formPeriod'   => $period,
        'currencyCode' => $currencyCode,
        'invoiceId'    => $params['invoiceid'],
        'formDigest'   => md5($params['amount'] . $period . $currencyCode . $params['salt'])
    ];

    // Finally, create and return the necessary HTML.
    $out = '<form method="POST" action="https://bill.ccbill.com/jpost/signup.cgi">';
    foreach ($encode as $key => $value) {
            $out .= '<input type="hidden" name="' . $key . '" value ="' . $value .'" />';
    }
    $out .= '<input type="submit" value="Pay Now" class="btn btn-primary"/></form>';

    return $out;
}

function ccbill_refund($params) {

    $params = [
        'username'       => $params['dleuser'],
        'password'       => $params['dlepass'],
        'clientAccnum'   => $params['accnum'],
        'usingSubacc'    => $params['subacc'],
        'subscriptionId' => $params['transid']
    ];

    $response = file_get_contents('https://datalink.ccbill.com/utils/subscriptionManagement.cgi?' . http_build_query($parms));

    return [ 'status' => 'success', 'transid' => $params['transid'] ];
}

?>
