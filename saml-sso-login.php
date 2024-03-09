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

// Start output buffering to capture the initial output
ob_start();
?>

<script>
  // Use DOMContentLoaded to ensure the DOM is fully loaded before manipulating
  document.addEventListener('DOMContentLoaded', function() {
    // Move the SSO login button into the login container and remove the standard login form
    var ssoBtnWrapper = document.querySelector('#sso_login_wrapper');
    var loginFormContainer = document.querySelector('#login');
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
  <style>
    /* Custom styles for the login page and SSO button */
    #login {
      height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 0 !important;
    }

    #sso_btn {
      text-align: center;
      text-decoration: none;
      display: inline-block;
      width: 100%;
    }
  </style>
  <!-- SSO login button with the URL fetched from site options -->
  <a href="<?= esc_url(SamlSsoConfig::getOptionData('saml_sso_idp_sso_service_url')); ?>" id="sso_btn" class="button button-primary">Login with SSO</a>
</div>

<?php
// Flush the output buffer and clean it
echo ob_get_clean();
?>