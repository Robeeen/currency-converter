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

    
}