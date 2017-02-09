=== Combine CSS ===
Contributors: timmcdaniels
Tags: css,combine,minify,gzip,compress
Tested up to: 3.9.1
Stable tag: 2.0
Requires at least: 3.0.1

WordPress plugin that combines, minifies, and compresses CSS files.

== Description ==

WordPress plugin that combines, minifies, and compresses CSS files. The CSS files that this plugin combines and minifies must be enqueued by using wp_enqueue_style. The plugin combines and minifies CSS and writes the output into files in the uploads directory and makes attempts to correct paths for images and fonts. Also see the companion plugin, [Combine JS](http://wordpress.org/extend/plugins/combine-js/).

Features include:

* option to change the CSS domain if a CDN is used
* option to change how often CSS files get refreshed
* option to exclude certain CSS files from combining
* option to turn on/off gzip compression
* option to include Gravity Forms CSS (this is due to Gravity Forms not using wp_enqueue_style)
* option to turn on debugging

== Installation ==

1. Upload `combine-css` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to Settings -> Combine CSS, update settings, and select "Save Changes" button

== Frequently Asked Questions ==

= CSS is not displaying properly after activating the plugin. What can I do? =

You can debug the plugin by activating the debug option on the settings page and reviewing the server's error log for details. You can try excluding certain CSS files from getting combined to see if that fixes the issue.

= How do I use the "CSS Files to Ignore" feature in Settings?

You can tell the CSS Combine plugin to ignore certain CSS files by using the name of the actual CSS file (style.css) or providing the theme or plugin name followed by a colon and then the CSS file (fooplugin:style.css or footheme:style.css).

== Screenshots ==
1. This is a screenshot of the Combine CSS settings page.

== Changelog ==

= 2.0 =
* fix flock warning spotted by Manuel Razzari on wpengine.

= 1.9 =
* Change system tmp dir so that it includes namespace directory; bug spotted by jprado.

= 1.8 =
* Added HTML output compression option in settings that uses: ob_start( 'ob_gzhandler' ).

= 1.7 =
* Changed explode to regex split for ignore list based on feedback from ckgrafico.

= 1.6 =
* Fixed PHP Warning reported by thorstone137.

= 1.5 =
* Changed gathering of CSS function to use print_styles_array filter. Fixed path issue related to missing forward slash. Added helper functions.

= 1.4 =
* Change temp dir function.

= 1.3 =
* Subtle changes from JS Combine.

= 1.2 =
* Added small change to allow plugin to work with Social Wiggle plugin.

= 1.1 =
* Improved debugging and improved condition for checking whether cache is expired.

= 1.0 =
* Fixed ignore files issue due to newlines and context slash issue.

= 0.9 =
* Fixed regex issue (also spotted by jprado).

= 0.8 =
* Added Delete CSS Cache button.

= 0.7 =
* Addressed issue of zero length settings file.
* Added additional messages regarding tmp dir and settings file for Settings form.
* Fixed issue of double forward slashes in combined CSS file.

= 0.6 =
* Reintroduced cache checking method from version 0.4 to address issues of blank stylesheets.

= 0.5 =
* Fixed notices and warnings in error log (thanks to pha3z).
* Added additional debug messages.
* Added glob function to remove cached files when settings saved.

= 0.4 =
* Note: Version 0.4 uses a file (css.php) within the plugin directory to serve combined CSS files. Also, it requires a tmp directory to be created within the plugin directory; the plugin will create the directory automatically if it has the permission to do so. View the settings page after updating to version 0.4, and it will let you know what commands need to be run, if any.
* Added additional path changes for assets, images, etc.
* Created standalone script with token argument to serve combined CSS file.
* Created tmp directory that allows WP settings to be stored in a file.

= 0.3 =
* Additional changes to minify function.

= 0.2 =
* Fixed issue with minifying of CSS (for double spaces and more).

= 0.1 =
* First release!

== Upgrade Notice ==

= 0.1 =
First release!
