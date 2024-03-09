<?php

// test

/**
 * Custom SSO Integration for WordPress Login Page
 *
 * This script removes the default login form and replaces it with
 * a Single Sign-On (SSO) login button. It uses output buffering to modify
 * the login page content dynamically.
 */

use SAMLSSO\SamlSsoConfig;

wp_enqueue_style('saml-sso-by-sow-bootstrap', SamlSsoConfig::$pluginUrl . 'assets/css/bs-5-3-3.css', array(), '5.3.3', 'all');
wp_enqueue_script('saml-sso-by-sow-bootstrap', SamlSsoConfig::$pluginUrl . 'assets/js/bs-5-3-3.js', array(), '5.3.3', true);

// Start output buffering to capture the initial output
ob_start();

?>

<script>
  // Use DOMContentLoaded to ensure the DOM is fully loaded before manipulating
  document.addEventListener('DOMContentLoaded', function() {
    // Move the SSO login button into the login container and remove the standard login form
    var ssoBtnWrapper = document.querySelector('#sso_login_wrapper');
    var loginFormContainer = document.querySelector('#login');
    loginFormContainer.style.height = '100vh';
    loginFormContainer.style.width = '100%';
    loginFormContainer.style.padding = '0 !important';
    loginFormContainer.style.display = 'flex';
    loginFormContainer.style.flexDirection = 'column';
    loginFormContainer.style.justifyContent = 'center';
    loginFormContainer.style.alignItems = 'center';
    if (loginFormContainer && ssoBtnWrapper) {
      loginFormContainer.appendChild(ssoBtnWrapper); // Make the SSO button a child of the login container
      var loginForm = document.querySelector('#loginform');
      if (loginForm) {
        loginForm.remove(); // Remove the standard login form
      }
    }
  });
</script>

<div id="sso_login_wrapper">
  <!-- SSO login button with the URL fetched from site options -->
  <a href="<?= esc_url(SamlSsoConfig::getOptionData('saml_sso_idp_sso_service_url')); ?>" id="sso_btn" class="button button-primary text-center d-block w-100 text-decoration-none">Login with SSO</a>
</div>

<?php
// Flush the output buffer and clean it
echo ob_get_clean();
?>
