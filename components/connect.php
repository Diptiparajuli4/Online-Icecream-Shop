<?php
$host = 'localhost';
$db_name = 'icecream_db';
$user_name = 'root';
$user_password = '';

// Create connection
$con = new mysqli($host, $user_name, $user_password, $db_name);

// Check connection with error handling
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Function to generate a unique ID
if (!function_exists('unique_id')) {
    function unique_id() {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charlength = strlen($chars);
        $randomString = '';
        try {
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $chars[random_int(0, $charlength - 1)];
            }
        } catch (Exception $e) {
            error_log("Random ID generation failed: " . $e->getMessage());
            return uniqid(); // Fallback in case of error
        }
        return $randomString;
    }
}
?>
