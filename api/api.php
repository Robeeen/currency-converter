<?php

add_action('rest_api_init', 'currency_converter_rest_api_init' );

function currency_converter_rest_api_init(){
    register_rest_route('currency-converter/v1', '/convert', array(
        'method' => 'GET',
        'callback' => 'currency_converter',
    ));
}

function currency_converter($request){
    $amount = $request->get_params('amount');
    $from_currency = $request->get_params('from_currency');
    $to_currency = $request->get_params('to_currency');

   // $api = "https://api.exchangerate-api.com/v4/latest/{$from_currency}";
    //Performs an HTTP request using the GET method and returns its response
    $api = "https://v6.exchangerate-api.com/v6/200f0e588456080fcb617f99/latest/{$from_currency}";
    $response = wp_remote_get($api);

    if(!empty($response) && is_wp_error($response)){
        return new WP_Error('api_error', 'Unable to fetch the exchange rates', array(
            'status' => 500
        ));
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    if(isset($data['rates'][$to_currency])){
        return new WP_Error('currency_error', 'Invalid Currency Code', array(
            'status' => 400
        ));
    }

    






}