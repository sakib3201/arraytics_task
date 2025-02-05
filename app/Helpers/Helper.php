<?php

/**
 * Retrieve a configuration value using dot notation.
 * 
 * @param string $key     The dot-notated key (e.g., "database.host").
 * @return mixed|null     The configuration value or null if not found.
 */
function config($key) {
    static $config = null;

    // Load config only once
    if ($config === null) {
        $config = require '../config/config.php'; 
    }

    // Retrieve value using dot notation
    $keys = explode('.', $key);
    $value = $config;

    foreach ($keys as $k) {
        if (!is_array($value) || !array_key_exists($k, $value)) {
            return null; // Return null if key not found
        }
        $value = $value[$k];
    }

    return $value;
}

/**
 * Generate a salted SHA-512 hash of the given receipt_id.
 *
 * @param string $receipt_id The receipt ID to hash.
 * @return string The salted SHA-512 hash.
 */
function generateHashKey($receipt_id) {
    // Generate a secure random salt (use a constant or store securely)
    $salt = config('secure_salt'); // You can also store this in config

    // Combine the receipt_id with the salt
    $data = $receipt_id . $salt;

    // Hash the combined data using SHA-512
    return hash('sha512', $data);
}