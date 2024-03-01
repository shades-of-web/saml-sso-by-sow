<?php


add_action('network_admin_menu', function () {
  add_menu_page('SoW SSO', 'SoW SSO', 'manage_network_options', 'sow-sso-dashboard', 'sow_sso_dashboard_callback', 'dashicons-superhero-alt');
});

function sow_sso_dashboard_callback()
{
  $sow_sso_enable_sso = get_site_option('sow_sso_enable_sso') ?? false;
  $sow_sso_enable_backdoor = get_site_option('sow_sso_enable_backdoor') ?? false;
  $sow_sso_backdoor_key = get_site_option('sow_sso_backdoor_key') ?? '';
  $sow_sso_remember_user_sessions = get_site_option('sow_sso_remember_user_sessions') ?? false;
  $sow_sso_sp_entity_id = get_site_option('sow_sso_sp_entity_id') ?? '';
  $sow_sso_sp_name_id_format = get_site_option('sow_sso_sp_name_id_format') ?? '';
  $sow_sso_idp_entity_id = get_site_option('sow_sso_idp_entity_id') ?? '';
  $sow_sso_idp_sso_service_url = get_site_option('sow_sso_idp_sso_service_url') ?? '';
  $sow_sso_idp_509_certificate = get_site_option('sow_sso_idp_509_certificate') ?? '';
?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.ecmas.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <form method="post" action="<?php echo add_query_arg('action', 'sow-sso-save', 'edit.php') ?>">
    <?php wp_nonce_field('sow-sso-validate'); ?>

    <div class="container-fluid mt-3">
      <h1 class="h3">Shades of Web's SSO Integration Hub</h1>
      <hr />
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="d-flex flex-column gap-4">
            <h2 class="h4 mt-2">Global Toggles</h2>

            <div class="d-flex justify-content-start align-items-center gap-4">
              <h2 class="m-0 h5">Enable Plugin</h2>
              <input name="sow_sso_enable_sso" type="checkbox" value="yes" <?php checked('yes', $sow_sso_enable_sso) ?> data-toggle="toggle" data-size="sm">
            </div>
            <div class="d-flex justify-content-start align-items-center gap-4">
              <h2 class="m-0 h5">Enable Backdoor Login</h2>
              <input name="sow_sso_enable_backdoor" type="checkbox" value="yes" <?php checked('yes', $sow_sso_enable_backdoor) ?> data-toggle="toggle" data-size="sm">
              <input type="text" name="sow_sso_backdoor_key" class="form-control w-50" value='<?= $sow_sso_backdoor_key ?>'>
            </div>

            <div class="d-flex justify-content-start align-items-center gap-4">
              <h2 class="m-0 h5">Remember User Sessions</h2>
              <input name="sow_sso_remember_user_sessions" type="checkbox" value="yes" <?php checked('yes', $sow_sso_remember_user_sessions) ?> data-toggle="toggle" data-size="sm">
            </div>
            <hr />
            <h2 class="h4">Service Provider Configurations</h2>
            <div class="d-flex flex-column gap-3">
              <h2 class="m-0 h5">Entity ID</h2>
              <input name="sow_sso_sp_entity_id" type="text" class="form-control" value='<?= $sow_sso_sp_entity_id ?>'>
            </div>
            <div class="d-flex flex-column gap-3">
              <h2 class="m-0 h5">Name ID Format</h2>
              <input name="sow_sso_sp_name_id_format" type="text" class="form-control" value='<?= $sow_sso_sp_name_id_format ?>'>
            </div>
            <div class="d-flex flex-column gap-3">
              <h2 class="m-0 h5">ACS URL</h2>
              <input name="sow_sso_acs_url" type="text" class="form-control" value='<?= SOW_SSO_ACS_URL ?>' readonly>
            </div>
            <hr />
            <h2 class="h4">IDP Configurations</h2>
            <div class="d-flex flex-column gap-3">
              <h2 class="m-0 h5">Entity ID</h2>
              <input name="sow_sso_idp_entity_id" type="text" class="form-control" value='<?= $sow_sso_idp_entity_id ?>'>
            </div>
            <div class="d-flex flex-column gap-3">
              <h2 class="m-0 h5">SSO Service URL</h2>
              <input name="sow_sso_idp_sso_service_url" type="text" class="form-control" value='<?= $sow_sso_idp_sso_service_url ?>'>
            </div>
            <div class="d-flex flex-column gap-3">
              <h2 class="m-0 h5">x509 Certificate</h2>
              <textarea rows="6" name="sow_sso_idp_509_certificate" type="text" class="form-control"><?= $sow_sso_idp_509_certificate ?></textarea>
            </div>
          </div>
        </div>
        <div class=" col-6 d-none d-md-block text-right">
          <img src="<?= plugin_dir_url(__FILE__) ?>assets/images/SSO.png" alt="SSO Image" class="img-fluid w-75" />
        </div>
      </div>
    </div>
    <?php submit_button(); ?>
  </form>
<?php
}

add_action('network_admin_edit_sow-sso-save', 'sow_sso_config_save');

function sow_sso_config_save()
{

  check_admin_referer('sow-sso-validate'); // Nonce security check

  $sow_sso_enable_sso = isset($_POST['sow_sso_enable_sso']) && 'yes' === $_POST['sow_sso_enable_sso'] ? 'yes' : 'no';
  update_site_option('sow_sso_enable_sso', $sow_sso_enable_sso);

  $sow_sso_enable_backdoor = isset($_POST['sow_sso_enable_backdoor']) && 'yes' === $_POST['sow_sso_enable_backdoor'] ? 'yes' : 'no';
  update_site_option('sow_sso_enable_backdoor', $sow_sso_enable_backdoor);

  $sow_sso_remember_user_sessions = isset($_POST['sow_sso_remember_user_sessions']) && 'yes' === $_POST['sow_sso_remember_user_sessions'] ? 'yes' : 'no';
  update_site_option('sow_sso_remember_user_sessions', $sow_sso_remember_user_sessions);

  update_site_option('sow_sso_backdoor_key', sanitize_text_field($_POST['sow_sso_backdoor_key']));
  update_site_option('sow_sso_sp_entity_id', sanitize_text_field($_POST['sow_sso_sp_entity_id']));
  update_site_option('sow_sso_sp_name_id_format', sanitize_text_field($_POST['sow_sso_sp_name_id_format']));
  update_site_option('sow_sso_idp_entity_id', sanitize_text_field($_POST['sow_sso_idp_entity_id']));
  update_site_option('sow_sso_idp_sso_service_url', sanitize_text_field($_POST['sow_sso_idp_sso_service_url']));
  update_site_option('sow_sso_idp_509_certificate', sanitize_text_field($_POST['sow_sso_idp_509_certificate']));

  wp_safe_redirect(
    add_query_arg(
      array(
        'page' => 'sow-sso-dashboard',
        'updated' => true
      ),
      network_admin_url('admin.php')
    )
  );
  exit;
}
