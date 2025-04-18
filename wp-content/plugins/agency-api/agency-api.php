<?php
/*
Plugin Name: Agency API
Description: API to create and modify agencies.
Version: 1.0
Author: Martina Fernandez
*/
add_action('rest_api_init', function () {
    register_rest_route('agency/v1', '/agency', [
        'methods' => 'POST',
        'callback' => 'create_agency',
        'permission_callback' => '__return_true'
    ]);

    register_rest_route('agency/v1', '/agency', [
        'methods' => 'GET',
        'callback' => 'get_agency',
        'permission_callback' => '__return_true'
    ]);
});

function create_agency($request) {
    $email = sanitize_text_field($request['email']);
    $name = sanitize_text_field($request['name']);
    $secret = sanitize_text_field($request['secret']);

    if (empty($email) || empty($name) || empty($secret)) {
        return new WP_REST_Response(['error' => 'Missing required fields.'], 400);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match('/^[\w.-]+\.[a-z]{2,}$/i', $email)) {
        return new WP_REST_Response(['error' => 'Invalid email or domain format.'], 400);
    }

    $existing = get_option("agency_" . md5(strtolower($email)));
    if ($existing) {
        return new WP_REST_Response(['error' => 'Agency with that email/domain already exists.'], 409);
    }

    $id = bin2hex(random_bytes(32));
    $encrypted_secret = agency_encrypt($secret);
    if (!$encrypted_secret) {
        return new WP_REST_Response(['error' => 'Encryption failed.'], 500);
    }
    
    $agency = [
        'id' => $id,
        'name' => substr($name, 0, 64),
        'email' => strtolower($email),
        'secret' => $encrypted_secret,
    ];

    update_option("agency_" . md5($agency['email']), $agency);

    return new WP_REST_Response(['message' => 'Agency created successfully.', 'id' => $id], 201);
}

function get_agency($request) {
    $email = sanitize_text_field($request['email']);
    if (empty($email)) {
        return new WP_REST_Response(['error' => 'Email or domain is required.'], 400);
    }

    $agency = get_option("agency_" . md5(strtolower($email)));

    if (!$agency) {
        return new WP_REST_Response(['error' => 'Agency not found.'], 404);
    }

    return new WP_REST_Response([
        'id' => $agency['id'],
        'name' => $agency['name'],
        'email' => $agency['email'],
        'secret' => agency_decrypt($agency['secret']) ?: 'Decryption failed'
    ]);
}
function agency_encrypt($plaintext) {
    if (!defined('AGENCY_SECRET_KEY')) {
        return false;
    }

    $key = hash('sha256', AGENCY_SECRET_KEY, true); // 256-bit key
    $iv = openssl_random_pseudo_bytes(16); // 128-bit IV
    $ciphertext_raw = openssl_encrypt($plaintext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    
    if ($ciphertext_raw === false) {
        return false;
    }

    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, true); // integridad
    return base64_encode($iv . $hmac . $ciphertext_raw);
}

function agency_decrypt($ciphertext) {
    if (!defined('AGENCY_SECRET_KEY')) {
        return false;
    }

    $key = hash('sha256', AGENCY_SECRET_KEY, true);
    $data = base64_decode($ciphertext);

    if ($data === false || strlen($data) < 48) {
        return false;
    }

    $iv = substr($data, 0, 16);
    $hmac = substr($data, 16, 32);
    $ciphertext_raw = substr($data, 48);

    $calculated_hmac = hash_hmac('sha256', $ciphertext_raw, $key, true);

    if (!hash_equals($hmac, $calculated_hmac)) {
        return false;
    }

    return openssl_decrypt($ciphertext_raw, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
}
