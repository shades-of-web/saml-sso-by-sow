<?php

// test

/**
 * SAML SSO Dashboard Page
 *
 * Integrates SAML SSO settings into the WordPress admin or network admin dashboard,
 * facilitating configuration of the SSO features and parameters.
 */

use SAMLSSO\SamlSsoConfig;

/**
 * Initializes the dashboard menu according to the site type (multisite or single).
 * Adds the SAML SSO settings page to the WordPress dashboard.
 */
$hook_suffix = is_multisite() ? 'network_admin_menu' : 'admin_menu';
add_action($hook_suffix, function () {
  $capability = is_multisite() ? 'manage_network_options' : 'manage_options';
  add_menu_page(
    'SAML SSO by Shades of Web',
    'SAML SSO by Shades of Web',
    $capability,
    'saml-sso-dashboard',
    'saml_sso_dashboard_callback',
    'dashicons-superhero-alt'
  );
});

/**
 * Callback function to display the content of the SAML SSO settings page.
 */
function saml_sso_dashboard_callback()
{
  include_once __DIR__ . '/page-saml-sso-dashboard.php';
}

/**
 * Saves the SAML SSO settings to the WordPress options table.
 */
is_multisite()
  ? add_action('network_admin_edit_sow-sso-save', 'saml_sso_config_save')
  : add_action('admin_post_sow-sso-save', 'saml_sso_config_save');

/**
 * Handles the saving of SAML SSO settings.
 */
function saml_sso_config_save()
{
  $saml_sso_enable_sso =
    isset($_POST['saml_sso_enable_sso']) && 'yes' === $_POST['saml_sso_enable_sso']
    ? 'yes' : 'no';

  SamlSsoConfig::updateOptionData(
    'saml_sso_enable_sso',
    $saml_sso_enable_sso
  );

  $saml_sso_enable_backdoor =
    isset($_POST['saml_sso_enable_backdoor']) && 'yes' === $_POST['saml_sso_enable_backdoor']
    ? 'yes' : 'no';

  SamlSsoConfig::updateOptionData(
    'saml_sso_enable_backdoor',
    $saml_sso_enable_backdoor
  );

  $saml_sso_remember_user_sessions =
    isset($_POST['saml_sso_remember_user_sessions']) && 'yes' === $_POST['saml_sso_remember_user_sessions']
    ? 'yes' : 'no';

  SamlSsoConfig::updateOptionData(
    'saml_sso_remember_user_sessions',
    $saml_sso_remember_user_sessions
  );

  SamlSsoConfig::updateOptionData(
    'saml_sso_backdoor_key',
    sanitize_text_field($_POST['saml_sso_backdoor_key'])
  );
  SamlSsoConfig::updateOptionData(
    'saml_sso_sp_entity_id',
    sanitize_text_field($_POST['saml_sso_sp_entity_id'])
  );
  SamlSsoConfig::updateOptionData(
    'saml_sso_sp_name_id_format',
    sanitize_text_field($_POST['saml_sso_sp_name_id_format'])
  );
  SamlSsoConfig::updateOptionData(
    'saml_sso_idp_entity_id',
    sanitize_text_field($_POST['saml_sso_idp_entity_id'])
  );
  SamlSsoConfig::updateOptionData(
    'saml_sso_idp_sso_service_url',
    sanitize_text_field($_POST['saml_sso_idp_sso_service_url'])
  );
  SamlSsoConfig::updateOptionData(
    'saml_sso_idp_509_certificate',
    sanitize_text_field($_POST['saml_sso_idp_509_certificate'])
  );

  wp_safe_redirect(
    add_query_arg(
      array(
        'page' => 'saml-sso-dashboard',
        'updated' => true
      ),
      is_multisite() ? network_admin_url('edit.php') : admin_url('admin.php')
    )
  );
  exit;
}
