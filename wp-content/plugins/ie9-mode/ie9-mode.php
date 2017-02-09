<?php
/*
Plugin Name: Internet Explorer 9 compatible
Plugin URI: http://www.ramoonus.nl
Description: Forces Internet Explorer 9 and higher to render the page as version 9.
Version: 1.0.0
Author: Ramoonus.nl
Author URI: http://www.ramoonus.nl
*/

function rw_ie9() {
	echo '<meta http-equiv="X-UA-Compatible" content="IE=9">';
} 

add_action('wp_head', 'rw_ie9');
?>