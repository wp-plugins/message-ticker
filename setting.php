<div class="wrap">
  <h2>Message ticker</h2>
  <?php
global $wpdb, $wp_version;

$mt_title = get_option('mt_title');
$mt_width = get_option('mt_width');
$mt_height = get_option('mt_height');
$mt_delay = get_option('mt_delay');
$mt_speed = get_option('mt_speed');

if (@$_POST['mt_submit']) 
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
    <table width="800" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td colspan="2" align="left" valign="bottom">Title: </td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="bottom"><input name="mt_title" type="text" value="<?php echo $mt_title; ?>"  id="mt_title" maxlength="100"></td>
      </tr>
      
      <tr align="left" valign="middle">
        <td width="314" valign="bottom">Width:</td>
      <td width="474" height="230" rowspan="8" align="center" valign="middle"></tr>
      <tr align="left" valign="middle">
        <td valign="middle"><input name="mt_width" type="text" value="<?php echo $mt_width; ?>"  id="mt_width" maxlength="5"> Only number</td>
      </tr>
      <tr align="left" valign="middle">
        <td valign="middle">Height:</td>
      </tr>
      <tr align="left" valign="middle">
        <td valign="middle"><input name="mt_height" type="text" value="<?php echo $mt_height; ?>"  id="mt_height" maxlength="5"> Only number</td>
      </tr>
      <tr align="left" valign="middle">
        <td valign="middle">Delay:</td>
      </tr>
      <tr>
        <td align="left" valign="middle"><input name="mt_delay" type="text" value="<?php echo $mt_delay; ?>"  id="mt_delay" maxlength="5"> Only number</td>
      </tr>
      <tr>
        <td align="left" valign="middle">Speed:</td>
      </tr>
      <tr>
        <td align="left" valign="middle"><input name="mt_speed" type="text" value="<?php echo $mt_speed; ?>"  id="mt_speed" maxlength="5"> Only number</td>
      </tr>
      
      
      <tr>
        <td height="40" align="left" valign="bottom"><input name="mt_submit" id="mt_submit" lang="publish" class="button-primary" value="Update Setting" type="submit" /></td>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
    </table>
  </form>
      <div align="right" style="padding-top:0px;padding:5px;"> 
    <input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=message-ticker/message-ticker.php'" value="Text management page" type="button" />
    <input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=message-ticker/setting.php'" value="Ticker setting page" type="button" />
    </div>
    <h2>Plugin configuration</h2>
    <ol>
        <li>Drag and drop the widget.</li>
        <li>Add directly in the theme.</li>
        <li>Short code option for pages/posts.</li>
    </ol>
    Check official website for live demo and more information <a target="_blank" href='http://www.gopipulse.com/work/2010/07/18/message-ticker/'>click here</a><br>
</div>
