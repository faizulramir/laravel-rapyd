<?php

namespace Fzlxtech\LaravelRapyd\Utils;

use Config;
use DateTime;
use Illuminate\Support\Facades\Http;

class Utils {
    private $rapyd_env;

    public function __construct()
    {
        $this->rapyd_env = Config::get('rapyd.rapyd_env');
    }
    function generate_string($length=12) {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, $length);
    }

    function makeRequest($request, $path)  {
        $method = $request->isMethod('post') ? 'post' : 'get';

        if ($method == 'post') {
            $body = $request->all();
            $body['complete_payment_url'] = Config::get('rapyd.rapyd_complete_url');
            $body['error_payment_url'] = Config::get('rapyd.rapyd_error_url');
        } else {
            $body = null;
        }

        $base_url = 'https://'. ($this->rapyd_env == 'prod' ? 'sandboxapi.' : '') .'rapyd.net';
        $secret_key = Config::get('rapyd.rapyd_secret_key');     // Never transmit the secret key by itself.
        $access_key = Config::get('rapyd.rapyd_access_key');    // The access key received from Rapyd.
        $idempotency = $this->generate_string();      // Unique for each request.
        $http_method = $method;                // Lower case.
        $salt = $this->generate_string();             // Randomly generated for each request.
        $date = new DateTime();
        $timestamp = $date->getTimestamp();    // Current Unix time.
        
        $body_string = !is_null($body) ? json_encode($body,JSON_UNESCAPED_SLASHES) : '';
        // dd($body_string);
        $sig_string = "$http_method$path$salt$timestamp$access_key$secret_key$body_string";

        $hash_sig_string = hash_hmac("sha256", $sig_string, $secret_key);
        $signature = base64_encode($hash_sig_string);

        $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "Accept" => "application/json",
            "access_key" => $access_key,
            "salt" => $salt,
            "timestamp" => $timestamp,
            "signature" => $signature,
            "idempotency" => $idempotency
        ])->post($base_url.$path, $body)->json();

        if ($response['status']['status'] == "ERROR") {
            return null; 
        }

        return $response;
    }
}