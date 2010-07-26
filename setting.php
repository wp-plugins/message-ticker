<div class="wrap">
  <h2><?php echo wp_specialchars( 'Message ticker' ); ?></h2>
  <?php
global $wpdb, $wp_version;

$mt_title = get_option('mt_title');
$mt_width = get_option('mt_width');
$mt_height = get_option('mt_height');
$mt_delay = get_option('mt_delay');
$mt_speed = get_option('mt_speed');

if ($_POST['mt_submit']) 
{
	$mt_title = stripslashes($_POST['mt_title']);
	$mt_width = stripslashes($_POST['mt_width']);
	$mt_height = stripslashes($_POST['mt_height']);
	$mt_delay = stripslashes($_POST['mt_delay']);
	$mt_speed = stripslashes($_POST['mt_speed']);

	update_option('mt_title', $mt_title );
	update_option('mt_width', $mt_width );
	update_option('mt_height', $mt_height );
	update_option('mt_delay', $mt_delay );
	update_option('mt_speed', $mt_speed );

}

?>
  <form name="form_mt" method="post" action="">
    <div align="left" style="padding-top:5px;padding-bottom:5px;"> <a href="options-general.php?page=message-ticker/message-ticker.php">Manage Page</a> <a href="options-general.php?page=message-ticker/setting.php">Setting Page</a> </div>
    <table width="800" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td colspan="2" align="left" valign="bottom">Title: </td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="bottom"><input name="mt_title" type="text" value="<?php echo $mt_title; ?>"  id="mt_title" size="120" maxlength="100"></td>
      </tr>
      
      <tr align="left" valign="middle">
        <td width="314" valign="bottom">Width:</td>
      <td width="474" height="230" rowspan="8" align="center" valign="middle"></tr>
      <tr align="left" valign="middle">
        <td valign="middle"><input name="mt_width" type="text" value="<?php echo $mt_width; ?>"  id="mt_width" maxlength="5">
        only number         </td>
      </tr>
      <tr align="left" valign="middle">
        <td valign="middle">Height:</td>
      </tr>
      <tr align="left" valign="middle">
        <td valign="middle"><input name="mt_height" type="text" value="<?php echo $mt_height; ?>"  id="mt_height" maxlength="5"> 
        only number         </td>
      </tr>
      <tr align="left" valign="middle">
        <td valign="middle">Delay:</td>
      </tr>
      <tr>
        <td align="left" valign="middle"><input name="mt_delay" type="text" value="<?php echo $mt_delay; ?>"  id="mt_delay" maxlength="5"> 
        only number </td>
      </tr>
      <tr>
        <td align="left" valign="middle">Speed:</td>
      </tr>
      <tr>
        <td align="left" valign="middle"><input name="mt_speed" type="text" value="<?php echo $mt_speed; ?>"  id="mt_speed" maxlength="5"> 
        only number </td>
      </tr>
      
      
      <tr>
        <td height="40" align="left" valign="bottom"><input name="mt_submit" id="mt_submit" lang="publish" class="button-primary" value="Update Setting" type="submit" /></td>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
    </table>
  </form>
  <h2><?php echo wp_specialchars( 'Paste the below code to your desired template location!' ); ?></h2>
  <div style="padding-top:7px;padding-bottom:7px;"> <code style="padding:7px;"> &lt;?php if (function_exists (mt_show)) mt_show(); ?&gt; </code></div>
  <br />
  <div align="left" style="padding-top:10px;padding-bottom:5px;"> 
  <a href="options-general.php?page=message-ticker/message-ticker.php">Manage Page</a> 
  <a href="options-general.php?page=message-ticker/setting.php">Setting Page</a> 
  </div>
	<h2><?php echo wp_specialchars( 'About plugin!' ); ?></h2>
	Plug-in created by <a target="_blank" href='http://www.gopiplus.com/work/'>Gopi</a>.<br>
	<a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/message-ticker/'>Click here</a> to post suggestion or comments or feedback.<br>
	<a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/message-ticker/'>Click here</a> to see live demo.<br>
	<a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/message-ticker/'>Click here</a> to see more info.<br>
	<a target="_blank" href='http://www.gopiplus.com/work/plugin-list/'>Click here</a> to see my other plugins.<br>
</div>
