<?PHP
$fm_table	= plugin_table('fields','FieldMan');
$proj		= $_REQUEST['id'];
$cat		= $_POST['catid'];
$field		= $_POST['field'];
// is this a custom field?
if ( column_is_custom_field( $field )) {
	# get the value
	$field1 = trim(substr($field,7));
	$cf = custom_field_get_id_from_name( $field1 );
} else {
	$cf = 0;
}
// check if entry already exists
$sql		= "select * from $fm_table where project_id=$proj and category_id=$cat and cf=$cf and manfield = '$field' ";
$result		= db_query($sql);
$res2		= db_num_rows($result);
if ($res2 == 0){
	# add the definitiom
	$sql = "INSERT INTO $fm_table ( project_id,category_id,manfield, cf) VALUES (  $proj, $cat, '$field', $cf)";
	if(!db_query($sql)){ 
		trigger_error( ERROR_DB_QUERY_FAILED, ERROR );
	}
}
print_header_redirect( 'plugin.php?page=FieldMan/manage_fm' );