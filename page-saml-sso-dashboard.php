<?php

/**
 * SAML SSO Dashboard Page Template
 *
 * Integrates SAML SSO settings into the WordPress admin or network admin dashboard,
 * facilitating configuration of the SSO features and parameters.
 */

use SAMLSSO\SamlSsoConfig;


wp_enqueue_script(
  'saml-sso-by-sow-bootstrap5-toggle',
  SamlSsoConfig::$pluginUrl . 'assets/js/bs-toggle.js',
  array(),
  '5.0.4',
  true
);
wp_enqueue_style(
  'saml-sso-by-sow-bootstrap5-toggle',
  SamlSsoConfig::$pluginUrl . 'assets/css/bs-toggle.css',
  array(),
  '5.0.4',
  'all'
);

wp_enqueue_style(
  'saml-sso-by-sow-bootstrap',
  SamlSsoConfig::$pluginUrl . 'assets/css/bs-5-3-3.css',
  array(),
  '5.3.3',
  'all'
);
wp_enqueue_script(
  'saml-sso-by-sow-bootstrap',
  SamlSsoConfig::$pluginUrl . 'assets/js/bs-5-3-3.js',
  array(),
  '5.3.3',
  true
);


$enable_sso = SamlSsoConfig::getOptionData('saml_sso_enable_sso') ?? false;
$enable_backdoor = SamlSsoConfig::getOptionData('saml_sso_enable_backdoor') ?? false;
$backdoor_key = SamlSsoConfig::getOptionData('saml_sso_backdoor_key') ?? '';
$remember_user_sessions = SamlSsoConfig::getOptionData('saml_sso_remember_user_sessions') ?? false;
$sp_entity_id = SamlSsoConfig::getOptionData('saml_sso_sp_entity_id') ?? '';
$sp_name_id_format = SamlSsoConfig::getOptionData('saml_sso_sp_name_id_format') ?? '';
$idp_entity_id = SamlSsoConfig::getOptionData('saml_sso_idp_entity_id') ?? '';
$idp_sso_service_url = SamlSsoConfig::getOptionData('saml_sso_idp_sso_service_url') ?? '';
$idp_509_certificate = SamlSsoConfig::getOptionData('saml_sso_idp_509_certificate') ?? '';

$plugin_image_url = SamlSsoConfig::$pluginUrl . 'assets/images/SSO.png'
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
            <input name="saml_sso_enable_sso" type="checkbox" value="yes" <?php checked('yes', $enable_sso) ?>
              data-toggle="toggle" data-size="sm">
          </div>
          <div class="d-flex justify-content-start align-items-center gap-4">
            <h2 class="m-0 h5">Enable Backdoor Login</h2>
            <input name="saml_sso_enable_backdoor" type="checkbox" value="yes" data-toggle="toggle" data-size="sm" <?php checked('yes', $enable_backdoor) ?>>
            <input type="text" name="saml_sso_backdoor_key" class="form-control w-50"
              value='<?= esc_html($backdoor_key); ?>'>
          </div>

          <div class="d-flex justify-content-start align-items-center gap-4">
            <h2 class="m-0 h5">Remember User Sessions</h2>
            <input name="saml_sso_remember_user_sessions" type="checkbox" value="yes" <?php checked('yes', $remember_user_sessions) ?> data-toggle="toggle" data-size="sm">
          </div>
          <hr />
          <h2 class="h4">Service Provider Configurations</h2>
          <div class="d-flex flex-column gap-3">
            <h2 class="m-0 h5">Entity ID</h2>
            <input name="saml_sso_sp_entity_id" type="text" class="form-control"
              value='<?= esc_html($sp_entity_id); ?>'>
          </div>
          <div class="d-flex flex-column gap-3">
            <h2 class="m-0 h5">Name ID Format</h2>
            <input name="saml_sso_sp_name_id_format" type="text" class="form-control"
              value='<?= esc_html($sp_name_id_format); ?>'>
          </div>
          <div class="d-flex flex-column gap-3">
            <h2 class="m-0 h5">ACS URL</h2>
            <input name="saml_sso_acs_url" type="text" class="form-control"
              value='<?= esc_url(SamlSsoConfig::$acsUrl); ?>' readonly>
          </div>
          <hr />
          <h2 class="h4">IDP Configurations</h2>
          <div class="d-flex flex-column gap-3">
            <h2 class="m-0 h5">Entity ID</h2>
            <input name="saml_sso_idp_entity_id" type="text" class="form-control"
              value='<?= esc_html($idp_entity_id); ?>'>
          </div>
          <div class="d-flex flex-column gap-3">
            <h2 class="m-0 h5">SSO Service URL</h2>
            <input name="saml_sso_idp_sso_service_url" type="text" class="form-control"
              value='<?= esc_url($idp_sso_service_url) ?>'>
          </div>
          <div class="d-flex flex-column gap-3">
            <h2 class="m-0 h5">x509 Certificate</h2>
            <textarea rows="6" name="saml_sso_idp_509_certificate" type="text" class="form-control">
              <?= esc_html($idp_509_certificate); ?>
            </textarea>
          </div>
        </div>
      </div>
      <div class=" col-6 d-none d-md-block text-right">
        <img src="<?= esc_url($plugin_image_url); ?>" alt="SSO Logo" class="img-fluid w-75" />
      </div>
    </div>
  </div>
  <?php submit_button(); ?>
</form>