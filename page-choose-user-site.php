<?php

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Sites</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
  <div class="container vh-100 d-flex flex-column align-items-center">
    <h1>SSO Login Success</h1>
    <p>Welcome, <?php echo htmlspecialchars($user->display_name); ?>!</p>
    <p>Here are the sites you have access to:</p>
    <div class="row">
      <?php foreach ($sites as $site) : ?>
        <div class="col-12 col-md-6 col-lg-4 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($site->blogname); ?></h5>
              <p class="card-text"><?php echo htmlspecialchars($site->siteurl); ?></p>
              <a href="<?php echo htmlspecialchars($site->siteurl); ?>/wp-admin/" class="btn btn-primary">Go to Dashboard</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>

</html>