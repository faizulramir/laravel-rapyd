<?php

namespace Fzlxtech\LaravelRapyd\Http\Controllers;

use App\Http\Controllers\Controller;
use Config;
use Illuminate\Http\Request;
use Fzlxtech\LaravelRapyd\Utils\Utils;
use Redirect;

class PaymentController extends Controller 
{
    private $Utils;
    public function __construct()
    {
        $this->Utils = new Utils();
    }

    public function create_payment(Request $request) {
        $path = '/v1/payments/';
        $resp = $this->Utils->makeRequest($request, $path);

        if (!$resp) {
           Redirect::to(Config::get('rapyd.rapyd_error_url'));
        }

        Redirect::to(Config::get('rapyd.rapyd_success_url'));
    }

    public function checkout(Request $request) {
        $path = '/v1/checkout/';
        $resp = $this->Utils->makeRequest($request, $path);

        if (!$resp) {
        //    Redirect::to(Config::get('rapyd.rapyd_error_url'));
        }

        // Redirect::to(Config::get('rapyd.rapyd_success_url'));
    }

    public function payment_methods_required_fields(Request $request) {
        // $type = 'my_debit_mastercard_card';
        $path = '/v1/payment_methods/required_fields/' . $request->type;
        $resp = $this->Utils->makeRequest($request, $path);

        return $resp;
    }

    public function payment_methods_countries(Request $request) {
        // $country = 'MY';
        // $currency = 'MYR';
        $path = '/v1/payment_methods/countries/' . $request->country . '/?currency=' . $request->currency;
        $resp = $this->Utils->makeRequest($request, $path);

        return $resp;
    }

    public function create_payment_methods(Request $request) {
        // $customer_id = 'cus_1';
        $path = '/v1/customers/'. $$request->customer_id .'/payment_methods';
        $resp = $this->Utils->makeRequest($request, $path);

        return $resp;
    }
}