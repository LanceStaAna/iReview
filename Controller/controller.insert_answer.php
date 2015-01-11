<?php
	session_start();
	require dirname(dirname(__FILE__)) .'/Model/model.database.php';
	
	function zf_insert_question($fa_insert_values) {
		
	/**
		$fa_insert_values = array(
				
				'in_user_id' => '1',
				'in_answer_id' => '1',
				'in_question' => 'TEST',
				'in_question_type' => 'TEST',
		);
	 */

	$fa_insert_parameters = array(
				
			'fel_USER_ID' => $_SESSION['USER_ID'],
			'fel_ANSWER_ID' => NULL,
			'fel_FC_QUESTION' => $fa_insert_values['message'],
			'fel_FC_QUESTION_TYPE' => MC
	);


	Database::insertRow("QUESTIONS(FN_USER_ID, FN_ANSWER_ID, FC_QUESTION, FC_QUESTION_TYPE)
						 VALUES(:fel_USER_ID, :fel_ANSWER_ID, :fel_FC_QUESTION, :fel_FC_QUESTION_TYPE)", $fa_insert_parameters);
}
	if(isset($_POST))
	{
		zf_insert_question($_POST);
	}
	


?>