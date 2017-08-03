/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
/*
These routines are all specific to this software.
*/
jQuery(document).ready (function($)
	{
		if (location.href.match (/page\=ws-plugin--super-news-search/))
			{
				var superNews = new google.search.BlogSearch (), thumbProvider, customInjection, splitCi;
				global_superNews = {$: superNews, new__add: 'new', results: '', del: null};
				/**/
				superNews.setNoHtmlGeneration ();
				superNews.setUserDefinedLabel ('Super News');
				superNews.setResultOrder (google.search.Search.ORDER_BY_DATE);
				superNews.setResultSetSize (google.search.Search.LARGE_RESULTSET);
				/**/
				$('div#ws-plugin--super-news-search-branding').html (google.search.Search.getBranding ());
				/**/
				customInjection = '<?php echo trim(c_ws_plugin__super_news_utils_strings::esc_sq (preg_replace ("/\n/", "\\n", preg_replace ("/[\r\t]+/", "", $GLOBALS["WS_PLUGIN__"]["super_news"]["o"]["custom_injection"])))); ?>';
				/**/
				thumbProvider = '<?php echo esc_js($GLOBALS["WS_PLUGIN__"]["super_news"]["o"]["thumb_provider"]); ?>';
				thumbProvider = (thumbProvider === 'shrinktheweb') ? 'http://images.shrinktheweb.com/xino.php?embed=1&stwaccesskeyid=<?php echo esc_js (urlencode ($GLOBALS["WS_PLUGIN__"]["super_news"]["o"]["thumb_key"])); ?>&stwsize=lg&stwurl=' : thumbProvider;
				thumbProvider = (thumbProvider === 'websnapr') ? 'http://images.websnapr.com/?size=S&key=<?php echo esc_js (urlencode ($GLOBALS["WS_PLUGIN__"]["super_news"]["o"]["thumb_key"])); ?>&url=' : thumbProvider;
				thumbProvider = (thumbProvider === 'thumbshots') ? 'http://open.thumbshots.org/image.aspx?url=' : thumbProvider;
				/**/
				$('input#ws-plugin--super-news-search-new').click (function()
					{
						execSearcher('new');
					});
				$('input#ws-plugin--super-news-search-add').click (function()
					{
						execSearcher('add');
					});
				/**/
				var execSearcher = function(new__add)
					{
						var q, o; /* Localize these so we can validate. */
						/**/
						global_superNews.new__add = new__add; /* Set intended action. */
						/**/
						if (q = $.trim ($ ('input#ws-plugin--super-news-search-q').val ()))
							{
								if ((o = $ ('input[name="ws_plugin__super_news_search_o"]').val ()) === 'date')
									superNews.setResultOrder (google.search.Search.ORDER_BY_DATE);
								/**/
								else if (o === 'relevance') /* Returned in order of greatest relevance. */
									superNews.setResultOrder (google.search.Search.ORDER_BY_RELEVANCE);
								/**/
								$('img#ws-plugin--super-news-loading-animation').css ('visibility', 'visible');
								/**/
								superNews.execute (q); /* Execute the search. */
							}
					};
				/**/
				var searchComplete = function()
					{
						clearResults (); /* Start by clearing current results. */
						/**/
						if (superNews.results && superNews.results.length > 0)
							{
								var r = '<div class="super-news-results">\n', _r = '';
								/**/
								for (var i = 0, md5 = ''; i < superNews.results.length; i++)
									{
										_r += '<!--s-result:' + (md5 = $.md5 (superNews.results[i].postUrl + '-' + Math.random())) + '-->';
										/**/
										_r += '\t<div class="super-news-result">\n';
										/**/
										_r += '<img class="super-news-result-del" src="<?php echo $i; ?>/del-icon.png" onclick="global_superNews.del(\'' + md5 + '\');" title="Delete" alt="" />';
										/**/
										_r += (thumbProvider) ? '\t\t<div class="super-news-result-thumbnail"><a href="' + superNews.results[i].postUrl + '" title="' + superNews.results[i].title.replace (/<\/?[^>]+>/gi, '') + '" target="_blank"><img src="' + thumbProvider + encodeURIComponent (superNews.results[i].postUrl) + '" alt="" /></a></div>\n' : '';
										_r += '\t\t<div class="super-news-result-title"><h3><a href="' + superNews.results[i].postUrl + '" title="' + superNews.results[i].postUrl + '" target="_blank" rel="external">' + superNews.results[i].title.replace (/<\/?[^>]+>/gi, '') + '</a></h3></div>\n';
										_r += '\t\t<div class="super-news-result-clip" title="' + superNews.results[i].postUrl + '">' + superNews.results[i].content.replace (/<\/?[^>]+>/gi, '') + '</div>\n';
										_r += '\t\t<div class="super-news-result-details"><a href="' + superNews.results[i].postUrl + '" title="' + superNews.results[i].postUrl + '" class="super-news-result-details-url" target="_blank">' + superNews.results[i].blogUrl + '</a> <span class="super-news-result-details-date" title="Published: ' + superNews.results[i].publishedDate + '">&mdash; ' + superNews.results[i].publishedDate + '</span></div>\n';
										/**/
										_r += '\t</div>\n';
										/**/
										_r += '<!--e-result:' + md5 + '-->';
									}
								/**/
								if (global_superNews.new__add === 'add')
									_r += global_superNews.results;
								/**/
								global_superNews.results = _r;
								/**/
								r += _r + '</div>';
								/**/
								$('div#ws-plugin--super-news-search-results').html (r), $ ('textarea#ws-plugin--super-news-search-snippet').val (resultsSnippet (r));
								/**/
								var $a, page, cursor = superNews.cursor, curPage = cursor.currentPageIndex, $pagination = $ ('span#ws-plugin--super-news-search-pagination');
								/**/
								if (global_superNews.new__add === 'new')
									for (var i = 0, paginationPages = cursor.pages.length; i < paginationPages; i++)
										{
											$a = $ ('<a href="#wpwrap" onclick="global_superNews.$.gotoPage (' + i + ');"' + ((curPage == i) ? ' class="current"' : '') + '>' + cursor.pages[i].label + '</a>');
											$pagination.append ($a);
										}
								/**/
								displayResults(paginationPages);
							}
					};
				/**/
				var resultsSnippet = function(r)
					{
						r = r.replace (/(\<\!--)(s|e)(-result\:)(.*?)(--\>)/g, '').replace (/\<img class\="super-news-result-del"(.*?)\/\>/g, '').replace (/ target\="_blank"/g, ' rel="nofollow"').replace (/rel\="external"/g, '');
						return (customInjection) ? customInjection + '\n' + r : r;
					};
				/**/
				global_superNews.del = function(md5)
					{
						var r = '<div class="super-news-results">\n', _r = global_superNews.results;
						/**/
						_r = _r.replace (new RegExp('(\\<\\!--s-result\\:)('+md5+')(--\\>)([\\S\\s]*?)(\\<\\!--e-result\\:)('+md5+')(--\\>)', 'g'), '');
						/**/
						global_superNews.results = _r;
						/**/
						r += _r + '</div>';
						/**/
						$('div#ws-plugin--super-news-search-results').html (r), $ ('textarea#ws-plugin--super-news-search-snippet').val (resultsSnippet (r));
						$('div.ws-plugin--super-news-pagination-section-hr, div.ws-plugin--super-news-pagination-section').hide (), $ ('span#ws-plugin--super-news-search-pagination').html ('');
					};
				/**/
				var displayResults = function(paginationPages)
					{
						$('div.ws-plugin--super-news-results-section-hr').show ();
						/**/
						$('div.ws-plugin--super-news-results-section').slideDown ('fast', function()
							{
								$('img#ws-plugin--super-news-loading-animation').css ('visibility', 'hidden');
								$('div.ws-plugin--super-news-snippet-section-hr, div.ws-plugin--super-news-snippet-section').show ();
								/**/
								if (global_superNews.new__add === 'new' && paginationPages > 1)
									{
										$('div.ws-plugin--super-news-pagination-section-hr, div.ws-plugin--super-news-pagination-section').show ();
									}
							});
					};
				/**/
				var clearResults = function()
					{
						$('img#ws-plugin--super-news-loading-animation').css ('visibility', 'hidden');
						/**/
						$('div.ws-plugin--super-news-results-section-hr, div.ws-plugin--super-news-results-section').hide ();
						$('div.ws-plugin--super-news-snippet-section-hr, div.ws-plugin--super-news-snippet-section').hide ();
						$('div.ws-plugin--super-news-pagination-section-hr, div.ws-plugin--super-news-pagination-section').hide ();
						/**/
						$('div#ws-plugin--super-news-search-results').html (''), $ ('textarea#ws-plugin--super-news-search-snippet').val (''), $ ('span#ws-plugin--super-news-search-pagination').html ('');
					};
				/**/
				superNews.setSearchCompleteCallback (this, searchComplete, null), clearResults ();
			}
	});
/*
Load the Google search API.
*/
if (location.href.match (/page\=ws-plugin--super-news-search/))
	google.load ('search', '1');