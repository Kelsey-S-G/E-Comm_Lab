<?php
// settings/core.php
// Core logic for Session, Auth, and Permissions

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define root path constants if not already defined
if (!defined('DB_HOST')) {
    require_once(__DIR__ . "/db_class.php");
}

/**
 * Check if user is logged in.
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if the logged-in user is an Admin.
 * Role 1 = Admin, Role 2 = Alumni
 */
function is_admin() {
    return is_logged_in() && isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1;
}

/**
 * Enforce Login: Redirects if not logged in.
 */
function check_login() {
    if (!is_logged_in()) {
        // Adjust path based on where this function is called from
        // Assuming standard depth (e.g., inside /admin/ or /view/)
        header("Location: ../login/signin.php");
        exit();
    }
}

/**
 * Enforce Admin: Redirects if not admin.
 */
function check_admin_privilege() {
    check_login(); // First ensure they are logged in
    if (!is_admin()) {
        // Redirect non-admins to the main profile
        header("Location: ../view/profile.php");
        exit();
    }
}

/**
 * Get current user ID
 */
function get_user_id() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

/**
 * Get User Name (For display)
 */
function get_user_name() {
    return isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
}

/**
 * Send Payment Receipt Email
 */
function send_payment_receipt($email, $name, $reference, $amount, $currency = 'GHS') {
    $subject = "Payment Receipt - ReConnect Order #$reference";
    
    $message = "
    <html>
    <head>
      <title>Payment Receipt</title>
    </head>
    <body style='font-family: Arial, sans-serif;'>
      <div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;'>
        <h2 style='color: #2d6cdf;'>ReConnect Receipt</h2>
        <p>Hi $name,</p>
        <p>Thank you for your payment. Your transaction was successful.</p>
        
        <table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>
          <tr style='background: #f9f9f9;'>
            <td style='padding: 10px;'><strong>Reference:</strong></td>
            <td style='padding: 10px;'>$reference</td>
          </tr>
          <tr>
            <td style='padding: 10px;'><strong>Amount Paid:</strong></td>
            <td style='padding: 10px;'>$currency $amount</td>
          </tr>
          <tr style='background: #f9f9f9;'>
            <td style='padding: 10px;'><strong>Date:</strong></td>
            <td style='padding: 10px;'>" . date('Y-m-d H:i:s') . "</td>
          </tr>
        </table>
        
        <p>You can view your order details in your dashboard.</p>
        <p>Best Regards,<br>The ReConnect Team</p>
      </div>
    </body>
    </html>
    ";

    // Headers for HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: no-reply@reconnect.com" . "\r\n";

    // Send
    return mail($email, $subject, $message, $headers);
}
?>