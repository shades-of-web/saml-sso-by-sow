<?php

/**
 * Plugin Name: SoW SSO - Shades of Web's SSO Integration Hub
 * Plugin URI: https://www.shadesofweb.com/
 * Description: Experience seamless single sign-on (SSO) integration between your IDP and WordPress with our cutting-edge plugin. Eliminate the hassle of multiple logins and streamline user authentication across platforms. Our plugin empowers website owners to effortlessly synchronize user credentials, ensuring a smooth and secure login experience for both administrators and users. Say goodbye to login fatigue and embrace the simplicity of unified authentication with Shades of Web's SSO Integration plugin for WordPress.
 * Version: 1.0.0
 * Author: Shades of Web
 * Author URI: https://www.shadesofweb.com/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: sow-sso
 * Network: true
 */

// Steps to create plugins
// 1. Create a option page in network admin
// 2. Save SAML settings in network options
// 3. Load SAML settings in SAML plugin
// 4. Load OneLogin PHP SAML Toolkit
// 5. Define SAML settings from network options
// 6. Update Login Page to force SAML login
// 7. Use ACS URL to handle SAML response
// 8. Navigate User to Page based on SAML response relay state

use OneLogin\Saml2\Auth;

define('SOW_SSO_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SOW_SSO_PLUGIN_URL', plugin_dir_url(__FILE__));
define(
  'SOW_SSO_ACS_URL',
  SOW_SSO_PLUGIN_URL . 'sow-sso.php?acs'
);

include SOW_SSO_PLUGIN_DIR . 'settings-page.php';

if (get_site_option('sow_sso_enable_sso') === 'yes') {

  add_action('init', function () {

    require_once SOW_SSO_PLUGIN_DIR . 'vendor/autoload.php';

    // Define SAML settings
    $settings = array(
      'strict' => true,
      'debug' => true,
      'sp' => array(
        'entityId' => get_site_option('sow_sso_sp_entity_id'),
        'assertionConsumerService' => array(
          'url' => SOW_SSO_PLUGIN_URL,
        ),
        'NameIDFormat' => get_site_option('sow_sso_sp_name_id_format'),
      ),
      'idp' => array(
        'entityId' => get_site_option('sow_sso_idp_entity_id'),
        'singleSignOnService' => array(
          'url' => get_site_option('sow_sso_idp_sso_service_url'),
        ),
        'x509cert' => get_site_option('sow_sso_idp_509_certificate')
      ),
    );

    // Create a new SAML instance
    $auth = new Auth($settings);

    if (get_site_option('sow_sso_enable_backdoor') === 'yes' && isset($_GET['backdoor']) && sanitize_text_field($_GET['backdoor']) == get_site_option('sow_sso_backdoor_key')) {
    } else {
      add_action('login_form', function () use ($auth) {
        $auth->login();
      });
    }

    // Handle SAML response
    if (isset($_GET['acs'])) {
      $auth->processResponse();
      $errors = $auth->getErrors();
      if (empty($errors)) {
        $attributes = $auth->getAttributes();
        $email = $attributes['E-mail'][0];
        $user = get_user_by('email', $email);
        if ($user) {
          wp_set_auth_cookie($user->ID, get_site_option('sow_sso_remember_user_sessions') === 'yes' ? true : false);
          if (isset($_POST['RelayState'])) {
            $domain = parse_url(sanitize_text_field($_POST['RelayState']), PHP_URL_HOST);
            wp_redirect('https://' . $domain . '/wp-admin');
          } else {
            wp_redirect(home_url() . '/wp-admin');
          }
          exit;
        } else {
          echo 'User not found, please contact support';
          exit;
        }
      }
    }
  });
}
