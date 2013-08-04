<?php

/*
Plugin Name: message ticker
Plugin URI: http://www.gopiplus.com/work/2010/07/18/message-ticker/
Description: This plug-in will display the announcement or message with simple horizontal scroller or horizontal ticker.
Version: 7.1
Author: Gopi.R
Author URI: http://www.gopiplus.com/work/2010/07/18/message-ticker/
Donate link: http://www.gopiplus.com/work/2010/07/18/message-ticker/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

global $wpdb, $wp_version;
define("WP_mt_TABLE", $wpdb->prefix . "mt_plugin");

define("WP_mt_UNIQUE_NAME", "message-ticker");
define("WP_mt_TITLE", "Message ticker");
define('WP_mt_FAV', 'http://www.gopiplus.com/work/2010/07/18/message-ticker/');
define('WP_mt_LINK', 'Check official website for more information <a target="_blank" href="'.WP_mt_FAV.'">click here</a>');

function mt_show()
{
	global $wpdb;
	$mt = "";
	
	$data = $wpdb->get_results("select mt_text from ".WP_mt_TABLE." where mt_status='YES' ORDER BY mt_order");
	if ( ! empty($data) ) 
	{
		$count = 0; 
		foreach ( $data as $data ) 
		{
			$content = $data->mt_text;
			$mt = $mt . "mt_contents[$count]='$content';";
			$count++;
		}
	}
	
	$mt_width = get_option('mt_width');
	$mt_height = get_option('mt_height');
	$mt_delay = get_option('mt_delay');
	$mt_speed = get_option('mt_speed');
	$siteurl = get_option('siteurl');
	
	if(!is_numeric($mt_delay)){ $mt_delay = 3000;} 
	if(!is_numeric($mt_speed)){ $mt_speed = 5;} 
	
	if(!is_numeric($mt_width)){ 
		$mt_width = "";
	}
	else {
		$mt_width = "width:".$mt_width."px;";
	}
	
	if(!is_numeric($mt_height)){ 
		$mt_height = "";
	}
	else {
		$mt_height = "height:".$mt_height."px;";
	}
	
	?>
    <div style="padding-top:5px;width:100%"> 
    <span id="mt_spancontant" style="position:absolute;<?php echo $mt_width.$mt_height; ?>"></span> 
    </div>
    <script type="text/javascript">
    var mt_contents=new Array()
    <?php echo $mt; ?>
    var mt_delay=<?php echo $mt_delay; ?> 
    var mt_speed=<?php echo $mt_speed; ?> 
    mt_start();
    </script>
    <?php
}

function mt_deactivate() 
{
	// No action required.
}

function mt_show_new( $group = "GROUP1", $width = "300", $height = "150" ) 
{
	$arr = array();
	$arr["group"]=$group;
	$arr["width"]=$width;
	$arr["height"]=$height;
	echo mt_shortcode($arr);
}

add_shortcode( 'message-ticker', 'mt_shortcode' );

function mt_shortcode( $atts ) 
{
	global $wpdb;
	$mt = "";
	$mt_mt = "";
	
	//[message-ticker group="group1" width="300" height="150"]
	if (! is_array( $atts ) )
	{
		return 'Please check your short code';
	}
	$group = $atts['group'];
	$width = $atts['width'];
	$height = $atts['height'];
	
	$sSql = "select mt_text from ".WP_mt_TABLE." where mt_status='YES'";
	if($group <> "")
	{
		$sSql = $sSql . " and mt_group='$group'";
	}
	$sSql = $sSql . " ORDER BY mt_order";
	
	$data = $wpdb->get_results($sSql);
	if ( ! empty($data) ) 
	{
		$count = 0; 
		foreach ( $data as $data ) 
		{
			$content = $data->mt_text;
			$mt = $mt . "mt_contents[$count]='$content';";
			$count++;
		}
		
		$mt_width = $width;
		$mt_height = $height;
		$mt_delay = get_option('mt_delay');
		$mt_speed = get_option('mt_speed');
		$siteurl = get_option('siteurl');
		
		if(!is_numeric($mt_delay)){ $mt_delay = 3000;} 
		if(!is_numeric($mt_speed)){ $mt_speed = 5;} 
		
		if(!is_numeric($mt_width))
		{ 
			$mt_width = "";
		}
		else 
		{
			$mt_width = "width:".$mt_width."px;";
			//$mt_width = "width:100%;";
		}
		
		if(!is_numeric($mt_height))
		{ 
			$mt_height = "";
		}
		else 
		{
			$mt_height = "height:".$mt_height."px;";
		}
		
		$mt_mt = $mt_mt .'<div style="padding-top:5px;">';
		$mt_mt = $mt_mt .'<span id="mt_spancontant" style="position:absolute;'.$mt_width.$mt_height.'"></span> ';
		$mt_mt = $mt_mt .'</div>';
		$mt_mt = $mt_mt .'<script type="text/javascript">' ;
		$mt_mt = $mt_mt .'var mt_contents=new Array(); ';
		$mt_mt = $mt_mt . $mt ;
		$mt_mt = $mt_mt .'var mt_delay='.$mt_delay.'; ';
		$mt_mt = $mt_mt .'var mt_speed='.$mt_speed.'; ';
		$mt_mt = $mt_mt .'mt_start(); ';
		$mt_mt = $mt_mt .'</script>';
	}
	else
	{
		$mt_mt = "No message available, Please check your group.";
	}
	
	return $mt_mt;
}

function mt_activation() 
{
	global $wpdb;
	
	if($wpdb->get_var("show tables like '". WP_mt_TABLE . "'") != WP_mt_TABLE) 
	{
		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `". WP_mt_TABLE . "` (
			  `mt_id` int(11) NOT NULL auto_increment,
			  `mt_text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
			  `mt_order` int(11) NOT NULL default '0',
			  `mt_status` char(3) NOT NULL default 'No',
			  `mt_date` datetime NOT NULL default '0000-00-00 00:00:00',
			  PRIMARY KEY  (`mt_id`) )
			");
		$sSql = "INSERT INTO `". WP_mt_TABLE . "` (`mt_text`, `mt_order`, `mt_status`, `mt_date`)"; 
		$sSql = $sSql . "VALUES ('This is sample text for message ticker. <br> Thanks & regards', '1', 'YES', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	}
	$sSql = "ALTER TABLE `". WP_mt_TABLE . "` ADD `mt_group` VARCHAR( 100 ) NOT NULL ";
	$wpdb->query($sSql);
	
	add_option('mt_title', "Message");
	add_option('mt_width', "200");
	add_option('mt_height', "100");
	add_option('mt_delay', "3000");
	add_option('mt_speed', "5");
}

function mt_admin_options() 
{
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'edit':
			include('pages/content-management-edit.php');
			break;
		case 'add':
			include('pages/content-management-add.php');
			break;
		case 'set':
			include('pages/content-setting.php');
			break;
		default:
			include('pages/content-management-show.php');
			break;
	}
}

function mt_add_to_menu() 
{
	add_options_page('Message ticker', 'Message ticker', 'manage_options', 'message-ticker', 'mt_admin_options' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'mt_add_to_menu');
}

function mt_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('mt_title');
	echo $after_title;
	mt_show();
	echo $after_widget;
}

function mt_control()
{
	echo '<p>Message ticker.<br><br> To change the setting goto message ticker link under setting menu.<br>';
	echo ' <a href="options-general.php?page=message-ticker">';
	echo 'click here</a></p>';
	?>
    Check official website for live demo and more information <a target="_blank" href="http://www.gopiplus.com/work/2010/07/18/message-ticker/">click here</a>
	<?php
}

function mt_widget_init() 
{
	if(function_exists('wp_register_sidebar_widget')) 	
	{
		wp_register_sidebar_widget('message-ticker', 'message ticker', 'mt_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 	
	{
		wp_register_widget_control('message-ticker', array('message ticker', 'widgets'), 'mt_control');
	} 
}

function mt_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'message-ticker', get_option('siteurl').'/wp-content/plugins/message-ticker/message-ticker.js');
	}
}

add_action('init', 'mt_add_javascript_files');
add_action("plugins_loaded", "mt_widget_init");
register_activation_hook(__FILE__, 'mt_activation');
register_deactivation_hook( __FILE__, 'mt_deactivate' );
?>