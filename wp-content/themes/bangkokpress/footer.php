		</div> <!-- container -->
		<div class="footer-wrapper">
			<?php $gdl_show_footer = get_option(THEME_SHORT_NAME.'_show_footer','enable'); ?>
			
			<!-- Get Footer Widget -->
			<?php if( $gdl_show_footer == 'enable' ){ ?>
				<div class="footer-widget-wrapper">
					<div class="container">
						<?php
							$gdl_footer_class = array(
								'footer-style1'=>array('1'=>'four columns', '2'=>'four columns', '3'=>'four columns', '4'=>'four columns'),
								'footer-style2'=>array('1'=>'eight columns', '2'=>'four columns', '3'=>'four columns', '4'=>'display-none'),
								'footer-style3'=>array('1'=>'four columns', '2'=>'four columns', '3'=>'eight columns', '4'=>'display-none'),
								'footer-style4'=>array('1'=>'one-third column', '2'=>'one-third column', '3'=>'one-third column', '4'=>'display-none'),
								'footer-style5'=>array('1'=>'two-thirds column', '2'=>'one-third column', '3'=>'display-none', '4'=>'display-none'),
								'footer-style6'=>array('1'=>'one-third column', '2'=>'two-thirds column', '3'=>'display-none', '4'=>'display-none'),
								);
							$gdl_footer_style = get_option(THEME_SHORT_NAME.'_footer_style', 'footer-style1');
						 
							for( $i=1 ; $i<=4; $i++ ){
								echo '<div class="' . $gdl_footer_class[$gdl_footer_style][$i] . ' mb0">';
								dynamic_sidebar('Footer ' . $i);
								echo '</div>';
							}
						?>
						<br class="clear">
					</div> <!-- container -->
				</div> 
			<?php } ?>
			
			<?php 
				$gdl_show_copyright = get_option(THEME_SHORT_NAME.'_show_copyright','enable'); 
				$gdl_copyright_back_to_top = get_option(THEME_SHORT_NAME.'_copyright_back_to_top','enable'); 
			
			?>
			
			<!-- Get Copyright Text -->
			<?php if( $gdl_show_copyright == 'enable' ){ ?>
				<div class="copyright-wrapper-gimmick"></div>
				<div class="copyright-wrapper">
					<div class="container mt0">
						<div class="copyright-left">
							<?php echo get_option(THEME_SHORT_NAME.'_copyright_left_area') ?>
						</div> 
						<div class="copyright-right">
							<?php 
								if( $gdl_copyright_back_to_top == 'enable' ){
									echo '<div class="back-to-top-button gdl-hover" id="back-to-top-button"></div>';
								}else{
									echo get_option(THEME_SHORT_NAME.'_copyright_right_area');
								}
							?>
						</div> 
						<div class="clear"></div>
					</div>
				</div> 
			<?php } ?>
		</div><!-- footer-wrapper -->
</div> <!-- body-wrapper -->
	
<?php wp_footer(); ?>

<script type="text/javascript"> 	
	<?php include ( TEMPLATEPATH."/javascript/cufon-replace.php" ); ?>
	
	  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-42092269-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42092269-1', 'gilroygarlicfestival.com');
  ga('send', 'pageview');
  
  function trackOutboundLink(link, category, action) { 
 
	try { 
		_gaq.push(['_trackEvent', category , action]); 
	} catch(err){}
	 
	setTimeout(function() {
	document.location.href = link.href;
	}, 100);
}
  
</script>

</body>
</html>