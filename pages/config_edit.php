<?php
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$f_standard_fields			= gpc_get_int('standard_fields', OFF);
$f_custom_fields			= gpc_get_int('custom_fields', ON);

plugin_config_set('standard_fields'			, $f_standard_fields);
plugin_config_set('custom_fields'			, $f_custom_fields);


print_header_redirect( plugin_page( 'config',TRUE ) );
