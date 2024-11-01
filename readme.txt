=== WP_GMaps2 ===
Contributors: cesperanc
Tags: google maps, tinymce, post, page, gmaps, maps, map
Requires at least: 2.8.4
Tested up to: 2.9.1
Stable tag: 2.1

This plugin allows an easy integration of Google Maps on your pages or posts.

== Description ==

This plugin allows the integration of Google Maps on your pages or posts using the Wordpress Editor (TinyMCE). It supports multiple maps on the same post/page and within each map you can set many options, like the position of the marker, controls, icon of the marker, InfoWindow with Tabs with HTML support, etc. Give it a try.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the directory `wp_gmaps2` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Insert your Google Maps API key under 'Plugins->WP_GMaps2 Configuration' menu option in Wordpress. You can get this key at http://code.google.com/apis/maps/signup.html
1. You are ready to do some magic

== Frequently Asked Questions ==

= Which version of the Google Maps API is used in this plugin? =

It uses the Google Maps API version 2.

= Why do I have to get a Google Maps API key? =

In order to use the API, Google requires that you register a key for your site domain. In the version 3 of the API this is no longer necessary.

= This plugin will support the version 3 of the Google API? =

Yes, I'm on it. However this version doesn't support yet some of the features that we have on the version 2 (like the tabs on the InfoWindow). But soon this plugin will be release, probably with the name WP_GMaps3.

== Screenshots ==

1. To insert a map, press 1 (kitchen sink) to show the advanced bar and then press 2 (google maps) to open the Google Maps Window.
2. In the Google Maps window you can insert or update your map.
3. The final result.

== Changelog ==

= 2.1 =
* json_decode substitute for those that are using a PHP version bellow 5.2 (thanks to www at walidator dot info)
* Plugin URI updated to the new home
* Plugin validated for Wordpress 2.9.1

= 2.0 =
* First public version release
* Update for Wordpress 2.8
* Extra configuration options

= 1.0 =
* First release; tested internally

