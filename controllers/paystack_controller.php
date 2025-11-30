<?php
// controllers/paystack_controller.php
require_once(__DIR__ . "/../settings/paystack_config.php");

/**
 * Initialize a Paystack Transaction
 */
function initialize_paystack_payment($email, $amount, $reference) {
    $url = PAYSTACK_URL . "/transaction/initialize";
    
    // Amount in Kobo/Pesewas
    $amount_minor = $amount * 100; 

    // --- AUTOMATIC CALLBACK URL GENERATION ---
    // 1. Detect Protocol
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    
    // 2. Detect Host (localhost)
    $host = $_SERVER['HTTP_HOST'];
    
    // 3. Detect Project Root Folder
    // $_SERVER['SCRIPT_NAME'] is the path of the file currently running (e.g., /MyProject/actions/initialize_payment_action.php)
    // dirname(...) gets the folder. We go up 2 levels to find the project root.
    // Level 1: /MyProject/actions
    // Level 2: /MyProject
    $project_root = dirname(dirname($_SERVER['SCRIPT_NAME']));
    
    // Fix for Windows paths causing issues (converts backslash to forward slash)
    $project_root = str_replace('\\', '/', $project_root);
    
    // Handle root directory edge case
    if ($project_root === '/') $project_root = '';

    // Final URL
    $callback_url = "$protocol://$host$project_root/view/payment_callback.php";
    // ----------------------------------------

    $fields = [
        'email' => $email,
        'amount' => $amount_minor,
        'reference' => $reference,
        'callback_url' => $callback_url,
        'currency' => 'GHS'
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