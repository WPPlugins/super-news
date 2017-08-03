<?php
/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__super_news_menu_pages"))
	{
		class c_ws_plugin__super_news_menu_pages
			{
				/*
				Function that saves all options from any page.
				Options can also be passed in directly.
					Can also be self-verified.
				*/
				public static function update_all_options ($new_options = FALSE, $verified = FALSE, $update_other = TRUE, $display_notices = TRUE, $enqueue_notices = FALSE, $request_refresh = FALSE)
					{
						do_action ("ws_plugin__super_news_before_update_all_options", get_defined_vars ()); /* If you use this Hook, be sure to use `wp_verify_nonce()`. */
						/**/
						if ($verified || ( ($nonce = $_POST["ws_plugin__super_news_options_save"]) && wp_verify_nonce ($nonce, "ws-plugin--super-news-options-save")))
							{
								$options = $GLOBALS["WS_PLUGIN__"]["super_news"]["o"]; /* Here we get all of the existing options. */
								$new_options = (is_array ($new_options)) ? $new_options : (array)$_POST; /* Force array. */
								$new_options = c_ws_plugin__super_news_utils_strings::trim_deep (stripslashes_deep ($new_options));
								/**/
								foreach ((array)$new_options as $key => $value) /* Looking for relevant keys. */
									if (preg_match ("/^" . preg_quote ("ws_plugin__super_news_", "/") . "/", $key))
										/**/
										if ($key === "ws_plugin__super_news_configured") /* Configured. */
											{
												update_option ("ws_plugin__super_news_configured", $value);
												$GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["configured"] = $value;
											}
										else /* Place this option into the array. Remove ws_plugin__super_news_. */
											{
												(is_array ($value)) ? array_shift ($value) : null; /* Arrays should be padded. */
												$key = preg_replace ("/^" . preg_quote ("ws_plugin__super_news_", "/") . "/", "", $key);
												$options[$key] = $value; /* Overriding a possible existing option. */
											}
								/**/
								$options["options_version"] = (string) ($options["options_version"] + 0.001);
								$options = ws_plugin__super_news_configure_options_and_their_defaults ($options);
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__super_news_during_update_all_options", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								update_option ("ws_plugin__super_news_options", $options);
								/**/
								if (($display_notices === true || in_array ("success", (array)$display_notices)) && ($notice = '<strong>Options saved.' . (($request_refresh) ? ' Please <a href="' . esc_attr ($_SERVER["REQUEST_URI"]) . '">refresh</a>.' : '') . '</strong>'))
									($enqueue_notices === true || in_array ("success", (array)$enqueue_notices)) ? c_ws_plugin__super_news_admin_notices::enqueue_admin_notice ($notice, "*:*") : c_ws_plugin__super_news_admin_notices::display_admin_notice ($notice);
								/**/
								$updated_all_options = true; /* Flag indicating this routine was indeed processed. */
							}
						/**/
						do_action ("ws_plugin__super_news_after_update_all_options", get_defined_vars ());
						/**/
						return $updated_all_options; /* Return status update. */
					}
				/*
				Add the options menus & sub-menus.
				Attach to: add_action("admin_menu");
				*/
				public static function add_admin_options ()
					{
						do_action ("ws_plugin__super_news_before_add_admin_options", get_defined_vars ());
						/**/
						add_filter ("plugin_action_links", "c_ws_plugin__super_news_menu_pages::_add_settings_link", 10, 2);
						/**/
						if (apply_filters ("ws_plugin__super_news_during_add_admin_options_create_menu_items", true, get_defined_vars ()))
							{
								add_menu_page ("Super News", "Super News", "edit_posts", "ws-plugin--super-news-search", "c_ws_plugin__super_news_menu_pages::search_page");
								/**/
								if (apply_filters ("ws_plugin__super_news_during_add_admin_options_add_search_page", true, get_defined_vars ()))
									add_submenu_page ("ws-plugin--super-news-search", "Super News Search Engine", "Search Engine", "edit_posts", "ws-plugin--super-news-search", "c_ws_plugin__super_news_menu_pages::search_page");
								/**/
								if (apply_filters ("ws_plugin__super_news_during_add_admin_options_add_options_page", true, get_defined_vars ()))
									add_submenu_page ("ws-plugin--super-news-search", "Super News Config Options", "Config Options", "edit_plugins", "ws-plugin--super-news-options", "c_ws_plugin__super_news_menu_pages::options_page");
								/**/
								if (apply_filters ("ws_plugin__super_news_during_add_admin_options_add_info_page", true, get_defined_vars ()))
									add_submenu_page ("ws-plugin--super-news-search", "Super News Info", "Super News Info", "edit_plugins", "ws-plugin--super-news-info", "c_ws_plugin__super_news_menu_pages::info_page");
							}
						/**/
						do_action ("ws_plugin__super_news_after_add_admin_options", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				A sort of callback function to add the settings link.
				Attach to: add_filter("plugin_action_links");
				*/
				public static function _add_settings_link ($links = array (), $file = "")
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__super_news_before_add_settings_link", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (preg_match ("/" . preg_quote ($file, "/") . "$/", $GLOBALS["WS_PLUGIN__"]["super_news"]["l"]) && is_array ($links))
							{
								$settings = '<a href="' . esc_attr (admin_url ("/admin.php?page=ws-plugin--super-news-options")) . '">Settings</a>';
								array_unshift ($links, $settings);
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__super_news_during_add_settings_link", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						return apply_filters ("_ws_plugin__super_news_add_settings_link", $links, get_defined_vars ());
					}
				/*
				Add scripts to admin panels.
				Attach to: add_action("admin_print_scripts");
				*/
				public static function add_admin_scripts ()
					{
						do_action ("ws_plugin__super_news_before_add_admin_scripts", get_defined_vars ());
						/**/
						if ($_GET["page"] && preg_match ("/ws-plugin--super-news-/", $_GET["page"]))
							{
								wp_enqueue_script ("jquery");
								wp_enqueue_script ("thickbox");
								wp_enqueue_script ("media-upload");
								wp_enqueue_script ("jquery-ui-core");
								wp_enqueue_script ("jquery-json-ps", $GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["dir_url"] . "/includes/menu-pages/jquery-json-ps-min.js", array ("jquery"), c_ws_plugin__super_news_utilities::ver_checksum ());
								wp_enqueue_script ("jquery-ui-effects", $GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["dir_url"] . "/includes/menu-pages/jquery-ui-effects.js", array ("jquery", "jquery-ui-core"), c_ws_plugin__super_news_utilities::ver_checksum ());
								/**/
								if ($_GET["page"] === "ws-plugin--super-news-search")
									{
										wp_enqueue_script ("google-jsapi", "http://www.google.com/jsapi?key=" . urlencode ($GLOBALS["WS_PLUGIN__"]["super_news"]["o"]["google_key"]));
										wp_enqueue_script ("jquery-md5", $GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["dir_url"] . "/includes/jquery.md5-min.js", array ("jquery"), c_ws_plugin__super_news_utilities::ver_checksum ());
									}
								/**/
								wp_enqueue_script ("ws-plugin--super-news-menu-pages", site_url ("/?ws_plugin__super_news_menu_pages_js=" . urlencode (mt_rand ())), array ("jquery", "thickbox", "media-upload", "jquery-json-ps", "jquery-ui-core", "jquery-ui-effects"), c_ws_plugin__super_news_utilities::ver_checksum ());
								/**/
								do_action ("ws_plugin__super_news_during_add_admin_scripts", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__super_news_after_add_admin_scripts", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Add styles to admin panels.
				Attach to: add_action("admin_print_styles");
				*/
				public static function add_admin_styles ()
					{
						do_action ("ws_plugin__super_news_before_add_admin_styles", get_defined_vars ());
						/**/
						if ($_GET["page"] && preg_match ("/ws-plugin--super-news-/", $_GET["page"]))
							{
								wp_enqueue_style ("thickbox");
								wp_enqueue_style ("ws-plugin--super-news-menu-pages", site_url ("/?ws_plugin__super_news_menu_pages_css=" . urlencode (mt_rand ())), array ("thickbox"), c_ws_plugin__super_news_utilities::ver_checksum (), "all");
								/**/
								do_action ("ws_plugin__super_news_during_add_admin_styles", get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__super_news_after_add_admin_styles", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Function for building and handling the search page.
				*/
				public static function search_page ()
					{
						do_action ("ws_plugin__super_news_before_search_page", get_defined_vars ());
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/search.inc.php";
						/**/
						do_action ("ws_plugin__super_news_after_search_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Function for building and handling the options page.
				*/
				public static function options_page ()
					{
						do_action ("ws_plugin__super_news_before_options_page", get_defined_vars ());
						/**/
						c_ws_plugin__super_news_menu_pages::update_all_options ();
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/options.inc.php";
						/**/
						do_action ("ws_plugin__super_news_after_options_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
				/*
				Function for building and handling the info page.
				*/
				public static function info_page ()
					{
						do_action ("ws_plugin__super_news_before_info_page", get_defined_vars ());
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/info.inc.php";
						/**/
						do_action ("ws_plugin__super_news_after_info_page", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>