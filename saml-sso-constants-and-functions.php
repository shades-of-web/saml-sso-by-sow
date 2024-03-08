<?php

/**
 * SAML SSO Configuration Constants
 *
 * This script sets up constants used throughout the SAML SSO plugin, including
 * paths and URLs necessary for plugin operation and SAML assertions.
 */

/**
 * The absolute path to the directory containing the SAML SSO plugin.
 * @var DirectoryPath - The absolute path to the directory containing the SAML SSO plugin.
 */
define('SAML_SSO_PLUGIN_DIR', plugin_dir_path(__FILE__));

/**
 * The URL to the directory containing the SAML SSO plugin.
 * @var DirectoryURL - The URL to the directory containing the SAML SSO plugin.
 */
define('SAML_SSO_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * The URL used for the SAML Assertion Consumer Service (ACS).
 * This URL is typically called by the Identity Provider (IdP) after authentication.
 * @var SAML_ACS_URL - The URL used for the SAML Assertion Consumer Service (ACS).
 */
define('SAML_SSO_ACS_URL', SAML_SSO_PLUGIN_URL . 'saml-sso-acs.php?acs');


/**
 * Retrieves option data, considering multisite environment.
 *
 * @param string $option_name Name of the option to retrieve.
 * @return string|bool The option value on success, false on failure.
 */
function get_option_data($option_name)
{
  return is_multisite() ? get_site_option($option_name) : get_option($option_name);
}

/**
 * Updates option data, considering multisite environment.
 *
 * @param string $option_name Name of the option to update.
 * @param mixed $option_value New value for the option.
 * @return string|bool The option value on success, false on failure.
 */
function update_option_data($option_name, $option_value)
{
  return is_multisite() ? update_site_option($option_name, $option_value) : update_option($option_name, $option_value);
}
