<?php
auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

layout_page_header( plugin_lang_get( 'plugin_format_title' ) );

layout_page_begin( 'manage_overview_page.php' );

print_manage_menu( 'manage_plugin_page.php' );

?>

<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" > 
<br/>
<form action="<?php echo plugin_page( 'config_edit' ) ?>" method="post">
<div class="widget-box widget-color-blue2">
<div class="widget-header widget-header-small">
	<h4 class="widget-title lighter">
		<i class="ace-icon fa fa-text-width"></i>
		<?php echo plugin_lang_get( 'plugin_format_title' ) . ': ' . lang_get( 'plugin_format_config' )?>
	</h4>
</div>
<div class="widget-body">
<div class="widget-main no-padding">
<div class="table-responsive"> 
<table class="table table-bordered table-condensed table-striped"> 


<tr>
	<td class="category" width="60%">
		<?php echo plugin_lang_get( 'plugin_standard_fields' ) ?>
	</td>
	<td class="right" width="20%">
		<label><input type="radio" name="standard_fields" value="1" <?php echo ( ON == plugin_config_get( 'standard_fields' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'plugin_format_enabled' ) ?></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="standard_fields" value="0" <?php echo ( OFF == plugin_config_get( 'standard_fields' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'plugin_format_disabled' ) ?></label>
	</td>
</tr>

<tr>
	<td class="category" width="60%">
		<?php echo plugin_lang_get( 'plugin_custom_fields' ) ?>
	</td>
	<td class="right" width="20%">
		<label><input type="radio" name="custom_fields" value="1" <?php echo ( ON == plugin_config_get( 'custom_fields' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'plugin_format_enabled' ) ?></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="custom_fields" value="0" <?php echo ( OFF == plugin_config_get( 'custom_fields' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'plugin_format_disabled' ) ?></label>
	</td>
</tr>

</table>
</div>
</div>
<div class="widget-toolbox padding-8 clearfix">
	<input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo lang_get( 'change_configuration' )?>" />
</div>
</div>
</div>
</form>
</div>
</div>
 
<?php
layout_page_end();