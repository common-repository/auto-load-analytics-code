<?php
/*
Plugin Name: auto load google analytics code
Plugin URI: http://www.yaaahaaa.com
Description: This plugin makes it simple to add Google Analytics code(actually what ever analytics code you want),you just simple put your analytics code in the "themes/analytics_code.php" file then it done,every time the theme you change, the analytics code would auto load itself then.
Author: Lyman Lai(at www.yaaahaaa.com)
Version: 1.0
Author URI: http://www.yaaahaaa.com

*/

add_action("init",array("GoogleAnalytics","init"),1000,0);

class GoogleAnalytics
{
	public static $options_key ='auto_load_google_analytics_code';

	function init()
	{
		//Register the sitemap creator to wordpress...
		add_action('admin_menu', array(__CLASS__, 'RegisterAdminPage'));
		add_action('wp_footer', array(__CLASS__,'auto_loader_footer'));
	}
	
	/**
	 * Registers the plugin in the admin menu system
	 */
	function RegisterAdminPage() 
	{
		if ( function_exists('add_submenu_page') )
		{
			// $parent, $page_title, $menu_title, $access_level, $file, $function = ''
			add_submenu_page( 'plugins.php', __('google analytics'), __('google analytics'), 'manage_options', 'google-analytics-config', array(__CLASS__,'adminPageShow') );
		}
	}
	
	function adminPageShow()
	{
		//show html
		if( !empty($_POST['submit']) )
		{
			update_option( self::$options_key, $_POST['google_analytics_code']);
		}
		$google_analytics_code = get_option( self::$options_key );
	?>
		<?php if ( !empty($_POST ) ) : ?>
		<div id="message" class="updated fade"><p><strong><?php _e('Options saved.') ?></strong></p></div>
		<?php endif; ?>
		<div class="wrap">
			<h2><?php _e('google analytics Configuration'); ?></h2>
			<div class="narrow">
				<form action="" method="post" id="google-analytics-config" style="margin: auto; width: 400px; ">
					<h3><label for="key"><?php _e('google analytics code'); ?></label></h3>
					<p>
						<textarea name="google_analytics_code" cols="100" rows="15"><?php echo stripslashes( $google_analytics_code );?></textarea>
					</p>
					<p class="submit"><input type="submit" name="submit" value="<?php _e('Update options &raquo;'); ?>" /></p>
				</form>
			</div>
		</div>
	<?php 
	}
	
	function auto_loader_footer()
	{
		$google_analytics_code = get_option( self::$options_key );
		if( !empty($google_analytics_code) )
		{
			echo stripslashes($google_analytics_code);
		}
		else
		{
			echo '<!-- please input your google_analytics_code first -->';
		}
	}
}