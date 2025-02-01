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
        <input type="number" id="amount" name="amount" step="0.01" required>



    </form> 

<?php
}

