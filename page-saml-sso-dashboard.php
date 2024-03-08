<?php

/**
 * SAML SSO Dashboard Page Template
 *
 * Integrates SAML SSO settings into the WordPress admin or network admin dashboard,
 * facilitating configuration of the SSO features and parameters.
 */

wp_enqueue_script('saml-sso-by-sow-bootstrap5-toggle', SAML_SSO_PLUGIN_URL . 'assets/js/bs-toggle.js', array(), '5.0.4', true);
wp_enqueue_style('saml-sso-by-sow-bootstrap5-toggle', SAML_SSO_PLUGIN_URL . 'assets/css/bs-toggle.css', array(), '5.0.4', 'all');

wp_enqueue_style('saml-sso-by-sow-bootstrap', SAML_SSO_PLUGIN_URL . 'assets/css/bs-5-3-3.css', array(), '5.3.3', 'all');
wp_enqueue_script('saml-sso-by-sow-bootstrap', SAML_SSO_PLUGIN_URL . 'assets/js/bs-5-3-3.js', array(), '5.3.3', true);


$saml_sso_enable_sso = get_option_data('saml_sso_enable_sso') ?? false;
$saml_sso_enable_backdoor = get_option_data('saml_sso_enable_backdoor') ?? false;
$saml_sso_backdoor_key = get_option_data('saml_sso_backdoor_key') ?? '';
$saml_sso_remember_user_sessions = get_option_data('saml_sso_remember_user_sessions') ?? false;
$saml_sso_sp_entity_id = get_option_data('saml_sso_sp_entity_id') ?? '';
$saml_sso_sp_name_id_format = get_option_data('saml_sso_sp_name_id_format') ?? '';
$saml_sso_idp_entity_id = get_option_data('saml_sso_idp_entity_id') ?? '';
$saml_sso_idp_sso_service_url = get_option_data('saml_sso_idp_sso_service_url') ?? '';
$saml_sso_idp_509_certificate = get_option_data('saml_sso_idp_509_certificate') ?? '';
?>

<form method="post" action="<?= esc_url(add_query_arg('action', 'sow-sso-save', 'edit.php')); ?>">
  <div class="container-fluid mt-3">
    <h1 class="h3">SAML SSO by Shades of Web</h1>
    <hr />
    <div class="row">
      <div class="col-12 col-md-6">
        <div class="d-flex flex-column gap-4">
          <h2 class="h4 mt-2">Global Toggles</h2>

          <div class="d-flex justify-content-start align-items-center gap-4">
            <h2 class="m-0 h5">Enable Plugin</h2>
            <input name="saml_sso_enable_sso" type="checkbox" value="yes" <?php checked('yes', $saml_sso_enable_sso) ?> data-toggle="toggle" data-size="sm">
          </div>
          <div class="d-flex justify-content-start align-items-center gap-4">
            <h2 class="m-0 h5">Enable Backdoor Login</h2>
            <input name="saml_sso_enable_backdoor" type="checkbox" value="yes" <?php checked('yes', $saml_sso_enable_backdoor) ?> data-toggle="toggle" data-size="sm">
            <input type="text" name="saml_sso_backdoor_key" class="form-control w-50" value='<?= esc_html($saml_sso_backdoor_key); ?>'>
          </div>

          <div class="d-flex justify-content-start align-items-center gap-4">
            <h2 class="m-0 h5">Remember User Sessions</h2>
            <input name="saml_sso_remember_user_sessions" type="checkbox" value="yes" <?php checked('yes', $saml_sso_remember_user_sessions) ?> data-toggle="toggle" data-size="sm">
          </div>
          <hr />
          <h2 class="h4">Service Provider Configurations</h2>
          <div class="d-flex flex-column gap-3">
            <h2 class="m-0 h5">Entity ID</h2>
            <input name="saml_sso_sp_entity_id" type="text" class="form-control" value='<?= esc_html($saml_sso_sp_entity_id); ?>'>
          </div>
          <div class="d-flex flex-column gap-3">
            <h2 class="m-0 h5">Name ID Format</h2>
            <input name="saml_sso_sp_name_id_format" type="text" class="form-control" value='<?= esc_html($saml_sso_sp_name_id_format); ?>'>
          </div>
          <div class="d-flex flex-column gap-3">
            <h2 class="m-0 h5">ACS URL</h2>
            <input name="saml_sso_acs_url" type="text" class="form-control" value='<?= esc_url(SAML_SSO_ACS_URL); ?>' readonly>
          </div>
          <hr />
          <h2 class="h4">IDP Configurations</h2>
          <div class="d-flex flex-column gap-3">
            <h2 class="m-0 h5">Entity ID</h2>
            <input name="saml_sso_idp_entity_id" type="text" class="form-control" value='<?= esc_html($saml_sso_idp_entity_id); ?>'>
          </div>
          <div class="d-flex flex-column gap-3">
            <h2 class="m-0 h5">SSO Service URL</h2>
            <input name="saml_sso_idp_sso_service_url" type="text" class="form-control" value='<?= esc_url($saml_sso_idp_sso_service_url) ?>'>
          </div>
          <div class="d-flex flex-column gap-3">
            <h2 class="m-0 h5">x509 Certificate</h2>
            <textarea rows="6" name="saml_sso_idp_509_certificate" type="text" class="form-control"><?= esc_html($saml_sso_idp_509_certificate); ?></textarea>
          </div>
        </div>
      </div>
      <div class=" col-6 d-none d-md-block text-right">
        <img src="<?= esc_url(plugin_dir_url(__FILE__) . 'assets/images/SSO.png'); ?>" alt="SSO Image" class="img-fluid w-75" />
      </div>
    </div>
  </div>
  <?php submit_button(); ?>
</form>