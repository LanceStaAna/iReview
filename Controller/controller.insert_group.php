<?php
//print_r($_POST);

require dirname(dirname(__FILE__)) .'/Model/model.database.php';

function zf_insert_group($fa_insert_values) {


	$fa_insert_parameters = array(

			'fel_USER_ID' => $fa_insert_values['in_user_id'],
			'fel_GROUP_PASSCODE' => $fa_insert_values['in_group_passcode'],
			'fel_GROUP_NAME' => $fa_insert_values['in_group_name'],
			'fel_SUBJECT_CATEGORY' => $fa_insert_values['in_subject_id']
	);

	Database::insertRow("GROUPS(FN_USER_ID, FC_GROUP_PASSCODE, FC_GROUP_NAME, FC_SUBJECT_CATEGORY)
						 VALUES(:fel_USER_ID, :fel_GROUP_PASSCODE, :fel_GROUP_NAME, :fel_SUBJECT_CATEGORY)", $fa_insert_parameters);
}


zf_insert_group($_POST);