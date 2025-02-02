<?php
// Register the REST API endpoint
function currency_converter_rest_api_init() {
    register_rest_route('currency-converter/v1', '/convert', array(
        'methods' => 'GET',
        'callback' => 'currency_converter_convert',
    ));
    error_log('Currency Converter REST API endpoint registered.'); // Debug statement
}
add_action('rest_api_init', 'currency_converter_rest_api_init');

// Handle the currency conversion
function currency_converter_convert($request) {
    error_log('Currency Converter API Request Received.'); // Debug statement

    $amount = $request->get_param('amount');
    $from_currency = strtoupper($request->get_param('from_currency')); // Ensure uppercase
    $to_currency = strtoupper($request->get_param('to_currency')); // Ensure uppercase

    error_log("Amount: $amount, From: $from_currency, To: $to_currency"); // Debug statement

    // Validate currency codes
    $valid_currencies = ['USD', 'EUR', 'GBP', 'INR', 'JPY']; // Add all supported currencies
    if (!in_array($from_currency, $valid_currencies) || !in_array($to_currency, $valid_currencies)) {
        error_log('Invalid currency code provided.');
        return new WP_Error('currency_error', 'Invalid currency code', array('status' => 400));
    }

    // Use the ExchangeRate-API for currency conversion
    $api_key = '200f0e588456080fcb617f99'; // Replace with your actual API key
    $api_url = "https://v6.exchangerate-api.com/v6/{$api_key}/latest/{$from_currency}";
    error_log("API URL: " . $api_url); // Debug statement

    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) {
        error_log('API Error: ' . $response->get_error_message());
        return new WP_Error('api_error', 'Unable to fetch exchange rates', array('status' => 500));
    }

    $body = wp_remote_retrieve_body($response);
    error_log("API Response Body: " . $body); // Debug statement

    $data = json_decode($body, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('JSON Decoding Error: ' . json_last_error_msg());
        return new WP_Error('json_error', 'Invalid JSON response from API', array('status' => 500));
    }

    error_log("Decoded API Data: " . print_r($data, true)); // Debug statement

    // Check for API errors
    if ($data['result'] === 'error') {
        error_log('API Error: ' . $data['error-type']);
        return new WP_Error('api_error', 'API Error: ' . $data['error-type'], array('status' => 500));
    }

    // Check if the to_currency is supported
    if (!isset($data['conversion_rates'][$to_currency])) {
        error_log('Invalid currency code or rates not found.');
        return new WP_Error('currency_error', 'Invalid currency code', array('status' => 400));
    }

    $rate = $data['conversion_rates'][$to_currency];
    $converted_amount = $amount * $rate;

    error_log("Conversion successful. Converted Amount: $converted_amount"); // Debug statement

    return array(
        'converted_amount' => $converted_amount,
    );
}