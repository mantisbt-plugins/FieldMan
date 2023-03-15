<?php
# FieldMan plugin 
# This script removes a definition of a mandatory Field
# It shows the definition and asks for comnfirmation
# that's all
$reqVar = '_' . $_SERVER['REQUEST_METHOD'];
$form_vars = $$reqVar;
$id = $form_vars['id'] ;


auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

layout_page_header( lang_get( 'plugin_format_title' ) );
layout_page_begin( 'manage_overview_page.php' );
print_manage_menu( 'manage_plugin_page.php' );

# get config
$def_fld	= plugin_config_get( 'standard_fields','FieldMan' );
$cus_fld	= plugin_config_get( 'custom_fields' ,'FieldMan');

$fm_table	= plugin_table('fields','FieldMan');
$sql	= "select * from $fm_table where id = $id" ;
$res	= db_query($sql);
$row	= db_fetch_array($res);
$field	= $row['manfield']; 
$cf		= $row['cf'];
$cat	= $row['category_id']; 
$proj	= $row['project_id']; 
$projname = project_get_name( $proj ); 
if ($cat<>0){
	$catname = category_get_name( $cat ); 
} else {
	$catname = plugin_lang_get( 'plugin_fm_category_all' );
}
?>


<div class="col-md-12 col-xs-12">
    <div class="space-10"></div>
        <div class="form-container" >
        <form action="<?php echo plugin_page( 'fm_delete' ) ?>" method="post">
		<input type="hidden" name="id" value="<?php echo $id;  ?>">
        <?php echo form_security_field( 'config_admin' ) ?>
            <div class="widget-box widget-color-blue2">
                <div class="widget-header widget-header-small">
                    <h4 class="widget-title lighter">
                        <i class="fa fa-cogs"></i>
                        <?php echo plugin_lang_get( 'plugin_remove_definition' ); ?>
                    </h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <div class="table-responsive">

                            <table class="table table-bordered table-condensed table-striped">

                                <tr>
                                    <th class="category width-40">
                                        <?php echo lang_get( 'email_project' ); ?>
                                    </th>
                                    <td width="60%">
                                        <?php echo $projname; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="category width-40">
                                        <?php echo lang_get( 'email_category' ); ?>
                                    </th>
                                    <td width="60%">
                                        <?php echo $catname; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="category width-40">
                                        <?php echo lang_get( 'custom_field' ); ?>
                                    </th>
                                    <td width="60%">
                                        <?php echo $field; ?>
                                    </td>
                                </tr>
								<?php if ( ON == $cus_fld ) { ?>
									<tr>
										<th class="category width-40">
											<?php echo "ID"; ?>
										</th>
										<td width="60%">
											<?php echo $cf; ?>
										</td>
									</tr>
								<?php } ?>
                            </table>
                        </div>
                    </div>

                    <div class="widget-toolbox padding-8 clearfix">
                        <input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo plugin_lang_get( 'plugin_remove_definition' )?>" />
						&nbsp;<====>&nbsp; <a href="plugin.php?page=FieldMan/manage_fm" ><b><?php echo plugin_lang_get( 'plugin_fm_back' ) ?></b></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<?php layout_page_end(); 