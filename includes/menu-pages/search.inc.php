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
/*
Info page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2>Super News</h2>' . "\n";
/**/
echo '<table class="ws-menu-page-table">' . "\n";
echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
echo '<tr class="ws-menu-page-table-tr">' . "\n";
echo '<td class="ws-menu-page-table-l">' . "\n";
/**/
if (get_option ("ws_plugin__super_news_configured") && $GLOBALS["WS_PLUGIN__"]["super_news"]["o"]["google_key"])
	{
		echo '<form method="post" name="ws_plugin__super_news_search_form" id="ws-plugin--super-news-search-form" onsubmit="return false;">' . "\n";
		echo '<input type="hidden" name="ws_plugin__super_news_search" id="ws-plugin--super-news-search" value="' . esc_attr (wp_create_nonce ("ws-plugin--super-news-search")) . '" />' . "\n";
		/**/
		do_action ("ws_plugin__super_news_during_search_page_before_left_sections", get_defined_vars ());
		/**/
		if (apply_filters ("ws_plugin__super_news_during_search_page_during_left_sections_display_search", true, get_defined_vars ()))
			{
				do_action ("ws_plugin__super_news_during_search_page_during_left_sections_before_search", get_defined_vars ());
				/**/
				echo '<div class="ws-menu-page-group" title="Super News Search Engine" default-state="open">' . "\n";
				/**/
				echo '<div class="ws-menu-page-section ws-plugin--super-news-search-section">' . "\n";
				echo '<h3>Search Billions Of Articles ( based on keyword searches )</h3>' . "\n";
				echo '<img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["dir_url"]) . '/images/small-logo.png" class="ws-menu-page-right" style="width:250px; height:77px;" alt="" />' . "\n";
				echo '<p>The Super News plugin works as a specialized search engine for blogs.</p>';
				echo '<p>Super News prepares Cut\'n Paste Content ( based on specific search terms that you supply ). Ultimately, the content that it prepares, comes to you in a list of links that point to other sites; which are all powered by blog-publishing platforms ( such as WordPress®, Blogger, Movable Type, Joomla, and many others ).</p>' . "\n";
				echo '<p>Super News also prepares thumbnail image screenshots, for each article that it finds; making the list of links more attractive to your visitors. <em>*Note* It\'s normal for "queued thumbnails" to load up initially; ( this happens on sites that are NOT yet archived ). By the time you copy/paste the code into a Post and publish it; they\'ll all be available, so no worries :-)</em></p>' . "\n";
				do_action ("ws_plugin__super_news_during_search_page_during_left_sections_during_search", get_defined_vars ());
				/**/
				echo '<table class="form-table">' . "\n";
				echo '<tbody>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<th colspan="3">' . "\n";
				echo '<label for="ws-plugin--super-news-search-q">' . "\n";
				echo 'Enter Search Terms: <img id="ws-plugin--super-news-loading-animation" src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["dir_url"]) . '/images/ajax-loader.gif" alt="" />' . "\n";
				echo '</label>' . "\n";
				echo '</th>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<td style="min-width:300px;">' . "\n";
				echo '<input type="text" name="ws_plugin__super_news_search_q" id="ws-plugin--super-news-search-q" value="" />' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '<td nowrap="nowrap">' . "\n";
				echo '<input type="button" name="ws_plugin__super_news_search_new" id="ws-plugin--super-news-search-new" class="button-primary" value="New Result Set" /> <input type="button" name="ws_plugin__super_news_search_add" id="ws-plugin--super-news-search-add" class="button-primary" value="+ Add Results" title="This prepends new results onto a current Result Set. * Pagination is disabled when adding/removing results to achieve a custom list." />' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '<td nowrap="nowrap">' . "\n";
				echo '<div id="ws-plugin--super-news-search-branding"></div>' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr colspan="3">' . "\n";
				/**/
				echo '<td>' . "\n";
				echo '<strong>Order By:</strong> <input type="radio" name="ws_plugin__super_news_search_o" id="ws-plugin--super-news-search-o-date" value="date" checked="checked" /> <label for="ws-plugin--super-news-search-o-date">Date ( newest articles first<em>!</em> )</label> <input type="radio" name="ws_plugin__super_news_search_o" id="ws-plugin--super-news-search-o-relevance" value="relevance" /> <label for="ws-plugin--super-news-search-o-relevance">Relevance</label>' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '</tbody>' . "\n";
				echo '</table>' . "\n";
				echo '</div>' . "\n";
				/**/
				echo '<div class="ws-menu-page-hr ws-plugin--super-news-results-section-hr"></div>' . "\n";
				/**/
				echo '<div class="ws-menu-page-section ws-plugin--super-news-results-section">' . "\n";
				echo '<table class="form-table">' . "\n";
				echo '<tbody>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<td>' . "\n";
				echo '<div id="ws-plugin--super-news-search-results"></div>' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '</tbody>' . "\n";
				echo '</table>' . "\n";
				echo '</div>' . "\n";
				/**/
				echo '<div class="ws-menu-page-hr ws-plugin--super-news-snippet-section-hr"></div>' . "\n";
				/**/
				echo '<div class="ws-menu-page-section ws-plugin--super-news-snippet-section">' . "\n";
				echo '<table class="form-table">' . "\n";
				echo '<tbody>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<th colspan="3">' . "\n";
				echo '<label for="ws-plugin--super-news-search-snippet">' . "\n";
				echo 'Cut\'n Paste Code Snippet ( pop this into a new Post<em>!</em> )' . "\n";
				echo '</label>' . "\n";
				echo '</th>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<td>' . "\n";
				echo '<textarea name="ws_plugin__super_news_search_snippet" id="ws-plugin--super-news-search-snippet" rows="10" spellcheck="false" onclick="this.select();"></textarea>' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '</tbody>' . "\n";
				echo '</table>' . "\n";
				echo '</div>' . "\n";
				/**/
				echo '<div class="ws-menu-page-hr ws-plugin--super-news-pagination-section-hr"></div>' . "\n";
				/**/
				echo '<div class="ws-menu-page-section ws-plugin--super-news-pagination-section">' . "\n";
				echo '<table class="form-table">' . "\n";
				echo '<tbody>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<td>' . "\n";
				echo '<b>Pagination:</b> <span id="ws-plugin--super-news-search-pagination"></span>' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '</tbody>' . "\n";
				echo '</table>' . "\n";
				echo '</div>' . "\n";
				/**/
				echo '</div>' . "\n";
				/**/
				do_action ("ws_plugin__super_news_during_search_page_during_left_sections_after_search", get_defined_vars ());
			}
		/**/
		do_action ("ws_plugin__super_news_during_search_page_after_left_sections", get_defined_vars ());
		/**/
		echo '</form>' . "\n";
	}
else /* They need to first configure the options. */
	echo '<p>Please configure your API Keys first, then you can search all you like<em>!</em></p>';
/**/
echo '</td>' . "\n";
/**/
echo '<td class="ws-menu-page-table-r">' . "\n";
/**/
do_action ("ws_plugin__super_news_during_search_page_before_right_sections", get_defined_vars ());
do_action ("ws_plugin__super_news_during_menu_pages_before_right_sections", get_defined_vars ());
/**/
echo ($GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["menu_pages"]["installation"]) ? '<div class="ws-menu-page-installation"><a href="' . esc_attr (c_ws_plugin__super_news_readmes::parse_readme_value ("Professional Installation URI")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["dir_url"]) . '/images/brand-installation.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["menu_pages"]["tools"]) ? '<div class="ws-menu-page-tools"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["dir_url"]) . '/images/brand-tools.png" alt="." /></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["menu_pages"]["videos"]) ? '<div class="ws-menu-page-videos"><a href="' . esc_attr (c_ws_plugin__super_news_readmes::parse_readme_value ("Video Tutorials")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["dir_url"]) . '/images/brand-videos.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["menu_pages"]["support"]) ? '<div class="ws-menu-page-support"><a href="' . esc_attr (c_ws_plugin__super_news_readmes::parse_readme_value ("Forum URI")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["dir_url"]) . '/images/brand-support.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["menu_pages"]["donations"]) ? '<div class="ws-menu-page-donations"><a href="' . esc_attr (c_ws_plugin__super_news_readmes::parse_readme_value ("Donate link")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["super_news"]["c"]["dir_url"]) . '/images/brand-donations.png" alt="." /></a></div>' . "\n" : '';
/**/
do_action ("ws_plugin__super_news_during_menu_pages_after_right_sections", get_defined_vars ());
do_action ("ws_plugin__super_news_during_search_page_after_right_sections", get_defined_vars ());
/**/
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '</div>' . "\n";
?>