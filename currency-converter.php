<?php

/*
Plugin Name: Currency Converter
Description: A simple currency converter plugin for WordPress.
Version: 1.0
Author: Shams Khan
*/

add_shortcode('currency_converter', 'currency_converter_shortcode');

function currency_converter_shortcode(){
    ob_start(); ?>
    <form id="currency-converter-form">
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" required />
        <br /> <br />

        <label for="from_currency">From Currency: </label>
        <select id="from_currency" name="from_currency" required>
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
            <option value="GBP">GBP</option>

        </select>   

        <label for="to_currency">To Currency: </label>
        <select id="to_currency" name="to_currency" required >
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
            <option value="GBP">GBP</option>
        </select>

        <br /> <br />

        <button type="submit">Convert</button>
    </form> 

    <div id="converted-result"></div>

    <script>
        document.getElementById('currency-converter-form').addEventListener('submit', function(e){
            e.preventDefault();
            var amount = document.getElementById('amount').value;
            var from_currency = document.getElementById('from_currency').value;
            var to_currency = document.getElementById('to_currency').value;

            

        })


    </script>

<?php
}



require_once('api/api.php');
