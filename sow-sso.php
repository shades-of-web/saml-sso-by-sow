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


require_once 'constants.php';

include SOW_SSO_PLUGIN_DIR . 'settings-page.php';

if (get_site_option('sow_sso_enable_sso') === 'yes') {

  add_action('init', function () {
    if (get_site_option('sow_sso_enable_backdoor') === 'yes' && isset($_GET['backdoor']) && sanitize_text_field($_GET['backdoor']) == get_site_option('sow_sso_backdoor_key')) {
    } else {
      add_action('login_form', function () {
        include SOW_SSO_PLUGIN_DIR . 'sow-sso-login.php';
        exit;
      });
    }
  });
}
