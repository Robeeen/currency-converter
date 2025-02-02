<?php
// Register the REST API endpoint
function currency_converter_rest_api_init() {
    register_rest_route('currency-converter/v1', '/convert', array(
        'methods' => 'GET',
        'callback' => 'currency_converter_convert',
    ));
    
}
add_action('rest_api_init', 'currency_converter_rest_api_init');

// Handle the currency conversion
function currency_converter_convert($request) {    

    $amount = $request->get_param('amount');
    $from_currency = strtoupper($request->get_param('from_currency')); // Ensure uppercase
    $to_currency = strtoupper($request->get_param('to_currency')); // Ensure uppercase


    // Use the ExchangeRate-API for currency conversion
    $api_key = '200f0e588456080fcb617f99'; 
    $api_url = "https://v6.exchangerate-api.com/v6/{$api_key}/latest/{$from_currency}";
    
    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) {
        return new WP_Error('api_error', 'Unable to fetch exchange rates', array('status' => 500));
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
 

    // Check if the to_currency is supported
    if (!isset($data['conversion_rates'][$to_currency])) {        
        return new WP_Error('currency_error', 'Invalid currency code', array('status' => 400));
    }

    $rate = $data['conversion_rates'][$to_currency];
    $converted_amount = round(($amount * $rate), 2);
   

    return array(
        'converted_amount' => $converted_amount,
    );
}