<?php

/**
 * Plugin Name: SAML SSO by SoW
 * Plugin URI: https://www.shadesofweb.com/
 * Description: Streamline user authentication with seamless SSO integration between your IDP and WordPress. Simplify user experience and enhance security.
 * Version: 1.0.0
 * Author: Shades of Web
 * Author URI: https://www.shadesofweb.com/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: saml-sso-by-sow
 * Network: true
 */

include_once __DIR__ . '/saml-sso-constants-and-functions.php';

use SAMLSSO\SamlSsoConfig;

// include_oncethe SAML SSO dashboard page setup.
include_once __DIR__ . '/saml-sso-dashboard-page.php';

// Enable SSO functionality if it is enabled in the plugin settings.
if (SamlSsoConfig::getOptionData('saml_sso_enable_sso') === 'yes') {

  add_action('init', function () {
    // Backdoor access check if enabled.
    if (SamlSsoConfig::getOptionData('saml_sso_enable_backdoor') === 'yes' && isset ($_GET['backdoor']) && sanitize_text_field($_GET['backdoor']) == SamlSsoConfig::getOptionData('saml_sso_backdoor_key')) {
      // Mail wp-admin for the backdoor access.
      wp_mail(get_option('admin_email'), 'Backdoor Access', 'Backdoor access to wp-admin has been used.');
    } else {
      // Replace default login form with SSO login if backdoor is not used
      add_action('login_form', function () {
        include_once __DIR__ . '/saml-sso-login.php';
        exit;
      });
    }
  });
}
