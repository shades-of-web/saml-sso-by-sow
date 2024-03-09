<?php

// test

use OneLogin\Saml2\Auth;

use SAMLSSO\SamlSsoConfig;


// Dynamic path resolution to find the WordPress environment
$wp_load_path = __DIR__; // Start with the current directory.
$found = false; // Flag to determine if wp-load.php has been found.

// Loop to move up in the directory hierarchy and check for wp-load.php
while (!$found && $wp_load_path != '/' && is_dir($wp_load_path)) {
  $potential_wp_load = $wp_load_path . '/wp-load.php';
  if (file_exists($potential_wp_load)) {
    require_once $potential_wp_load;
    $found = true; // Set found to true to exit the loop.
    break; // Exit the loop since we've found wp-load.php
  }
  $wp_load_path = dirname($wp_load_path); // Move one directory up.
}

if (!$found) {
  exit('Failed to find wp-load.php. Please check the path and try again.');
}


/**
 * Load the WordPress environment and SAML configuration files.
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Define SAML settings from WordPress options.
 * This includes service provider and identity provider configuration.
 */
$settings = [
  'strict' => true,
  'debug' => true,
  'sp' => [
    'entityId' => SamlSsoConfig::getOptionData('saml_sso_sp_entity_id'),
    'assertionConsumerService' => ['url' => SamlSsoConfig::$acsUrl],
    'NameIDFormat' => SamlSsoConfig::getOptionData('saml_sso_sp_name_id_format'),
  ],
  'idp' => [
    'entityId' => SamlSsoConfig::getOptionData('saml_sso_idp_entity_id'),
    'singleSignOnService' => ['url' => SamlSsoConfig::getOptionData('saml_sso_idp_sso_service_url')],
    'x509cert' => SamlSsoConfig::getOptionData('saml_sso_idp_509_certificate'),
  ],
];

/**
 * Create a new SAML Auth instance and process the SAML response.
 */
$auth = new Auth($settings);
$auth->processResponse();

/**
 * Handle user authentication and redirection based on the SAML response.
 */
if (empty($auth->getErrors())) {
  $attributes = $auth->getAttributes();
  $email = $attributes['E-mail'][0];
  $user = get_user_by('email', $email);

  if ($user) {
    // Set authentication cookie based on the 'remember user sessions' option.
    wp_set_auth_cookie($user->ID, SamlSsoConfig::getOptionData('saml_sso_remember_user_sessions') === 'yes');

    // Redirect super admins to the network admin dashboard.
    if (is_super_admin($user->ID)) {
      wp_safe_redirect(network_admin_url());
      exit;
    }

    // Handle user redirects based on the number of sites they belong to.
    $sites = get_blogs_of_user($user->ID);
    if (count($sites) === 1) {
      wp_safe_redirect(array_shift($sites)->siteurl . '/wp-admin/');
      exit;
    }

    // Render a template for users with multiple sites.
    include_once __DIR__ . '/page-choose-user-site.php';
  } else {
    // Error handling for unrecognized user.
    wp_die('Sorry, no user found with that email address.', 'SSO Login Error');
  }
} else {
  // SAML error handling.
  wp_die('SAML response processing error', 'SSO Login Error');
}
