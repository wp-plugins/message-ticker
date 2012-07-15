<?php

/*
Plugin Name: message ticker
Plugin URI: http://www.gopipulse.com/work/2010/07/18/message-ticker/
Description: This plug-in will display the announcement or message with simple horizontal scroller or horizontal ticker.
Version: 5.0
Author: Gopi.R
Author URI: http://www.gopipulse.com/work/2010/07/18/message-ticker/
Donate link: http://www.gopipulse.com/work/2010/07/18/message-ticker/
*/

/**
 *     message ticker
 *     Copyright (C) 2012  www.gopipulse.com
 *     http://www.gopipulse.com/work/2010/07/18/message-ticker/
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


global $wpdb, $wp_version;
define("WP_mt_TABLE", $wpdb->prefix . "mt_plugin");

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
    <div style="padding-top:5px;"> 
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
	//	delete_option('mt_title');
	//	delete_option('mt_width');
	//	delete_option('mt_height');
	//	delete_option('mt_delay');
	//	delete_option('mt_speed');
}

add_filter('the_content','mt_show_filter');

function mt_show_filter($content)
{
	return 	preg_replace_callback('/\[MESSAGE-TICKER(.*?)\]/sim','mt_show_filter_callback',$content);
}

function mt_show_filter_callback($matches) 
{
	global $wpdb;
	$mt = "";
	$mt_mt = "";
	
	$scode = $matches[1];
	//[MESSAGE-TICKER:TYPE=PLUGIN]
	
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
	
    $mt_mt = $mt_mt .'<div style="padding-top:5px;">';
    $mt_mt = $mt_mt .'<span id="mt_spancontant" style="position:absolute;'.$mt_width.$mt_height.'"></span> ';
    $mt_mt = $mt_mt .'</div>';
    //$mt_mt = $mt_mt .'<script src="'.$siteurl.'/wp-content/plugins/message-ticker/message-ticker.js" type="text/javascript"><script> ';
    $mt_mt = $mt_mt .'<script type="text/javascript">' ;
    $mt_mt = $mt_mt .'var mt_contents=new Array(); ';
    $mt_mt = $mt_mt . $mt ;
    $mt_mt = $mt_mt .'var mt_delay='.$mt_delay.'; ';
    $mt_mt = $mt_mt .'var mt_speed='.$mt_speed.'; ';
    $mt_mt = $mt_mt .'mt_start(); ';
    $mt_mt = $mt_mt .'</script>';

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
		$sSql = $sSql . "VALUES ('This is sample text for message ticker. <br> Thanks & regards <br> Gopi.', '1', 'YES', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	}
	add_option('mt_title', "Message");
	add_option('mt_width', "175");
	add_option('mt_height', "85");
	add_option('mt_delay', "3000");
	add_option('mt_speed', "5");
}

function mt_admin_options() 
{
	global $wpdb;
	?>

<div class="wrap">
  <?php
    $mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=message-ticker/message-ticker.php";

    $DID=@$_GET["DID"];
    $AC=@$_GET["AC"];
    $submittext = "Insert Message";

	if($AC <> "DEL" and trim(@$_POST['mt_text']) <>"")
    {
			if($_POST['mt_id'] == "" )
			{
					$sql = "insert into ".WP_mt_TABLE.""
					. " set `mt_text` = '" . mysql_real_escape_string(trim($_POST['mt_text']))
					. "', `mt_order` = '" . $_POST['mt_order']
					. "', `mt_status` = '" . $_POST['mt_status']
					. "'";	
			}
			else
			{
					$sql = "update ".WP_mt_TABLE.""
					. " set `mt_text` = '" . mysql_real_escape_string(trim($_POST['mt_text']))
					. "', `mt_order` = '" . $_POST['mt_order']
					. "', `mt_status` = '" . $_POST['mt_status']
					. "' where `mt_id` = '" . $_POST['mt_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".WP_mt_TABLE." where mt_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        //select query
        $data = $wpdb->get_results("select * from ".WP_mt_TABLE." where mt_id=$DID limit 1");
    
        //bad feedback
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
            return;
        }
        
        $data = $data[0];
        
        //encode strings
        if ( !empty($data) ) $mt_id_x = htmlspecialchars(stripslashes($data->mt_id)); 
        if ( !empty($data) ) $mt_text_x = htmlspecialchars(stripslashes($data->mt_text));
        if ( !empty($data) ) $mt_status_x = htmlspecialchars(stripslashes($data->mt_status));
		if ( !empty($data) ) $mt_order_x = htmlspecialchars(stripslashes($data->mt_order));
        
        $submittext = "Update Message";
    }
    ?>
  <h2>Message ticker</h2>
  
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/message-ticker/setting.js"></script>
  <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/message-ticker/noenter.js"></script>
  <form name="form_mt" method="post" action="<?php echo @$mainurl; ?>" onsubmit="return mt_submit()"  >
    <table width="100%">
      <tr>
        <td colspan="3" align="left" valign="middle">Enter the message:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><textarea name="mt_text" cols="90" rows="8" id="mt_text"><?php echo @$mt_text_x; ?></textarea></td>
        <td width="17%" rowspan="3" align="center" valign="top"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Display Status:</td>
        <td align="left" valign="middle">Display Order:</td>
      </tr>
      <tr>
        <td width="20%" align="left" valign="middle"><select name="mt_status" id="mt_status">
            <option value="">Select</option>
            <option value='YES' <?php if(@$mt_status_x=='YES') { echo 'selected' ; } ?>>Yes</option>
            <option value='NO' <?php if(@$mt_status_x=='NO') { echo 'selected' ; } ?>>No</option>
          </select>        </td>
        <td width="63%" align="left" valign="middle"><input name="mt_order" type="text" id="mt_order" size="10" value="<?php echo @$mt_order_x; ?>" maxlength="3" /></td>
      </tr>
      <tr>
        <td height="35" colspan="3" align="left" valign="bottom"><input name="publish" lang="publish" class="button-primary" value="<?php echo @$submittext?>" type="submit" />
          <input name="publish" lang="publish" class="button-primary" onclick="_mt_redirect()" value="Cancel" type="button" /> 
          (enter key not allowed, use &lt;br&gt; tag to break line) </td>
      </tr>
      <input name="mt_id" id="mt_id" type="hidden" value="<?php echo @$mt_id_x; ?>">
    </table>
  </form>
<div align="right" style="padding-top:0px;padding:5px;"> 
<input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=message-ticker/message-ticker.php'" value="Text management page" type="button" />
<input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=message-ticker/setting.php'" value="Ticker setting page" type="button" />
<input name="Help" lang="publish" class="button-primary" onclick="window.open('http://www.gopipulse.com/work/2010/07/18/message-ticker/');" value="Help" type="button" />
</div>

  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".WP_mt_TABLE." order by mt_order");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="frm_hsa" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="4%" align="left" scope="col">ID
              </td>
            <th width="68%" align="left" scope="col">Message
              </td>
            <th width="8%" align="left" scope="col"> Order
              </td>
            <th width="7%" align="left" scope="col">Display
              </td>
            <th width="13%" align="left" scope="col">Action
              </td>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
		if($data->mt_status=='YES') { $displayisthere="True"; }
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle"><?php echo(stripslashes($data->mt_id)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->mt_text)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->mt_order)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->mt_status)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=message-ticker/message-ticker.php&DID=<?php echo($data->mt_id); ?>">Edit</a> &nbsp; <a onClick="javascript:_mt_delete('<?php echo($data->mt_id); ?>')" href="javascript:void(0);">Delete</a> </td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
        <?php if($displayisthere<>"True") { ?>
        <tr>
          <td colspan="5" align="center" style="color:#FF0000" valign="middle">No message available with display status 'Yes'!' </td>
        </tr>
        <?php } ?>
      </table>
    </form>
<div align="right" style="padding-top:0px;padding:5px;"> 
<input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=message-ticker/message-ticker.php'" value="Text management page" type="button" />
<input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=message-ticker/setting.php'" value="Ticker setting page" type="button" />
<input name="Help" lang="publish" class="button-primary" onclick="window.open('http://www.gopipulse.com/work/2010/07/18/message-ticker/');" value="Help" type="button" />
</div>
    <h2>Plugin configuration</h2>
    <ol>
        <li>Drag and drop the widget.</li>
        <li>Add directly in the theme.</li>
        <li>Short code option for pages/posts.</li>
    </ol>
    Check official website for live demo and more information <a target="_blank" href='http://www.gopipulse.com/work/2010/07/18/message-ticker/'>click here</a><br>
  </div>
</div>
<?php
}

function mt_add_to_menu() 
{
	add_options_page('Message ticker', 'Message ticker', 'manage_options', __FILE__, 'mt_admin_options' );
	add_options_page('Message ticker', '', 'manage_options', 'message-ticker/setting.php','' );
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
	echo ' <a href="options-general.php?page=message-ticker/setting.php">';
	echo 'click here</a></p>';
	?>
    Check official website for live demo and more information <a target="_blank" href='http://www.gopipulse.com/work/2010/07/18/message-ticker/'>click here</a>
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
