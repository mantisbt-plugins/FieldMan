<?PHP
$reqVar		= '_' . $_SERVER['REQUEST_METHOD'];
$form_vars	= $$reqVar;
$id			= $form_vars['id'] ;
$fm_table	= plugin_table('fields','FieldMan');
# Deleting category
$sql 		= "DELETE FROM $fm_table WHERE id = $id";        
db_query($sql);
print_header_redirect( 'plugin.php?page=FieldMan/manage_fm' );