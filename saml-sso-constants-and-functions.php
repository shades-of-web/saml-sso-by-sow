<?php

namespace SAMLSSO;

class SamlSsoConfig
{
  /**
   * The absolute path to the directory containing the SAML SSO plugin.
   * @var string
   */
  public static $pluginDir;

  /**
   * The URL to the directory containing the SAML SSO plugin.
   * @var string
   */
  public static $pluginUrl;

  /**
   * The URL used for the SAML Assertion Consumer Service (ACS).
   * This URL is typically called by the Identity Provider (IdP) after authentication.
   * @var string
   */
  public static $acsUrl;

  /**
   * Initialize the class properties.
   */
  public static function init()
  {
    self::$pluginDir = plugin_dir_path(__FILE__);
    self::$pluginUrl = plugin_dir_url(__FILE__);
    self::$acsUrl = self::$pluginUrl . 'saml-sso-acs.php?acs';
  }

  /**
   * Retrieves option data, considering a multisite environment.
   * @param string $option_name Name of the option to retrieve.
   * @return mixed The option value on success, false on failure.
   */
  public static function getOptionData(string $option_name)
  {
    return is_multisite() ? get_site_option($option_name) : get_option($option_name);
  }

  /**
   * Updates option data, considering a multisite environment.
   * @param string $option_name Name of the option to update.
   * @param mixed $option_value New value for the option.
   * @return bool True on success, false on failure.
   */
  public static function updateOptionData(string $option_name, $option_value)
  {
    return is_multisite() ? update_site_option($option_name, $option_value) : update_option($option_name, $option_value);
  }
}

// Initialize the configuration.
SamlSsoConfig::init();
