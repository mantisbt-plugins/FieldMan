<?php
# FieldMan plugin 
# This script adds a definition of a mandatory Field
# That's all
auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

layout_page_header( lang_get( 'plugin_format_title' ) );
layout_page_begin( 'manage_overview_page.php' );
print_manage_menu( 'manage_plugin_page.php' );
if ( !isset( $_POST['project_id'] ) ) { 
	return ;
} else {
	$id = $_POST['project_id'];
}

# get config
$def_fld	= plugin_config_get( 'standard_fields' );
$cus_fld	= plugin_config_get( 'custom_fields' );

$projname = project_get_name( $id ); 
# get available fields for this project
# first standard available fields
$ar1 = columns_get_standard( $p_enabled_columns_only = true ) ;
# next the linked custom fields
$ar2 = columns_get_linked_custom_fields($id) ;
//$ar2 = columns_get_standard( $p_enabled_columns_only = true ) ;
# finally combine the 2 arrays
$columns = array_merge($ar1, $ar2);
if ( ON == $def_fld ) {
	if ( ON == $cus_fld ) {
		$columns = array_merge($ar1, $ar2);
	} else {
		$columns= $ar1;
	}
} else {
	if ( ON == $cus_fld ) {
		$columns = $ar2;
	} else {
		TRIGGER_ERROR(ERROR_FM_NOFIELDS, ERROR);
	}	
}
?>


<div class="col-md-12 col-xs-12">
    <div class="space-10"></div>
        <div class="form-container" >
        <form action="<?php echo plugin_page( 'fm_add' ) ?>" method="post">
		<input type="hidden" name="id" value="<?php echo $id;  ?>">
        <?php echo form_security_field( 'config_admin' ) ?>
            <div class="widget-box widget-color-blue2">
                <div class="widget-header widget-header-small">
                    <h4 class="widget-title lighter">
                        <i class="fa fa-cogs"></i>
                        <?php echo plugin_lang_get( 'plugin_add_definition' ); ?>
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
									<select name="catid" id="catid">
                                        <?php print_category_option_list( 0,  $id ); ?>
									</select>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="category width-40">
                                        <?php echo lang_get( 'custom_field' ); ?>
                                    </th>
                                    <td width="60%">
									<select name="field" id="field">
                                        <?php print_field_list($columns); ?>
									</select>
                                    </td>
                                </tr>

   
                            </table>
                        </div>
                    </div>

                    <div class="widget-toolbox padding-8 clearfix">
                        <input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo plugin_lang_get( 'plugin_add_definition' )?>" />
						&nbsp;<====>&nbsp; <a href="plugin.php?page=FieldMan/manage_fm" ><b><?php echo plugin_lang_get( 'plugin_fm_back' ) ?></b></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<?php 
layout_page_end(); 

/**
 * Get all columns for existing custom_fields linked to project
 * @return string Array of column names
 */
 
function columns_get_linked_custom_fields($t_project_id) {
	static $t_col_names = null;
	if( isset( $t_col_names ) ) {
		return $t_col_names;
	}
	$t_all_cfids = custom_field_get_ids();
	$t_col_names = array();
	foreach( $t_all_cfids as $t_id ) {
//		if ( custom_field_is_linked( $t_id, $t_project_id ) ) {
			$t_col_names[] = column_get_custom_field_column_name( $t_id );
//		}
	}
	return $t_col_names;
}

/**
 * Print a list of available fields fo the current projcet
 */

Function print_field_list($columns){
    foreach($columns as $column => $value) 
    {
		echo '<option value="'. $value .'">'. $value .'</option>';
    }
}
