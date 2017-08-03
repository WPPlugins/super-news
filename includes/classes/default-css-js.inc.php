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
if (!class_exists ("c_ws_plugin__super_news_default_css_js"))
	{
		class c_ws_plugin__super_news_default_css_js
			{
				/*
				Function that outputs the CSS for default styles.
				Attach to: add_action("init");
				*/
				public static function css ()
					{
						if ($_GET["ws_plugin__super_news_css"]) /* Call inner function? */
							{
								return c_ws_plugin__super_news_default_css_js_in::css ();
							}
					}
			}
	}
?>