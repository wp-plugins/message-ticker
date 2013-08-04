<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php echo WP_mt_TITLE; ?></h2>	
    <?php
	$mt_title = get_option('mt_title');
	$mt_width = get_option('mt_width');
	$mt_height = get_option('mt_height');
	$mt_delay = get_option('mt_delay');
	$mt_speed = get_option('mt_speed');
	
	if (@$_POST['mt_submit']) 
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('mt_form_setting');
			
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
		
		?>
		<div class="updated fade">
			<p><strong>Details successfully updated.</strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/message-ticker/pages/setting.js"></script>
    <form name="mt_form" method="post" action="">
        <h3>Widget setting</h3>
		<label for="tag-width">Widget title</label>
		<input name="mt_title" type="text" value="<?php echo $mt_title; ?>"  id="mt_title" size="70" maxlength="100">
		<p>Please enter your widget title.</p>
		
		<label for="tag-width">Widget width</label>
		<input name="mt_width" type="text" value="<?php echo $mt_width; ?>"  id="mt_width" maxlength="5"> 
		<p>Please enter widget width</p>
		
		<label for="tag-width">Widget height</label>
		<input name="mt_height" type="text" value="<?php echo $mt_height; ?>"  id="mt_height" maxlength="5">
		<p>Please enter widget height</p>
		<h3>Global setting</h3>
		<label for="tag-width">Delay (Global setting)</label>
		<input name="mt_delay" type="text" value="<?php echo $mt_delay; ?>"  id="mt_delay" maxlength="5">
		<p>Please enter your ticker delay. (Example: 3000)</p>
		
		<label for="tag-width">Speed (Global setting)</label>
		<input name="mt_speed" type="text" value="<?php echo $mt_speed; ?>"  id="mt_speed" maxlength="5">
		<p>Please enter your ticker speed. (Example: 5)</p>
		
		<label for="tag-width"></label>
		
		<p></p>
		
		<p class="submit">
		<input name="mt_submit" id="mt_submit" class="button" value="Submit" type="submit" />
		<input name="publish" lang="publish" class="button" onclick="mt_redirect()" value="Cancel" type="button" />
		<input name="Help" lang="publish" class="button" onclick="mt_help()" value="Help" type="button" />
		</p>
		<?php wp_nonce_field('mt_form_setting'); ?>
    </form>
  </div>
  <p class="description"><?php echo WP_mt_LINK; ?></p>
</div>
