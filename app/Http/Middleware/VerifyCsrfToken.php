<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/user/payment/notify',
        'webhooks/mollie',
        '/mollie',
        '/mollie1',
        '/webhooks/quotation_payment',
        '/download-quote-request-api',
        '/accept-quotation-api'

    ];
}
