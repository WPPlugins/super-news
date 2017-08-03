<?php
/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
/*
WARNING: This is a system configuration file, please DO NOT EDIT this file directly!
... Instead, use the plugin options panel in WordPress® to override these settings.
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/*
Determine the full url to the directory this plugin resides in.
*/
$GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["dir_url"] = (stripos (__FILE__, WP_CONTENT_DIR) !== 0) ? /* Have to assume plugins dir? */
plugins_url ("/" . basename (dirname (dirname (__FILE__)))) : /* Otherwise, this gives it a chance to live anywhere in the content dir. */
content_url (preg_replace ("/^(.*?)\/" . preg_quote (basename (WP_CONTENT_DIR), "/") . "/", "", str_replace (DIRECTORY_SEPARATOR, "/", dirname (dirname (__FILE__)))));
/*
Check if the plugin has been configured *should be set after the first config via options panel*.
*/
$GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["configured"] = get_option ("ws_plugin__super_news_configured");
/*
Configure the right menu options panel for this software.
*/
$GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["menu_pages"] = array ("installation" => false, "tools" => true, "videos" => false, "support" => true, "donations" => true);
/*
Configure checksum time for the syscon.inc.php file.
*/
$GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["checksum"] = filemtime (__FILE__);
/*
Configure & validate all of the plugin options; and set their defaults.
*/
if (!function_exists ("ws_plugin__super_news_configure_options_and_their_defaults"))
	{
		function ws_plugin__super_news_configure_options_and_their_defaults ($options = FALSE) /* Can also be used to merge options with defaults. */
			{
				/* Here we build the default options array, which will be merged with the user options.
				It is important to note that sometimes default options may not or should not be pre-filled on an options form.
				These defaults are for the system to use in various ways, we may choose not to pre-fill certain fields.
				In other words, some defaults may be used internally, but to the user, the option will be empty. */
				$default_options = apply_filters ("ws_plugin__super_news_default_options", array ( /* For filters. */
				/**/
				"options_checksum" => "", /* Used internally to maintain the integrity of all options in the array. */
				/**/
				"options_version" => "1.0", /* Used internally to maintain the integrity of all options in the array. */
				/**/
				"run_deactivation_routines" => "1", /* Should deactivation routines be processed? */
				/**/
				"google_key" => "", /* The Google Ajax Search API Key for this domain. */
				"thumb_key" => "", /* A Key to one of the integrated thumbnail services. */
				"thumb_provider" => "", /* (shrinktheweb|websnapr|thumbshots) or empty. */
				/**/
				"custom_injection" => "", /* Custom code that will be injected into results. */
				/**/
				"enqueue_styles" => "1")); /* Whether we should load the default styles. */
				/*
				Here they are merged. User options will overwrite some or all default values. 
				*/
				$GLOBALS["WS_PLUGIN__"]["super_news"]["o"] = array_merge ($default_options, ( ($options !== false) ? (array)$options : (array)get_option ("ws_plugin__super_news_options")));
				/*
				This builds an MD5 checksum for the full array of options. This also includes the config checksum and the current set of default options. 
				*/
				$checksum = md5 (($checksum_prefix = $GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["checksum"] . serialize ($default_options)) . serialize (array_merge ($GLOBALS["WS_PLUGIN__"]["super_news"]["o"], array ("options_checksum" => 0))));
				/*
				Validate each option, possibly reverting back to the default value if invalid.
				Also check if options were passed in on some of these, in case empty values are to be allowed. 
				*/
				if ($options !== false || ($GLOBALS["WS_PLUGIN__"]["super_news"]["o"]["options_checksum"] !== $checksum && $GLOBALS["WS_PLUGIN__"]["super_news"]["o"] !== $default_options))
					{
						foreach ($GLOBALS["WS_PLUGIN__"]["super_news"]["o"] as $key => &$value)
							{
								if (!isset ($default_options[$key]) && !preg_match ("/^pro_/", $key))
									unset ($GLOBALS["WS_PLUGIN__"]["super_news"]["o"][$key]);
								/**/
								else if ($key === "options_checksum" && (!is_string ($value) || !strlen ($value)))
									$value = $default_options[$key];
								/**/
								else if ($key === "options_version" && (!is_string ($value) || !is_numeric ($value)))
									$value = $default_options[$key];
								/**/
								else if ($key === "run_deactivation_routines" && (!is_string ($value) || !is_numeric ($value)))
									$value = $default_options[$key];
								/**/
								else if ($key === "google_key" && (!is_string ($value) || !strlen ($value)))
									$value = $default_options[$key];
								/**/
								else if ($key === "thumb_key" && (!is_string ($value) || !strlen ($value)))
									$value = $default_options[$key];
								/**/
								else if ($key === "thumb_provider" && (!is_string ($value) || !strlen ($value)))
									$value = $default_options[$key];
								/**/
								else if ($key === "custom_injection" && (!is_string ($value) || !strlen ($value)))
									$value = $default_options[$key];
								/**/
								else if ($key === "enqueue_styles" && (!is_string ($value) || !is_numeric ($value)))
									$value = $default_options[$key];
							}
						/**/
						$GLOBALS["WS_PLUGIN__"]["super_news"]["o"] = apply_filters_ref_array ("ws_plugin__super_news_options_before_checksum", array (&$GLOBALS["WS_PLUGIN__"]["super_news"]["o"]));
						/**/
						$GLOBALS["WS_PLUGIN__"]["super_news"]["o"]["options_checksum"] = md5 ($checksum_prefix . serialize (array_merge ($GLOBALS["WS_PLUGIN__"]["super_news"]["o"], array ("options_checksum" => 0))));
					}
				/**/
				return apply_filters_ref_array ("ws_plugin__super_news_options", array (&$GLOBALS["WS_PLUGIN__"]["super_news"]["o"]));
			}
	}
?>