<?php

use OneLogin\Saml2\Auth;

// load wordpress environment wp-load.php
require_once dirname(__DIR__, 3) . '/wp-load.php';

require_once 'constants.php';

// Include necessary files
require_once __DIR__ . '/vendor/autoload.php';

// Define SAML settings (assuming they are defined in the main plugin file)
$settings = array(
  'strict' => true,
  'debug' => true,
  'sp' => array(
    'entityId' => get_site_option('sow_sso_sp_entity_id'),
    'assertionConsumerService' => array(
      'url' => SOW_SSO_ACS_URL,
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

// Process SAML response
$auth->processResponse();
$errors = $auth->getErrors();
if (empty($errors)) {
  $attributes = $auth->getAttributes();
  $email = $attributes['E-mail'][0];
  $user = get_user_by('email', $email);
  if ($user) {
    wp_set_auth_cookie($user->ID, get_site_option('sow_sso_remember_user_sessions') === 'yes' ? true : false);

    // if (is_super_admin($user->ID)) {
    //   wp_redirect(network_admin_url());
    // } {
    $sites = get_blogs_of_user($user->ID);
    ob_start();
    wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css');
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <div class="container" style="height: 100vh; display: flex; flex-direction: column; align-items: center;">
      <h1>SSO Login Success</h1>
      <p>Welcome, <?php echo $user->display_name; ?>!</p>
      <p>Here are the sites you have access to:</p>
      <div class="row">
        <?php foreach ($sites as $site) :
          // var_dump($site);
        ?>
          <!-- <li><a href="<?php echo $site->siteurl; ?>/wp-admin/"><?php echo $site->blogname; ?></a></li> -->
          <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"><?php echo $site->blogname; ?></h5>
                <p class="card-text"><?php echo $site->siteurl; ?></p>
                <a href="<?php echo $site->siteurl; ?>/wp-admin/" class="btn btn-primary">Go to Dashboard</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php
    $output = ob_get_clean();
    echo $output;
    // }
    exit;
  } else {
    ob_start();
  ?>
    <div style="background: url('https://images.pexels.com/photos/1888015/pexels-photo-1888015.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1') no-repeat center center; background-size: cover; height: 100vh; display: flex; flex-direction: column; align-items: center;">
      <h1>SSO Login Error</h1>
      <p>Sorry, we couldn't find a user with the email address provided. Please contact the administrator for further assistance.</p>
    </div>
<?php
    $output = ob_get_clean();
    echo $output;
    exit;
  }
} else {
  // Handle errors
  echo 'SAML response processing error';
  exit;
}
