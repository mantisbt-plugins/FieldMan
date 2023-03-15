<?php
class FieldManPlugin extends MantisPlugin {
 
	function register() {
		$this->name         = 'FieldMan';
		$this->description  = 'Define Mandatory fields per Project/Category.';
		$this->version      = '2.0.2';
		$this->requires     = array('MantisCore'       => '2.0.0',);
		$this->author       = 'Cas Nuy';
		$this->contact		= 'Cas-at-nuy.info';
		$this->url  	    = 'http://www.nuy.info';
		$this->page			= 'config';
	}
 
	function init() { 
		plugin_event_hook( 'EVENT_MENU_MANAGE',		'fm_menu' );
		plugin_event_hook( 'EVENT_UPDATE_BUG_DATA', 'checkfields' );
	}
	
	function config() {
		return array(
			'standard_fields'	=> OFF,
			'custom_fields'		=> ON,
			);
	}

 	function fm_menu() {
		return array( '<a href="' . plugin_page( 'manage_fm' ) . '">' . plugin_lang_get( 'plugin_fm_manage' ) .  '</a>', );
	}

	function checkfields($event, $newdata, $olddata) {
		$projectid	= $newdata->project_id;
		$catid		= $newdata->category_id;
		$fm_table	= plugin_table('fields','FieldMan');
		$sql= "select * from $fm_table where project_id = $projectid" ;
		$res= db_query($sql);
		// start checking the entries
		while ($row = db_fetch_array($res)) {
			$field	= $row['manfield']; 
			$cat	= $row['category_id']; 
			$cf		= $row['cf'];
			if ($cat <> 0 && $cat <> $catid){
				continue;
			} 
			// in case this is a custom field
			// we need to adjust the fieldname
            if ($cf > 0) {
                $field = "custom_field_".$cf;
                $testval = gpc_get_string($field) ;
            } else {
                $testval = $newdata->$field ;
            }
			if ( $testval == ""){
				// Throw error, field should be filled
				$message = "Mandatory field is empty: ".$field;
				if ($cf <>0) {
					$message = "Mandatory field is empty: ".$row['manfield'];			
				}
				trigger_error( $message, ERROR );
			}
		}
		return $newdata;
	}
 
     public function schema() {
        return array (
                array (
                        'CreateTableSQL',
                        array (
                                plugin_table ( "fields" ),
                                "
                        id             I       NOTNULL UNSIGNED AUTOINCREMENT PRIMARY,
                        project_id          I       ,
                        category_id            I       ,
						manfield		C(25),
                        cf              I
                        "
                        )
                )
        );
    }



}