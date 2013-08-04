<div class="wrap">
<?php
$mt_errors = array();
$mt_success = '';
$mt_error_found = FALSE;

// Preset the form fields
$form = array(
	'mt_id' => '',
	'mt_text' => '',
	'mt_order' => '',
	'mt_status' => '',
	'mt_group' => ''
);

// Form submitted, check the data
if (isset($_POST['mt_form_submit']) && $_POST['mt_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('mt_form_add');
	
	$form['mt_text'] = isset($_POST['mt_text']) ? $_POST['mt_text'] : '';
	if ($form['mt_text'] == '')
	{
		$mt_errors[] = __('Please enter the text.', WP_mt_UNIQUE_NAME);
		$mt_error_found = TRUE;
	}

	$form['mt_order'] = isset($_POST['mt_order']) ? $_POST['mt_order'] : '';
	if ($form['mt_order'] == '')
	{
		$mt_errors[] = __('Please enter the display order, only number.', WP_mt_UNIQUE_NAME);
		$mt_error_found = TRUE;
	}

	$form['mt_status'] = isset($_POST['mt_status']) ? $_POST['mt_status'] : '';
	if ($form['mt_status'] == '')
	{
		$mt_errors[] = __('Please select the display status.', WP_mt_UNIQUE_NAME);
		$mt_error_found = TRUE;
	}
	
	$form['mt_group'] = isset($_POST['mt_group']) ? $_POST['mt_group'] : '';

	//	No errors found, we can add this Group to the table
	if ($mt_error_found == FALSE)
	{
		$sql = $wpdb->prepare(
			"INSERT INTO `".WP_mt_TABLE."`
			(`mt_text`, `mt_order`, `mt_status`, `mt_group`)
			VALUES(%s, %s, %s, %s)",
			array($form['mt_text'], $form['mt_order'], $form['mt_status'], $form['mt_group'])
		);
		
		$wpdb->query($sql);
		
		$mt_success = __('New details was successfully added.', WP_mt_UNIQUE_NAME);
		
		// Reset the form fields
		$form = array(
			'mt_id' => '',
			'mt_text' => '',
			'mt_order' => '',
			'mt_status' => '',
			'mt_group' => ''
		);
	}
}

if ($mt_error_found == TRUE && isset($mt_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $mt_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($mt_error_found == FALSE && strlen($mt_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $mt_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=message-ticker">Click here</a> to view the details</strong></p>
	</div>
	<?php
}
?>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/message-ticker/pages/setting.js"></script>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/message-ticker/pages/noenter.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php echo WP_mt_TITLE; ?></h2>
	<form name="form_mt" method="post" action="#" onsubmit="return mt_submit()"  >
      <h3>Add details</h3>
      
		<label for="tag-title">Enter the message/announcement</label>
		<textarea name="mt_text" cols="110" rows="6" id="mt_text"></textarea>
		<p>Please enter your message. Enter &lt;br&gt; to line break. </p>
		
		<label for="tag-title">Display status</label>
		<select name="mt_status" id="mt_status">
			<option value='YES'>Yes</option>
			<option value='NO'>No</option>
		</select>
		<p>Do you want to show this announcement in your scroll?</p>
		
		<label for="tag-title">Display order</label>
		<input name="mt_order" type="text" id="mt_order" value="" maxlength="3" />
		<p>What order should this announcement be played in. should it come 1st, 2nd, 3rd, etc..</p>
		
		<label for="tag-title">Message group</label>
		<select name="mt_group" id="mt_group">
		<option value='Select'>Select</option>
		<?php
		$sSql = "SELECT distinct(mt_group) as mt_group FROM `".WP_mt_TABLE."` order by mt_group";
		$myDistinctData = array();
		$arrDistinctDatas = array();
		$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
		$i = 0;
		foreach ($myDistinctData as $DistinctData)
		{
			$arrDistinctData[$i]["mt_group"] = strtoupper($DistinctData['mt_group']);
			$i = $i+1;
		}
		for($j=$i; $j<$i+5; $j++)
		{
			$arrDistinctData[$j]["mt_group"] = "GROUP" . $j;
		}
		$arrDistinctDatas = array_unique($arrDistinctData, SORT_REGULAR);
		foreach ($arrDistinctDatas as $arrDistinct)
		{
			?><option value='<?php echo strtoupper($arrDistinct["mt_group"]); ?>'><?php echo strtoupper($arrDistinct["mt_group"]); ?></option><?php
		}
		?>
		</select>
		<p>Please select your announcement group.</p>
					
      <input name="mt_id" id="mt_id" type="hidden" value="">
      <input type="hidden" name="mt_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="Submit" type="submit" />&nbsp;
        <input name="publish" lang="publish" class="button add-new-h2" onclick="mt_redirect()" value="Cancel" type="button" />&nbsp;
        <input name="Help" lang="publish" class="button add-new-h2" onclick="mt_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('mt_form_add'); ?>
    </form>
</div>
<p class="description"><?php echo WP_mt_LINK; ?></p>
</div>