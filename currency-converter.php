<?php
/*
Plugin Name: Currency Converter
Description: A simple currency converter plugin for WordPress.
Version: 1.0
Author: Shams Khan
*/

require_once('api/api.php');

// Register the shortcode
add_shortcode('currency_converter', 'currency_converter_shortcode');
function currency_converter_shortcode() {
    ob_start(); ?>
    <form id="currency-converter-form">
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="1" required>
        <br><br>

        <label for="from_currency">From Currency:</label>
        <select id="from_currency" name="from_currency" required>
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
            <option value="GBP">GBP</option>
            <option value="INR">INR</option>
            <option value="JPY">JPY</option>
            <!-- Add more currencies as needed -->
        </select>
        <br><br>
        <label for="to_currency">To Currency:</label>
        <select id="to_currency" name="to_currency" required>
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
            <option value="GBP">GBP</option>
            <option value="INR">INR</option>
            <option value="JPY">JPY</option>
            <!-- Add more currencies as needed -->
        </select>
        <br><br>
        <button type="submit">Convert</button>
    </form>

    <div id="conversion-result"></div>

    <script>
    document.getElementById('currency-converter-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var amount = document.getElementById('amount').value;
        var from_currency = document.getElementById('from_currency').value;
        var to_currency = document.getElementById('to_currency').value;

        fetch('/wp-json/currency-converter/v1/convert?amount=' + amount + '&from_currency=' + from_currency + '&to_currency=' + to_currency)
            .then(response => response.json())
            .then(data => {
                if (data.converted_amount) {
                    document.getElementById('conversion-result').innerHTML = 'Converted Amount: ' + data.converted_amount;
                } else {
                    document.getElementById('conversion-result').innerHTML = 'Error: ' + data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
    </script>
    <?php
    return ob_get_clean();
}
