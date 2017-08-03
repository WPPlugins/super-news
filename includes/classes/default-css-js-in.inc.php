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
if (!class_exists ("c_ws_plugin__super_news_default_css_js_in"))
	{
		class c_ws_plugin__super_news_default_css_js_in
			{
				/*
				Function that outputs the CSS for default styles.
				Attach to: add_action("init");
				*/
				public static function css ()
					{
						do_action ("ws_plugin__super_news_before_css", get_defined_vars ());
						/**/
						if ($_GET["ws_plugin__super_news_css"]) /* Incoming request? */
							{
								header ("Content-Type: text/css; charset=utf-8");
								header ("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("+1 week")) . " GMT");
								header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
								header ("Cache-Control: max-age=604800");
								header ("Pragma: public");
								/**/
								$u = $GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["dir_url"];
								$i = $GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["dir_url"] . "/images";
								/**/
								ob_start ("c_ws_plugin__super_news_utils_css::compress_css");
								/**/
								include_once dirname (dirname (__FILE__)) . "/super-news.css";
								/**/
								do_action ("ws_plugin__super_news_during_css", get_defined_vars ());
								/**/
								exit (); /* Clean exit. */
							}
						/**/
						do_action ("ws_plugin__super_news_after_css", get_defined_vars ());
					}
			}
	}
?>