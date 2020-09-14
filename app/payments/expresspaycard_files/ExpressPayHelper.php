<?php
require_once(dirname(__FILE__).'/ExpressPayLog.php');

class ExpressPayHelper
{
    // Функция генерации и проверки цифровой подписи
    function compute_signature($json, $secretWord) {
        $hash = NULL;
        
        if (empty(trim($secretWord)))
        $hash = strtoupper(hash_hmac('sha1', $json, ""));
        else
            $hash = strtoupper(hash_hmac('sha1', $json, $secretWord));
        return $hash;
    }

     function computeSignatureCard($request_params, $secret_word, $token) 
    {
        $secret_word = trim($secret_word);
        $normalized_params = array_change_key_case($request_params, CASE_LOWER);
        $api_method = array(
            "expresspayaccountnumber",
            "expresspayinvoiceno",
        );

        $result = $token;
        foreach ($api_method as $item)
            $result .= ( isset($normalized_params[$item]) ) ? strtolower($normalized_params[$item]) : '';

        $hash = strtoupper(hash_hmac('sha1', $result, $secret_word));

        return $hash;
    }
    function compute_signature_add_invoice($request_params, $secret_word, $token){
        $secret_word = trim($secret_word);
        $normalized_params = array_change_key_case($request_params, CASE_LOWER);
        $api_method = array(
            "serviceid",
            "accountno",
            "expiration",
            "amount",
            "currency",
            "info",
            "returnurl",
            "failurl",
            "language",
            "sessiontimeoutsecs",
            "expirationdate",
            "returntype",
        );

        $result = $token;

        foreach ($api_method as $item)
            $result .= ( isset($normalized_params[$item]) ) ? $normalized_params[$item] : '';

        $hash = strtoupper(hash_hmac('sha1', $result, $secret_word));
        return $hash;
    }
}