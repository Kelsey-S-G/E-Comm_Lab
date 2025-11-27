<?php
// controllers/payment_controller.php
require_once(__DIR__ . "/../settings/paystack_config.php");

/**
 * Initialize a Paystack Transaction
 */
function initialize_paystack_payment($email, $amount, $reference) {
    $url = PAYSTACK_URL . "/transaction/initialize";
    
    // Amount in Kobo (or smallest currency unit)
    // Paystack usually expects NGN kobo. For GHS, it expects Pesewas.
    $amount_minor = $amount * 100; 

    // Callback URL (Update domain for production)
    $callback_url = "http://localhost/ReConnect/view/payment_callback.php"; 

    $fields = [
        'email' => $email,
        'amount' => $amount_minor,
        'reference' => $reference,
        'callback_url' => $callback_url,
        'currency' => 'GHS' // Important: Set to GHS for Ghana Cedis
    ];

    $fields_string = http_build_query($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer " . PAYSTACK_SECRET_KEY,
        "Cache-Control: no-cache",
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($result, true);
}

/**
 * Verify a Paystack Transaction
 */
function verify_paystack_payment($reference) {
    $url = PAYSTACK_URL . "/transaction/verify/" . rawurlencode($reference);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer " . PAYSTACK_SECRET_KEY,
        "Cache-Control: no-cache",
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($result, true);
}
?>