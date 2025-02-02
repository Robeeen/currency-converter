<?php

add_action('rest_api_init', 'currency_converter_rest_api_init' );

function currency_converter_rest_api_init(){
    register_rest_route('currency-converter/v1', '/convert', array(
        'method' => 'GET',
        'callback' => 'currency_converter',
    ));
}

function currency_converter($request){
    $amount = $request->get_param('amount');
    $from_currency = $request->get_param('from_currency');
    $to_currency = $request->get_param('to_currency');

    $api = "https://api.exchangerate-api.com/v4/latest/{$from_currency}";
    //Performs an HTTP request using the GET method and returns its response
    $response = wp_remote_get($api);

    if(is_wp_error($response)){
        return new WP_Error('api_error', 'Unable to fetch the exchange rates', array(
            'status' => 500
        ));
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    var_dump($data);




}