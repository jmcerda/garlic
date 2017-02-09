<?php
/*
Plugin Name: Social Counter Widget
Plugin URI: http://www.webdev3000.com/
Description: This widget will display your RSS subscribers, Twitter followers and Facebook fans in one nice looking box.
Author: Csaba Kissi
Version: 0.8.1
Author URI: http://www.webdev3000.com/
*/
require "scw_stats.class.php";
class SC_widget extends WP_Widget {


    /** constructor -- name this the same as the class above */
    function SC_widget() {
        parent::WP_Widget(false, $name = 'Social Counter Widget');
        $this->cacheFileName = WP_CONTENT_DIR."/sc_cache.txt";
    }

    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {
        extract( $args );
        // $title = apply_filters('widget_title', $instance['title']);
        $facebook_id	= $instance['facebook_id'];
        $twitter_id	= $instance['twitter_id'];
        $feedburner_id = $instance['feedburner_id'];
        $cacheFileName = $this->cacheFileName;
        //@unlink($cacheFileName);

        if(file_exists($cacheFileName) && time() - filemtime($cacheFileName) <  30*60){
            $stats = unserialize(file_get_contents($cacheFileName));
        }else if( file_exists($cacheFileName) ){
			$old_stats = unserialize(file_get_contents($cacheFileName));		
		}

		//$is_all_retrieve = ($stats->twitter > 0) &&  ( $stats->rss > 0 ) && ( $stats->facebook );
		
        if(!$stats)
        {
            // If no cache was found, fetch the subscriber stats and create a new cache:

            $stats = new SubscriberStats(array(
                'facebookFanPageURL'	=> $facebook_id,
                'feedBurnerURL'		=> $feedburner_id,
                'twitterName'		=> $twitter_id,
				'rss'				=> $old_stats->rss,
				'twitter'			=> $old_stats->twitter,
				'facebook'			=> $old_stats->facebook
            ));

            file_put_contents($cacheFileName,serialize($stats));
        }

        //	You can access the individual stats like this:
        //	$stats->twitter;
        //	$stats->facebook;
        //	$stats->rss;

        //	Output the markup for the stats:

        ?>
			<div class="sidebar-social-counter-widget">
              <?php echo $before_widget; ?>
			  <?php 
				if ( $title ){ 
					echo $before_title . $title . $after_title; 
				}else if( strrpos($after_title, 'bkp-frame') > 0 ) {
					echo '<div class="bkp-frame-wrapper"><div class="bkp-frame p20 gdl-divider">';
				}
			  ?>
					<?php $stats->generate(); ?>
              <?php echo $after_widget; ?>
			</div>
        <?php
    }

    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {
        if($new_instance != $old_instance) unlink($this->cacheFileName);
		$instance = $old_instance;
		//$instance['title'] = strip_tags($new_instance['title']);
		$instance['twitter_id'] = strip_tags($new_instance['twitter_id']);
        $instance['facebook_id'] = strip_tags($new_instance['facebook_id']);
        $instance['feedburner_id'] = strip_tags($new_instance['feedburner_id']);
        return $instance;
    }

    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {

        // $title 		 = esc_attr($instance['title']);
        $twitter_id  = esc_attr($instance['twitter_id']);
        $facebook_id = esc_attr($instance['facebook_id']);
        $feedburner_id = esc_attr($instance['feedburner_id']);
        ?>
		<!-- TITLE
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		-->
        <p>
          <label for="<?php echo $this->get_field_id('twitter_id'); ?>"><?php _e('Twitter ID:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('twitter_id'); ?>" name="<?php echo $this->get_field_name('twitter_id'); ?>" type="text" value="<?php echo $twitter_id; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('facebook_id'); ?>"><?php _e('Facebook page URL (not ID !):'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('facebook_id'); ?>" name="<?php echo $this->get_field_name('facebook_id'); ?>" type="text" value="<?php echo $facebook_id; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('feedburner_id'); ?>"><?php _e('Feedburner URL (not ID !):'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('feedburner_id'); ?>" name="<?php echo $this->get_field_name('feedburner_id'); ?>" type="text" value="<?php echo $feedburner_id; ?>" />
        </p>
        <?php
    }


} // end class example_widget

function sc_stylesheet() {
    $myStyleUrl = plugins_url('css/social-counter.css', __FILE__); // Respects SSL, Style.css is relative to the current file
    $myStyleFile = WP_PLUGIN_DIR . '/social-counter-widget/css/social-counter.css';
    if ( file_exists($myStyleFile) ) {
        wp_register_style('myStyleSheets', $myStyleUrl);
        wp_enqueue_style( 'myStyleSheets');
    }
}

add_action('widgets_init', create_function('', 'return register_widget("SC_widget");'));
add_action('wp_print_styles', 'sc_stylesheet');

?>