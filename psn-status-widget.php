<?php

/*
Plugin Name: PSN Status Widget
Plugin URI: http://www.webniraj.com/wordpress/
Description: Displays the status of the PlayStation Network on your blog in real time. This plugin is a widget you can place in the sidebar.
Author: Niraj Shah
Version: 0.2
Author URI: http://www.webniraj.com/
*/

// Widget stuff
function widget_psnstatus_register() {
	if ( function_exists('register_sidebar_widget') ) :
	function widget_psnstatus($args) {
		extract($args);
		$options = get_option('widget_psnstatus');
		?>
			<?php
				echo $before_widget;
				echo $before_title . $options['title'] . $after_title;
				echo '<div class="psn-status-wrapper">'
					. file_get_contents( "http://psnstatus.xtremeps3.com/index.php?region=" . $options['region'] )
					. '</div>';
				//	please do not remove!
				echo '<div class="psn-status-powered-by">Powered by <a href="http://www.xtremeps3.com/" target="_blank">XTREME PS3</a></div>';
				echo $after_widget;
			?>
	<?php
	}

	function widget_psnstatus_style() {
		?>
<style type="text/css">
.psn-status-wrapper {
	margin: 5px 0;
	padding: 5px 5px 0;
	width: 160px;
	text-align: center;
	background-color: #222;
}

.psn-status-powered-by {
	font-size: 9px;
}
</style>
		<?php
	}

	function widget_psnstatus_control() {
		$options = $newoptions = get_option('widget_psnstatus');
		
		if ( $_POST["psnstatus-submit"] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST["psnstatus-title"]));
			if ( empty( $newoptions['title'] ) ) $newoptions['title'] = 'PSN Status';
			$newoptions['region'] = $_POST["psnstatus-region"];
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option( 'widget_psnstatus', $options );
		}
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		
	?>
				<p>
					<label for="psnsstatus-title"><?php _e('Title:'); ?>
						<input class="widefat" id="psnstatus-title" name="psnstatus-title" type="text" value="<?php echo $title; ?>" />
					</label>
				</p>
				<p>
					<select class="widefat" id="psnstatus-region" name="psnstatus-region">
						<option value="AT">Austria</option>
						<option value="AU">Australia</option>
						<option value="BE">Belgium</option> 
						<option value="CH">Switzerland</option> 
						<option value="CZ">Czech Republic</option> 
						<option value="DE">Germany</option> 
						<option value="DK">Denmark</option> 
						<option value="ES">Spain</option> 
						<option value="FI">Finland</option> 
						<option value="FR">France</option> 
						<option value="GR">Greece</option> 
						<option value="IE">Ireland</option> 
						<option value="IN">India</option> 
						<option value="IT">Italy</option> 
						<option value="LU">Luxembourg</option> 
						<option value="NL">Netherlands</option> 
						<option value="NO">Norway</option> 
						<option value="NZ">New Zealand</option> 
						<option value="PL">Poland</option> 
						<option value="PT">Portugal</option> 
						<option value="RU">Russia</option> 
						<option value="SE">Sweden</option> 
						<option value="TR">Turkey</option>
						<option value="AE">United Arab Emirates</option>
						<option value="UK">United Kingdom</option> 
						<option value="ZA">South Africa</option>
					</select>
				</p>
				<input type="hidden" id="psnstatus-submit" name="psnstatus-submit" value="1" />
				<script type="text/javascript">
					jQuery('#psnstatus-region option[value="<?php echo $options['region']; ?>"]').attr('selected', true);
				</script>
	<?php
	}

	register_sidebar_widget('PSN Status', 'widget_psnstatus', null, 'psn-status');
	register_widget_control('PSN Status', 'widget_psnstatus_control', null, 75, 'psn-status');

	if ( is_active_widget('widget_psnstatus') )
		add_action('wp_head', 'widget_psnstatus_style');
	endif;
}

add_action('init', 'widget_psnstatus_register');
