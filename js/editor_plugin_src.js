/**
 * @author Cees Rijken | Christian Ladewig | updated by Cláudio Esperança
 * @copyright www.connectcase.nl | www.klmedien.de | ued.ipleiria.pt
 *
 * @version 3.0
 */
var matchTag = /<!--gmap (.*?)-->/g;

(function() {
	tinymce.PluginManager.requireLangPack('wp_gmaps2');
	tinymce.create('tinymce.plugins.wp_gmaps2_plugin', {
		init : function(ed, url) {
			/* Register commands */
			ed.addCommand('mceWP_gmaps', function() {
				ed.windowManager.open({
					file : url + '/../html/wp_gmaps2.php',
					width : 640,
					height : 515,
					inline : 1
				}, {
					plugin_url : url, 
					gmaps_key: ed.getParam("gmaps_key", false)
				});
			});
			ed.addButton('wp_gmaps2', {
				title : 'wp_gmaps2.desc',
				cmd : 'mceWP_gmaps',
				image : url + '/../img/map_add.gif'
			});
			/* map operators */
			ed.getMap = function(){
				var match, content = this.selection.getContent();
				if(match = matchTag.exec(content)){
					if(match[1]!=''){
						return this.parseStringToMap(match[1]);
					}
				}
				return false;
			};
			ed.parseStringToMap = function(str){
				var map = tinymce.util.JSON.parse(unescape(str));
				if(typeof(map)=="object"){
					return map;
				}
				return false;
			};
			ed.parseMapToString = function(map){
				if(typeof(map)=="object"){
					return escape(tinymce.util.JSON.serialize(map));
				}
				return false;
			};
			this._handlewp_gmaps2(ed, url);
		}, 
		getInfo : function() {
			return {
				longname : 'Wordpress Google Maps plugin',
				author : 'Cláudio Esperança (Original by: Christian Ladewigm <http://www.klmedien.de>, Cees Rijken <http://www.connectcase.nl>)',
				authorurl : 'http://ued.ipleiria.pt',
				infourl : 'http://ued.ipleiria.pt',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		},
		_handlewp_gmaps2 : function(ed, url) {
			// Load plugin specific CSS into editor
			ed.onInit.add(function() {
				ed.dom.loadCSS(url + '/../css/content.css');
			});

			// Display wp_gmap instead if img in element path
			ed.onPostRender.add(function() {
				if (ed.theme.onResolveName) {
					ed.theme.onResolveName.add(function(th, o) {
						if (o.node.nodeName == 'IMG') {
							if ( ed.dom.hasClass(o.node, 'wp_gmaps2') ){
								o.name = 'google map';
							}
						}

					});
				}
			});

			// Replace code with image
			ed.onBeforeSetContent.add(function(ed, o) {
				var _html = '';
				var match;
				var content = o.content;
				while (match = matchTag.exec(o.content)){
					if(match[1]){
						_html = '<img src="' + url + '/../img/trans.gif" alt="'+match[1]+'" class="wp_gmaps2 mceItemNoResize" title="'+ed.getLang('wp_gmaps2.desc')+'"';
						var map = tinymce.util.JSON.parse(unescape(match[1]));
						if(map != null){
							if(!isNaN(parseInt(map.width))){
								_html += ' width="'+parseInt(map.width)+'"';
							}
							if(!isNaN(parseInt(map.height))){
								_html += ' height="'+parseInt(map.height)+'"';
							}
						}
						_html += ' />';
						content = content.replace('<!--gmap '+match[1]+'-->', _html);
					}
				}
				o.content = content;
			});

			// Replace images with the code
			ed.onPostProcess.add(function(ed, o) {
				if (o.get)
					o.content = o.content.replace(/<img[^>]+>/g, function(im) {
						if (im.indexOf('class="wp_gmaps2') !== -1) {
							var m, text = (m = im.match(/alt="(.*?)"/)) ? m[1] : '', map = tinymce.util.JSON.parse(unescape(text)), s;
							/* Let's check the size of the image on the selection, and update the width and height map field */
							map.width = (m = parseInt((m = im.match(/width="(.*?)"/)) ? m[1] : null)) ? m : map.width;
							map.height = (m = parseInt((m = im.match(/height="(.*?)"/)) ? m[1] : null)) ? m : map.height;
							im = '<!--gmap '+escape(tinymce.util.JSON.serialize(map))+'-->';
						}

						return im;
					});
			});

			// Set active buttons if user selected pagebreak or more break
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('wp_gmaps2', n.nodeName === 'IMG' && ed.dom.hasClass(n, 'wp_gmaps2'));
			});
		}
	});

	// Register plugin
	tinymce.PluginManager.add('wp_gmaps2', tinymce.plugins.wp_gmaps2_plugin);
})();
