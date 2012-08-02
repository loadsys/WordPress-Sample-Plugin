<?php
/*
Plugin Name: Loadsys Sample Plugin
Description: This is a simple and basic plugin to walkthrough building a WordPress plugin.
Version: 1.0
Author: Loadsys
Author URI: http://www.loadsys.com
*/

//Catch anyone trying to directly acess the plugin - which isn't allowed
if (!function_exists('add_action')) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit;
}

//Check if the the class already exists
if (!class_exists("LoadsysSimplePlugin")) {
	class LoadsysSimplePlugin {

		private $_VersionNumber = "1.0";
		private $_LoadsysURL = "http://www.loadsys.com/";

		/**
		 * Basic constructor for the LoadsysSimplePlugin Class
		 */
		public function __construct() {
		}

		/**
		 * Returns a string to add to the WordPress Footer
		 * @return string short string added to the WP footer
		 */
		public function footer_action() {
			$returnString = null;
			$returnString .= "<p>Thanks for using the Loadsys Simple Plugin Version ";
			$returnString .= $this->_VersionNumber;
			$returnString .= " from the developers at <a href='";
			$returnString .= $this->_LoadsysURL;
			$returnString .= "' title='Loadsys'>Loadsys</a>.</p>";
			echo $returnString;
		}

		/**
		 * Modify the list of classes added to the body tag
		 * @param  array  $classes current list of classes
		 * @return array           modified list of classes
		 */
		public function body_class_filter($classes = array()) {
			$classes[] = 'some-custom-class';
			return $classes;
		}

		/**
		 * Execute and return data when the shortcode is executed
		 * @param  array  $attributes attributes for the shortcode (optional)
		 * @return [type]             [description]
		 */
		public function simple_shortcode($attributes = array()) {
			extract( shortcode_atts( array(
				'attr_1' => 'attribute 1 default',
				'attr_2' => 'attribute 2 default',
				// ...etc
			), $attributes ) );

			return "Simple Shortcode called";
		}

		/**
		 * Execute and return data when the enclosed shortcode is executed
		 * @param  array  $attributes attributes for the shortcode (optional)
		 * @param  array  $content    [description]
		 * @return string             [description]
		 */
		public function simple_enclosed_shortcode($attributes = array(), $content) {
			extract( shortcode_atts( array(
				'attr_1' => 'attribute 1 default',
				'attr_2' => 'attribute 2 default',
				// ...etc
			), $attributes ) );

			return "Simple Enclosed Shortcode called";
		}

	}
}

if (class_exists("LoadsysSimplePlugin")) {
	$loadsysSimplePlugin = new LoadsysSimplePlugin();
}

if (isset($loadsysSimplePlugin)) {
	//Actions - http://codex.wordpress.org/Plugin_API#Actions
	//add_action - http://codex.wordpress.org/Function_Reference/add_action
	add_action('wp_footer', array(&$loadsysSimplePlugin, 'footer_action'), 100);

	//Filters - http://codex.wordpress.org/Plugin_API#Filters
	//add_filter - http://codex.wordpress.org/Function_Reference/add_filter
	add_filter( 'body_class', array(&$loadsysSimplePlugin, 'body_class_filter'));

	//Shortcodes
	//add_shortcode - http://codex.wordpress.org/Function_Reference/add_shortcode
	add_shortcode( 'loadsys_short', array(&$loadsysSimplePlugin, 'simple_shortcode') );
	add_shortcode( 'loadsys_short_enclosing', array(&$loadsysSimplePlugin, 'simple_enclosed_shortcode') );
}

?>