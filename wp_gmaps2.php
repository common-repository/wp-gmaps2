<?php
	/*
		Plugin Name: WP_GMaps2
		Plugin URI:  http://sites.ipleiria.pt/labsUED/en/wordpress-en/plugins/wp-gmaps2/
		Description: WP_GMaps2 adds Maps to your pages and posts in Wordpress using the Google Maps API version 2.
		Version: 2.1
		Author: Cláudio Esperança
		Author URI: http://ued.ipleiria.pt
	*/

	/*
	 	Copyright 2009  Cláudio Esperança (cesperanc@gmail.com)

	    This program is free software; you can redistribute it and/or modify
	    it under the terms of the GNU General Public License as published by
	    the Free Software Foundation; either version 3 of the License, or
	    (at your option) any later version.

	    This program is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.

	    You should have received a copy of the GNU General Public License
	    along with this program; If not, see <http://www.gnu.org/licenses/>.

	*/

	/**
	 * json_decode substitute for those that are using a PHP version bellow 5.2
	 *
	 * @author www@walidator.info
	 * @see http://pt2.php.net/manual/en/function.json-decode.php#91216 for reference
	 */
	if ( !function_exists('json_decode') ){
		function json_decode($json){
			$comment = false;
			$out = '$x=';

			for ($i=0; $i<strlen($json); $i++){
				if (!$comment){
					if ($json[$i] == '{')        $out .= ' array(';
					else if ($json[$i] == '}')    $out .= ')';
					else if ($json[$i] == ':')    $out .= '=>';
					else                         $out .= $json[$i];
				}
				else $out .= $json[$i];
				if ($json[$i] == '"')    $comment = !$comment;
			}
			eval($out . ';');
			return $x;
		}
	}

	/**
	 * Some defines
	 */
	define('WP_GMaps', 'WP_GMaps2'); // should match the class name bellow
	define('WP_GMaps_text_domain', 'wp_gmaps2');

	/**
	 * Class responsable for the Wordpress/TinyMCE/Google Maps integration
	 *
	 * @author cesperanc
	 * @version 2.1
	 */
	class WP_GMaps2 {
		private $_content = "";

		function __construct($content=""){
			$contents = array();
			if(preg_match_all("(<!--(gmap|googlemap) ((\n|.)*?)-->)",$content,$contents)){
				$js_addOnShowMaps='';

		        foreach($contents[2] as $mapn=>$map){
		        	$result = '';
		        	// decode the string with the map data
		        	$mapObj = json_decode(html_entity_decode(preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",str_replace(":NaN,",":\"\",",urldecode($map))),null,'UTF-8'), true);
		        	// append a div to the content to draw the map
		        	$result .= "<div id=\"map_$mapn\" style=\"width: ".$mapObj["width"]."px; height: ".$mapObj["height"]."px;\">&nbsp;</div>";
		        	// Write the javascript function with the map data
		        	$js_addOnShowMaps .= "\nShowTheGMap('map_$mapn','$map');";
		        	// Replace the tag for the result html
		        	$content = str_ireplace($contents[0][$mapn],$result,$content);
		        }

				$this->_content .= $content.'
						<script type="text/javascript">
							addOnloadEvent(function(){'.$js_addOnShowMaps.'});
						</script>';
	        }else{
	            $this->_content = $content;
	        }
	    }

	    public function content(){
	        return $this->_content;
	    }

	    public function filterContent($content){
	        if(!isset($this)){
	        	$classname = __CLASS__;
	        	if(!class_exists($classname)){
	        		return $content;
	        	}
	            $gmap = new $classname($content);
	        }else{
	            $gmap = &$this;
	        }

	        return $gmap->content();
	    }

	    public function appendToHeader(){
	    	?>
	    		<script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?php echo(get_option('GOOGLE_MAPS_KEY','')); ?>"></script>
				<script type="text/javascript" src="<?php echo(plugin_dir_url(__FILE__)); ?>js/client.js"></script>
	    	<?php
	    }

	    /**
	     * Adds a button to TinyMCE buttons list
	     */
		public function tinymceRegisterButton($buttons) {
		   array_push($buttons, "separator", "wp_gmaps2");
		   return $buttons;
		}

		/**
		 * Set the URL to the plugin for TinyMCE
		 */
		public function tinymceAddPlugin($plugin_array) {
		   $plugin_array['wp_gmaps2'] = plugin_dir_url(__FILE__).'js/editor_plugin_src.js';
		   return $plugin_array;
		}

		/**
		 * Set the URL to the plugin for TinyMCE
		 */
		public function tinymceAddOptions($init) {
			$init['gmaps_key'] = get_option('GOOGLE_MAPS_KEY','');
			return $init;
		}

		/**
		 * Add the necessary filters for the TinyMCE plugin
		 */
	    public function tinymceConfigurator() {
			// Don't bother doing this stuff if the current user lacks permissions
			if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ){
				return;
			}
			// Add only in Rich Editor mode
			if ( get_user_option('rich_editing') == 'true') {
				add_filter('mce_external_plugins', array(WP_GMaps, 'tinymceAddPlugin'));
				add_filter('mce_buttons_2', array(WP_GMaps, 'tinymceRegisterButton'));
				add_filter('tiny_mce_before_init', array(WP_GMaps, 'tinymceAddOptions'));
			}
		}
		/**
		 * Add the options page to the admin menu
		 */
	    public function addToAdminMenu() {
			// Don't bother doing this stuff if the current user lacks permissions
			if ( is_admin() ){
				if ( function_exists('add_options_page') ){
					add_options_page(__('WP_GMaps2 options page', WP_GMaps_text_domain), __('WP_GMaps2 Configurarion', WP_GMaps_text_domain), 'manage_options', 'WP_GMaps_pluginOptionsPage', array(WP_GMaps, 'pluginOptionsPage'));
				}
				if ( function_exists('add_submenu_page') ){
					add_submenu_page('plugins.php', __('WP_GMaps2 options page', WP_GMaps_text_domain), __('WP_GMaps2 Configurarion', WP_GMaps_text_domain), 'manage_options', 'WP_GMaps_pluginOptionsPage', array(WP_GMaps, 'pluginOptionsPage'));
				}
			}
		}

		/**
		 * Register the plugin options
		 */
		public function registerSettings() {
			register_setting('WP_GMaps2_options', 'GOOGLE_MAPS_KEY');
		}

		/**
		 * Output the options page and save the changes
		 */
		public function pluginOptionsPage() {
			if (is_admin() && function_exists('current_user_can') && current_user_can('manage_options')){
				$key_name = 'GOOGLE_MAPS_KEY';
				if(isset($_POST[$key_name])){
					update_option('GOOGLE_MAPS_KEY', $_POST[$key_name]);
					?><div class="updated fade"><p><strong><?php _e('Options saved', WP_GMaps_text_domain); ?>!</strong></p></div><?php
				}
				?>
				<div class="wrap">
					<h2><?php _e('WP GMaps Options', WP_GMaps_text_domain);?></h2>
					<form method="post" action="">
						<?php settings_fields('WP_GMaps2_options'); ?>
						<h3><label for="gmaps_key"><?php _e('Google Maps Key', WP_GMaps_text_domain); ?></label></h3>
						<p style="padding: .5em; background-color: #CCCCCC; color: #fff; font-weight: bold;"><?php printf(__('Please enter a Google Maps API key. (<a %s>Get your key</a>)', WP_GMaps_text_domain), 'href="http://code.google.com/apis/maps/signup.html" target="_blank" style="color:#fff"'); ?></p>
						<p><input id="<?php echo($key_name); ?>" name="<?php echo($key_name); ?>" type="text" size="100" value="<?php echo(get_option('GOOGLE_MAPS_KEY')); ?>" style="font-family: 'Courier New', Courier, mono; font-size: 0.9em;" /> (<?php echo('<small><a href="http://code.google.com/apis/maps/faq.html#keysystem" target="_blank">'.__('What is this', WP_GMaps_text_domain).'?</a></small>'); ?>)</p>
						<p class="submit"><input class="button-primary" type="submit" name="submit" value="<?php _e('Save Changes', WP_GMaps_text_domain); ?>" /></p>
					</form>
				</div>
				<?php
			}
		}

		/**
		 * Output the missing config warnings
		 */
		public function pluginConfigWarning() {
			if(get_option('GOOGLE_MAPS_KEY','')=='' && (!isset($_POST['GOOGLE_MAPS_KEY']) || $_POST['GOOGLE_MAPS_KEY']=='')){
				?>
					<div class='updated fade'>
						<p><?php printf(__('You must <a %1$s>enter your Google Maps API key</a> for <strong>WP GMaps</strong> to work.', WP_GMaps_text_domain), 'href="plugins.php?page=WP_GMaps_pluginOptionsPage"'); ?></p>
					</div>
				<?php
			}
		}
	}

	// load the plugin translations
	load_plugin_textdomain(WP_GMaps_text_domain, false, dirname(plugin_basename(__FILE__)).'/langs');

	// insert the necessary javascript
	add_action('wp_head', array(WP_GMaps, 'appendToHeader'));
	// search the content for the map tag
	add_filter('the_content', array(WP_GMaps, 'filterContent'));
	// init process for button control
	add_action('init', array(WP_GMaps, 'tinymceConfigurator'));
	// add the options page to the admin menu
	if ( is_admin() ){
		add_action('admin_menu', array(WP_GMaps, 'addToAdminMenu'));
		add_action('admin_init', array(WP_GMaps, 'registerSettings'));
		add_action('admin_notices', array(WP_GMaps, 'pluginConfigWarning'));
	}
?>