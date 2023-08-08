<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SAML idP configuration file
    |--------------------------------------------------------------------------
    |
    | Use this file to configure the service providers you want to use.
    |
     */
    // Outputs data to your laravel.log file for debugging
    'debug' => false,
    // Define the email address field name in the users table
    'email_field' => 'email',
    // The URI to your login page
    'login_uri' => 'login',
    // Log out of the IdP after SLO
    'logout_after_slo' => env('LOGOUT_AFTER_SLO', false),
    // The URI to the saml metadata file, this describes your idP
    'issuer_uri' => 'saml/metadata',
    // Name of the certificate PEM file
    'certname' => 'cert.pem',
    // Name of the certificate key PEM file
    'keyname' => 'key.pem',
    // Encrypt requests and reponses
    'encrypt_assertion' => false,
    // Make sure messages are signed
    'messages_signed' => true,
    // list of all service providers
    'sp' => [
        // Base64 encoded ACS URL
        'aHR0cHM6Ly9sb2NhbC5jb2xvcmVkY293LmRldi93cC93cC1sb2dpbi5waHA/c2FtbF9hY3M=' => [
            // Your destination is the ACS URL of the Service Provider
            'destination' => 'https://local.coloredcow.dev/wp/wp-login.php?saml_acs',
           // 'logout' => 'https://local.coloredcow.dev/wp/wp-login.php?saml_sls',
            'logout' => '',
            'certificate' => '',
            'query_params' => '',
        ],

        'aHR0cHM6Ly91YXQuY29sb3JlZGNvdy5jb20vd3Avd3AtbG9naW4ucGhwP3NhbWxfYWNz' => [
            'destination' => 'https://uat.coloredcow.com/wp/wp-login.php?saml_acs',
            //'logout' => 'https://uat.coloredcow.com/wp/wp-login.php?saml_sls',
            'logout' => '',
            'certificate' => '',
            'query_params' => '',
        ],

        'aHR0cHM6Ly9jb2xvcmVkY293LmNvbS93cC93cC1sb2dpbi5waHA/c2FtbF9hY3M=' => [
            'destination' => 'https://coloredcow.com/wp/wp-login.php?saml_acs',
            //'logout' => 'https://local.coloredcow.dev/wp/wp-login.php?saml_sls',
            'logout' => '',
            'certificate' => '',
            'query_params' => '',
        ],
    ],

    // If you need to redirect after SLO depending on SLO initiator
    // key is beginning of HTTP_REFERER value from SERVER, value is redirect path
    'sp_slo_redirects' => [
        // 'https://example.com' => 'https://example.com',
    ],
];
