<?php

return [

    'enviroment'    => env('PAGSEGURO_ENVIROMENT'),
    'email'         => env('PAGSEGURO_EMAIL'),
    'token'         => env('PAGSEGURO_TOKEN'),

    'url_checkout_sandbox' => 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout',
    'url_checkout_production' => 'https://ws.pagseguro.uol.com.br/v2/checkout',

    'url_redirect_after_request' => 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=',

    'url_lightbox_sandbox' => 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js',
    'url_lightbox_production' => 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js',

];