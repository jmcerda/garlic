<?php /* Static Name: Footer text */ ?>
<div id="footer-text" class="footer-text col-xs-12">
	<?php $myfooter_text = of_get_option('footer_text'); ?>
	<?php if($myfooter_text){?>
		<?php echo of_get_option('footer_text'); ?>
		<?php /* Static Name: Social Links */ ?>
		<ul class="social">
			<?php 	
				$social_networks = array("facebook", "twitter", "feed", "youtube", "google", "vimeo");
				for($i=0, $array_lenght=count($social_networks); $i<$array_lenght; $i++){
					if(of_get_option($social_networks[$i]) != "") {
						echo '<li><a href="'.of_get_option($social_networks[$i]).'" title="'.$social_networks[$i].'" class="'.$social_networks[$i].'"><img src="'.of_get_option($social_networks[$i]."_icon").'" alt="'.$social_networks[$i].'"></a></li>';
					};
				};
			?>
		</ul>
	<?php } else { ?>
		<a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>" class="site-name"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo-footer.png"></a> <span>&copy; <?php echo date('Y'); ?> | <a href="<?php echo home_url(); ?>/privacy-policy/" title="<?php echo theme_locals('privacy_policy'); ?>" class='privacy'><?php echo theme_locals("privacy_policy"); ?></a></span>
	<?php } ?>
</div>