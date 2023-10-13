<?php

namespace Fzlxtech\LaravelRapyd\Utils;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Http;

class Utils {
    function generate_string($length=12) {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, $length);
    }

    function makeRequest($request, $path)  {
        $method = $request->isMethod('post') ? 'post' : 'get';
        $body = $method == 'post' ? $request->all() : null;
        $base_url = 'https://sandboxapi.rapyd.net';
        $secret_key = 'rsk_8f8f481bc8ecfc450af3958ab390227fec9f61ae4607768cb33d0c37d0c6997e44f0f74afc866911';     // Never transmit the secret key by itself.
        $access_key = 'rak_657422F4421C8DEE5BCF';     // The access key received from Rapyd.
        
        $idempotency = $this->generate_string();      // Unique for each request.
        $http_method = $method;                // Lower case.
        $salt = $this->generate_string();             // Randomly generated for each request.
        $date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur'));
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