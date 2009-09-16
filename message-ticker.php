<?php

/*
Plugin Name: message ticker
Plugin URI: http://gopi.coolpage.biz/demo/2009/09/13/message-ticker/
Description: This plug-in will display the announcement or message with simple horizontal scroller or horizontal ticker.
Version: 1.0
Author: Gopi.R
Author URI: http://gopi.coolpage.biz/demo/about/
Donate link: http://gopi.coolpage.biz/demo/2009/09/13/message-ticker/
*/

global $wpdb, $wp_version;
define("WP_mt_TABLE", $wpdb->prefix . "mt_plugin");

function mt_show()
{
	global $wpdb;
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
    <script src="<?php echo $siteurl; ?>/wp-content/plugins/message-ticker/message-ticker.js" type="text/javascript"></script>
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
	delete_option('mt_title');
	delete_option('mt_width');
	delete_option('mt_height');
	delete_option('mt_delay');
	delete_option('mt_speed');
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
		$sSql = $sSql . "VALUES ('This is sample text for message ticker.', '1', 'YES', '0000-00-00 00:00:00');";
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
    $title = __('message ticker');
    $mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=message-ticker/message-ticker.php";

	include_once("extra.php");
    $DID=@$_GET["DID"];
    $AC=@$_GET["AC"];
    $submittext = "Insert Message";

	if($AC <> "DEL" and trim($_POST['mt_text']) <>"")
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
  <h2><?php echo wp_specialchars( $title ); ?></h2>
  <div align="left" style="padding-top:5px;padding-bottom:5px;"> <a href="options-general.php?page=message-ticker/message-ticker.php">Manage Page</a> <a href="options-general.php?page=message-ticker/setting.php">Setting Page</a> </div>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/message-ticker/setting.js"></script>
  <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/message-ticker/noenter.js"></script>
  <form name="form_mt" method="post" action="<?php echo $mainurl; ?>" onsubmit="return mt_submit()"  >
    <table width="100%">
      <tr>
        <td colspan="3" align="left" valign="middle">Enter the message:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><textarea name="mt_text" cols="70" rows="8" id="mt_text"><?php echo $mt_text_x; ?></textarea></td>
        <td width="40%" rowspan="3" align="center" valign="top"><?php if (function_exists (timepass)) timepass(); ?>        </td>
      </tr>
      <tr>
        <td align="left" valign="middle">Display Status:</td>
        <td align="left" valign="middle">Display Order:</td>
      </tr>
      <tr>
        <td width="20%" align="left" valign="middle"><select name="mt_status" id="mt_status">
            <option value="">Select</option>
            <option value='YES' <?php if($mt_status_x=='YES') { echo 'selected' ; } ?>>Yes</option>
            <option value='NO' <?php if($mt_status_x=='NO') { echo 'selected' ; } ?>>No</option>
          </select>        </td>
        <td width="40%" align="left" valign="middle"><input name="mt_order" type="text" id="mt_order" size="10" value="<?php echo $mt_order_x; ?>" maxlength="3" /></td>
      </tr>
      <tr>
        <td height="35" colspan="3" align="left" valign="bottom"><input name="publish" lang="publish" class="button-primary" value="<?php echo $submittext?>" type="submit" />
          <input name="publish" lang="publish" class="button-primary" onclick="_mt_redirect()" value="Cancel" type="button" /> 
          (enter key not allowed, use &lt;br&gt; tage to break line) </td>
      </tr>
      <input name="mt_id" id="mt_id" type="hidden" value="<?php echo $mt_id_x; ?>">
    </table>
  </form>
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
    <div align="left" style="padding-top:10px;padding-bottom:10px;"> <a href="options-general.php?page=message-ticker/message-ticker.php">Manage Page</a> <a href="options-general.php?page=message-ticker/setting.php">Setting Page</a> </div>
    <h2><?php echo wp_specialchars( 'Paste the below code to your desired template location!' ); ?></h2>
    <div style="padding-top:7px;padding-bottom:7px;"> <code style="padding:7px;"> &lt;?php if (function_exists (mt_show)) mt_show(); ?&gt; </code></div>
    <br>
  Plug-in created by <a target="_blank" href='http://gopi.coolpage.biz/demo/about/'>Gopi</a>. <br /> 
  <a target="_blank" href='http://gopi.coolpage.biz/demo/2009/09/13/message-ticker/'>click here</a> to post suggestion or comments or how to improve this plugin.  <br />  
  <a target="_blank" href='http://gopi.coolpage.biz/demo/2009/09/13/message-ticker/'>click here</a> to see plugin demo.  <br />  
  <a target="_blank" href='http://gopi.coolpage.biz/demo/2009/09/13/message-ticker/'>click here</a> To see my other plugins.  <br />  
  <br>
  </div>
</div>
<?php
}

function mt_add_to_menu() 
{
	add_options_page('Software | Digital | Message ticker', 'message ticker', 7, __FILE__, 'mt_admin_options' );
	add_options_page('Software | Digital | Message ticker', '', 0, "message-ticker/setting.php",'' );
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
	echo '<p>message ticker.<br> To change the setting goto message ticker link under SETTING tab.';
	echo ' <a href="options-general.php?page=message-ticker/setting.php">';
	echo 'click here</a></p>';
}

function mt_widget_init() 
{
  	register_sidebar_widget(__('message ticker'), 'mt_widget');   
	
	if(function_exists('register_sidebar_widget')) 	
	{
		register_sidebar_widget('message ticker', 'mt_widget');
	}
	
	if(function_exists('register_widget_control')) 	
	{
		register_widget_control(array('message ticker', 'widgets'), 'mt_control',500,400);
	} 
}

add_action("plugins_loaded", "mt_widget_init");
register_activation_hook(__FILE__, 'mt_activation');
add_action('admin_menu', 'mt_add_to_menu');
register_deactivation_hook( __FILE__, 'mt_deactivate' );
?>
