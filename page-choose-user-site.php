<?php

// test

/**
 * User Sites Page Template
 *
 * This template is used to display the sites a user has access to after successful SAML authentication.
 * It should not be accessed directly but included from the main SAML authentication script where
 * $user (WP_User object) and $sites (array of site objects) are defined.
 */

// Prevent direct access to this template for security reasons.
if (!isset($user, $sites)) {
  wp_die('This template should not be accessed directly.');
}

use SAMLSSO\SamlSsoConfig;

wp_enqueue_style('saml-sso-by-sow-bootstrap', SamlSsoConfig::$PLUGIN_URL . 'assets/css/bs-5-3-3.css', array(), '5.3.3', 'all');
wp_enqueue_script('saml-sso-by-sow-bootstrap', SamlSsoConfig::$PLUGIN_URL . 'assets/js/bs-5-3-3.js', array(), '5.3.3', true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SAML SSO User Sites</title>
</head>

<body>
  <div class="container vh-100 d-flex flex-column align-items-center">
    <h1>SSO Login Success</h1>
    <p>Welcome, <?= esc_html($user->display_name); ?>!</p>
    <p>Here are the sites you have access to:</p>
    <div class="row">
      <?php foreach ($sites as $site) : ?>
        <div class="col-12 col-md-6 col-lg-4 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?= esc_html($site->blogname); ?></h5>
              <p class="card-text"><?= esc_html($site->siteurl); ?></p>
              <a href="<?= esc_url($site->siteurl . '/wp-admin/'); ?>" class="btn btn-primary">Go to Dashboard</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>

</html>