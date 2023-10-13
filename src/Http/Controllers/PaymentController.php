<?php

namespace Fzlxtech\LaravelRapyd\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Fzlxtech\LaravelRapyd\Utils\Utils;

class PaymentController extends Controller 
{
    private $Utils;
    public function __construct()
    {
        $this->Utils = new Utils();
    }

    // make_request method - Includes the logic to communicate with the Rapyd sandbox server.
    public function create_payment(Request $request) {
        $path = '/v1/payments/';
        $resp = $this->Utils->makeRequest($request, $path);

        if (!$resp) {
            dd('lol');
        }

        dd('yey');
    }

    public function create_payment_success (Request $request) {
        dd('yey');
    }

    public function create_payment_error (Request $request) {
        dd('yey');
    }

    public function payment_methods_required_fields(Request $request) {
        $type = 'my_debit_mastercard_card';
        $path = '/v1/payment_methods/required_fields/' . $type;
        $resp = $this->Utils->makeRequest($request, $path);

        if (!$resp) {
            dd('lol');
        }

        dd('yey');
    }

    public function payment_methods_countries(Request $request) {
        $country = 'MY';
        $currency = 'MYR';
        $path = '/v1/payment_methods/countries/' . $country . '/?currency=' . $currency;
        $resp = $this->Utils->makeRequest($request, $path);

        if (!$resp) {
            dd('lol');
        }

        dd('yey');
    }

    public function create_payment_methods(Request $request) {
        $customer_id = 'cus_1';
        $path = '/v1/customers/'. $customer_id .'/payment_methods';
        $resp = $this->Utils->makeRequest($request, $path);

        if (!$resp) {
            dd('lol');
        }

        dd('yey');
    }
}