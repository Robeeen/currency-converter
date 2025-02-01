<?php

/*
Plugin Name: Currency Converter
Description: A simple currency converter plugin for WordPress.
Version: 1.0
Author: Shams Khan
*/

function currency_converter_shortcode(){
    ob_start(); ?>
    <form id="currency-converter-form">
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" required />

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
    </form> 

    <div id="converted-result"></div>

<?php
}

