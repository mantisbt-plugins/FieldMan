<?php
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_site_threshold' ) );

layout_page_header( lang_get( 'manage_link' ) );

layout_page_begin( __FILE__ );

print_manage_menu();
# get the config
$def_fld	= plugin_config_get( 'standard_fields' );
$cus_fld	= plugin_config_get( 'custom_fields' );
?> 
<div class="col-md-12 col-xs-12">
	<div class="space-10"></div>
	<div class="widget-box widget-color-blue2">
	<div class="widget-header widget-header-small">
		<h4 class="widget-title lighter">
			<i class="ace-icon fa fa-info"></i>
			<?php echo plugin_lang_get('plugin_fm_manage') ?>
		</h4>
	</div>
	      <form action="<?php echo plugin_page( 'manage_fm_add' ) ?>" method="post">
	<div class="widget-body">
	<div class="widget-main no-padding">
	<div class="table-responsive">
	<table id="manage-overview-table" class="table table-hover table-bordered table-condensed">
		<tr>
			<th class="category" colspan="5"><?php echo plugin_lang_get( 'plugin_fm_defined' ) ?></th></tr>
			
	<?php
	$fm_table	= plugin_table('fields','FieldMan');
	$sql= "select * from $fm_table order by project_id,category_id" ;
	$res= db_query($sql);
	?>
	<tr><td><b>Project</b></td><td><b>Category</b></td><td><b>Field</b></td>
	<?php if ( ON == $cus_fld ) { ?>
	<td><b>Custom Field nr</b></td>
	<?php } ?>
	<td><b><i>Actions</b></i></td></tr>
	<?php
	while ($row = db_fetch_array($res)) {
		?>
		<tr><td>
		<?php 
		$projectid = $row['project_id'] ;
		$sql= "select * from mantis_project_table where id = $projectid" ;
		$res2= db_query($sql);
		if ($res2){
			$row2 = db_fetch_array($res2);
			$name = $row2['name'] ;
		} else {
			$name = plugin_lang_get( 'plugin_fm_project_not_found' );
		}
		echo $name ;
		?>
		</td><td>
		<?php
		$catid = $row['category_id'];
		if ($catid == 0) {
			$cname = plugin_lang_get( 'plugin_fm_category_all' );
		} else {
			$sql= "select * from mantis_category_table where id = $projectid" ;
			$res3= db_query($sql);
			if ($res3){
				$row3 = db_fetch_array($res3);
				$cname = $row3['name'] ;
			} else {
				$cname = plugin_lang_get( 'plugin_fm_category_not_found' );
			}
		}
		echo $cname;
		?>
		</td><td>
		<?php echo $row['manfield'] ?>
		<?php if ( ON == $cus_fld ) { ?>		
		</td><td>
		<?php echo $row['cf'] ?>
		<?php } ?>	
		</td><td>
		<?php
		$link = plugin_page('manage_fm_delete.php&id='.$row['id']);
		?>
		<a href="<?php echo $link ?>"><?php echo plugin_lang_get( 'plugin_fm_delete' ) ?></a>
		</td></tr>		
		<?php
	}
	?>
	<tr class="spacer">
	<td colspan="5"></td>
	</tr>
	<tr class="hidden"></tr>
	</table>
	</div>
	<div class="widget-toolbox padding-8 clearfix">
	<select id="select-project-id" name="project_id" class="input-sm">
	<?php print_project_option_list( ALL_PROJECTS, false, null, true, true ) ?>
	</select> 
	&nbsp; <b>==>></b>&nbsp;
	<input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo plugin_lang_get( 'plugin_fm_add' )?>" />
	</div>
	</div>
	</div>
	</div>
</div>
<?php
layout_page_end();
 