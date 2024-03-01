<?php
ob_start();
?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // get sso_btn and make it as a sibling of the login form
    var sso_btn = document.querySelector('#sso_login_wrapper');
    var login_form = document.querySelector('#login');
    login_form.appendChild(sso_btn);
    document.querySelector('#loginform').remove();
  });
</script>

<div id="sso_login_wrapper">
  <style>
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
  <a href="<?= get_site_option('sow_sso_idp_sso_service_url'); ?>" id="sso_btn" class="button button-primary">Login with SSO</a>
</div>

<?php
echo ob_get_clean();
