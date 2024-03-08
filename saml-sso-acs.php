<?php

use OneLogin\Saml2\Auth;

/**
 * Load the WordPress environment and SAML configuration files.
 */

file_exists(dirname(__DIR__, 3) . '/wp-load.php') ? require_once dirname(__DIR__, 3) . '/wp-load.php' : wp_die('WordPress environment not found.');
file_exists(__DIR__ . '/vendor/autoload.php') ? require_once __DIR__ . '/vendor/autoload.php' : wp_die('SAML SSO constants file not found.');
file_exists(__DIR__ . '/saml-sso-constants-and-functions.php') ? require_once __DIR__ . '/saml-sso-constants-and-functions.php' : wp_die('SAML SSO constants and functions file not found.');

/**
 * Define SAML settings from WordPress options.
 * This includes service provider and identity provider configuration.
 */
$settings = [
  'strict' => true,
  'debug' => true,
  'sp' => [
    'entityId' => get_site_option('saml_sso_sp_entity_id'),
    'assertionConsumerService' => ['url' => SAML_SSO_ACS_URL],
    'NameIDFormat' => get_site_option('saml_sso_sp_name_id_format'),
  ],
  'idp' => [
    'entityId' => get_site_option('saml_sso_idp_entity_id'),
    'singleSignOnService' => ['url' => get_site_option('saml_sso_idp_sso_service_url')],
    'x509cert' => get_site_option('saml_sso_idp_509_certificate'),
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
    wp_set_auth_cookie($user->ID, get_site_option('saml_sso_remember_user_sessions') === 'yes');

    // Redirect super admins to the network admin dashboard.
    if (is_super_admin($user->ID)) {
      wp_redirect(network_admin_url());
      exit;
    }

    // Handle user redirects based on the number of sites they belong to.
    $sites = get_blogs_of_user($user->ID);
    if (count($sites) === 1) {
      wp_redirect(array_shift($sites)->siteurl . '/wp-admin/');
      exit;
    }

    // Render a template for users with multiple sites.
    file_exists(__DIR__ . '/page-choose-user-site.php') ? include './page-choose-user-site.php' : wp_die('SAML SSO user site selection file not found.');
  } else {
    // Error handling for unrecognized user.
    wp_die('Sorry, no user found with that email address.', 'SSO Login Error');
  }
} else {
  // SAML error handling.
  wp_die('SAML response processing error', 'SSO Login Error');
}
