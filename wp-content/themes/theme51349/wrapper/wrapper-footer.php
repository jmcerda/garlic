<?php /* Wrapper Name: Footer */ ?>
<div class="row footer-widgets">
	<div class="span6">
		<div data-motopress-type="static" data-motopress-static-file="static/static-footer-text.php">
			<?php get_template_part("static/static-footer-text"); ?>
		</div>
		<div data-motopress-type="static" data-motopress-static-file="static/static-footer-nav.php">
			<?php get_template_part("static/static-footer-nav"); ?>
		</div>
		<div id="footer_ticket_button"><a href="http://gilroygarlicfestival.eventbrite.com/?aff=GFestWebsite" target="new"><img src="/wp-content/uploads/2017/03/custombutton.png"></a></div>
	</div>
	<div class="span3 footer_right_left" data-motopress-type="dynamic-sidebar" data-motopress-sidebar-id="footer-sidebar-1">
		<?php dynamic_sidebar("footer-sidebar-1"); ?>
	</div>
	<div class="span3 footer_right_right" data-motopress-type="dynamic-sidebar" data-motopress-sidebar-id="footer-sidebar-2">
		<?php dynamic_sidebar("footer-sidebar-2"); ?>
	</div>
</div>