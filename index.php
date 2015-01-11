<?php
session_start();

require 'Model/model.database.php';
function cm_array_up($fv_td_array) {
	// loops a $td_array and makes it into an associative array and returns it
	 
	foreach ($fv_td_array as $row)
		return $row;
}

//-------------INSERT--------------

//
function zf_insert_user($fa_insert_values) {

	/**
		$fa_insert_values = array(
			
			'in_firstname' => 'Elias',
			'in_lastname' => 'Pallarca',
			'in_email' => 'eliashar.pallarca@uap.asia',
			'in_password' => 'ateneohacks2015',
			'in_school' => 'University of Asia and the Pacific',
			'in_contact_number' => '09352821478'
		);
	 */
	
	$fa_insert_parameters = array(
			
			'fel_USER_FIRSTNAME' => htmlentities($fa_insert_values['in_firstname']),
			'fel_USER_LASTNAME' => htmlentities($fa_insert_values['in_lastname']),
			'fel_USER_EMAIL' => htmlentities($fa_insert_values['in_email']),
			'fel_USER_PASSWORD' => htmlentities($fa_insert_values['in_password']),
			'fel_USER_SCHOOL' => htmlentities($fa_insert_values['in_school']),
			'fel_USER_CONTACT_NUMBER' => htmlentities($fa_insert_values['in_contact_number'])
	);
	
	Database::insertRow("USERS(FC_USER_FIRSTNAME, FC_USER_LASTNAME, FC_USER_EMAIL, FC_USER_PASSWORD, FC_USER_SCHOOL, FC_USER_CONTACT_NUMBER) 
						 VALUES(:fel_USER_FIRSTNAME, :fel_USER_LASTNAME, :fel_USER_EMAIL, :fel_USER_PASSWORD, :fel_USER_SCHOOL, :fel_USER_CONTACT_NUMBER)", $fa_insert_parameters);
}

//
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
				
			'fel_USER_ID' => $fa_insert_values['in_user_id'],
			'fel_ANSWER_ID' => $fa_insert_values['in_answer_id'],
			'fel_FC_QUESTION' => $fa_insert_values['in_question'],
			'fel_FC_QUESTION_TYPE' => $fa_insert_values['in_question_type']
	);


	Database::insertRow("QUESTIONS(FN_USER_ID, FN_ANSWER_ID, FC_QUESTION, FC_QUESTION_TYPE)
						 VALUES(:fel_USER_ID, :fel_ANSWER_ID, :fel_FC_QUESTION, :fel_FC_QUESTION_TYPE)", $fa_insert_parameters);
}

//
function zf_insert_group_member($fa_insert_values) {
	
	/**
		$fa_insert_values = array(
				
				'in_group_id' => '1',
				'in_user_id' => '1',
		);

	 */

	$fa_insert_parameters = array(
	
			'fel_GROUP_ID' => $fa_insert_values['in_group_id'],
			'fel_USER_ID' => $fa_insert_values['in_user_id'],
	);
	
	Database::insertRow("GROUP_MEMBERS(FN_GROUP_ID, FN_USER_ID)
						 VALUES(:fel_GROUP_ID, :fel_USER_ID)", $fa_insert_parameters);
}

//
function zf_insert_answer($fa_insert_values) {
	
	/**
		$fa_insert_values = array(
				
				'in_user_id' => '1',
				'in_question_id' => '1',
		 		'in_answer' => 'TEST',
		);
	 */
	
	
	$fa_insert_parameters = array(
	
			'fel_USER_ID' => $fa_insert_values['in_user_id'],
			'fel_QUESTION_ID' => $fa_insert_values['in_question_id'],
			'fel_ANSWER' => $fa_insert_values['in_answer'],
	);
	
	
	Database::insertRow("ANSWERS(FN_USER_ID, FN_QUESTION_ID, FC_ANSWER)
						 VALUES(:fel_USER_ID, :fel_QUESTION_ID, :fel_ANSWER)", $fa_insert_parameters);
}


//--------------UPDATE-------------

// 
function zf_vote_up($fv_answer_id) {
	
	//get selected answer
	$qcel_selected_answer = array(
			'fel_ANSWER_ID' => $fv_answer_id
	);
	$td_selected_answer = Database::getRow_v2("ANSWERS WHERE FN_ANSWER_ID = :fel_ANSWER_ID", $qcel_selected_answer);
	
	$fa_selected_answer = cm_array_up($td_selected_answer);
	
	//add 1 vote to selected answer
	$fv_vote_up = $fa_selected_answer['FN_VOTES_UP'] + 1;

	//update vote count of selected answer
	$fa_update_vote = array(
			'fel_ANSWER_ID' => $fv_answer_id,
			'fel_VOTES_UP' => $fv_vote_up
	);
	
	Database::updateRow("ANSWERS SET `FN_VOTES_UP` = :fel_VOTES_UP WHERE FN_ANSWER_ID = :fel_ANSWER_ID", $fa_update_vote);
	
}

//
function zf_vote_down($fv_answer_id) {

	//get selected answer
	$qcel_selected_answer = array(
			'fel_ANSWER_ID' => $fv_answer_id
	);
	$td_selected_answer = Database::getRow_v2("ANSWERS WHERE FN_ANSWER_ID = :fel_ANSWER_ID", $qcel_selected_answer);

	$fa_selected_answer = cm_array_up($td_selected_answer);

	//subtract 1 vote to selected answer
	$fv_vote_down = $fa_selected_answer['FN_VOTES_DOWN'] - 1;

	//update vote count of selected answer
	$fa_update_vote = array(
			'fel_ANSWER_ID' => $fv_answer_id,
			'fel_VOTES_DOWN' => $fv_vote_down
	);

	Database::updateRow("ANSWERS SET `FN_VOTES_DOWN` = :fel_VOTES_DOWN WHERE FN_ANSWER_ID = :fel_ANSWER_ID", $fa_update_vote);
}


//--------------QUERY--------------

//
function zf_authenticate($fa_query_values) {
	
	$qcel_user = array(
			'fel_USER_EMAIL' => htmlentities($fa_query_values['in_email']),
			'fel_USER_PASSWORD' => htmlentities($fa_query_values['in_password'])
	);
	$td_user = Database::getOnlyOneRow_v2("USERS WHERE FC_USER_EMAIL = :fel_USER_EMAIL AND FC_USER_PASSWORD = :fel_USER_PASSWORD", $qcel_user);
	
	if ($td_user) {
		
		return cm_array_up($td_user);
	}else {
		
		return false;
	}
	
}

//
function zf_get_all_subjects() {
	
	return Database::getRow_v2("SUBJECTS");
}

//
function zf_get_selected_subject_info($fv_subject_id) {
	
	$qcel_selected_group = array(
			'qcel_SUBJECT_ID' => $fv_subject_id
	);
	
	$td_selected_group = Database::getOnlyOneRow_v2("SUBJECTS WHERE FN_SUBJECT_ID = :qcel_SUBJECT_ID", $qcel_selected_group);
	
	if ($td_selected_group) {
		
		return cm_array_up($td_selected_group);	
	}else{
		
		return false;
	}
	
}

//
function zf_get_subject_circles($fv_subject_id) {
	
	$qcel_groups = array(
			'qcel_SUBJECT_CATEGORY' => $fv_subject_id
	);
	
	$td_groups = Database::getRow_v2("GROUPS INNER JOIN USERS ON GROUPS.FN_USER_ID = USERS.FN_USER_ID WHERE FC_SUBJECT_CATEGORY = :qcel_SUBJECT_CATEGORY", $qcel_groups);
	
	if ($td_groups) {
	
		return $td_groups;
	}else{
	
		return false;
	}
}

//---------------FORM LOGICS-------



if (isset($_POST['register_button'])) {
	
	zf_insert_user($_POST);
	header("Location: ./");
}

if (isset($_POST['sign_in_button'])) {
	
	
	$pv_valid_user = zf_authenticate($_POST);
	
	if ($pv_valid_user) {
		
	
		//SET SESSION_ID
		$_SESSION['USER_ID'] = $pv_valid_user['FN_USER_ID'];
		header("Location ./");
		
	}else {
		
		echo "Login Error";
	}
	
}

?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
<title></title>

<link href="Bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="Bootstrap/css/styles.css" rel="stylesheet">
<!-- <link href ="Bootstrap/css/font-awesome.min.css" rel="stylesheet"> -->
<!-- <link href ="Bootstrap/css/clean-blog.css" rel="stylesheet"> -->



</head>

	<!-- NOT A LOGGED USER -->
	<?php if (empty($_SESSION['USER_ID'])) : ?>

		<?php if (empty($_GET['do'])) : ?>
	
			<?php require 'View/login.html';?>
	
		<?php endif; ?>
	
		
	
		<?php if (isset($_GET['do']) && $_GET['do'] == 'register') : ?>
	
			<?php require 'View/sign_up.html';?>
	
		<?php endif;?>
	
	
	
	<!-- LOGGED USER -->
	<?php else : ?>
		
		<!-- 		<php echo $_SESSION['USER_ID']; ?> -->
		<?php 
			$td_all_subjects = zf_get_all_subjects();
		?>
		

		<?php if (empty($_GET['subject'])) : ?>
		
			<?php require 'View/subjects.html';?>
		
		
		<?php else : ?>
			
			<!-- GET SELECTED SUBJECT INFO -->
			<?php 
			
				$td_selected_subject = zf_get_selected_subject_info($_GET['subject']); 
				$td_circles = zf_get_subject_circles($_GET['subject']);
				//print_r($td_circles);
				
			?>
			
				
			<?php require 'View/grouplist.html';?>
		
		
		<?php endif; ?>
		
		
			
	<?php endif; ?>





	<!-- GROUP PASS AUTHENTICATION MODAL -->
	<div class="modal fade" id="modal_group_authentication" role="dialog">
		<div class="modal-dialog">
	
			<div class="modal-content group_authentication-content">
				
				
			</div>
			
		</div>
	</div>

	
	<!-- AUTHENTICATION RESULT -->
	<div class="modal fade" id="modal_authentication_result" role="dialog">
		<div class="modal-dialog">
	
			<div class="modal-content group_authentication_result_content">
				
				
			</div>
			
		</div>
	</div>
	
	
	<!-- NEW GROUP -->
	<div class="modal fade" id="modal_new_group" role="dialog">
		<div class="modal-dialog">
	
			<div class="modal-content new_group_content">
				
				
				
			</div>
			
		</div>
	</div>
	
	
	

<!-- SCRIPTS -->

<script src="Bootstrap/js/jquery-2.1.1.js"></script>
<script src="Bootstrap/js/bootstrap.min.js"></script>
    
<script type="text/javascript">


	$(document).on("click", ".enter-selected-group", function () {
		
		var groupid = $(this).data('id');
	
		$.post("Controller/controller.group_login.php", {in_group_id: groupid}, function(data){
	
			//console.log(result);
			$('.group_authentication-content').html(data);
			
		});
		
	});


	$(document).on("click", ".new_group", function () {
		
		var subjectid = $(this).data('id');
	
		$.post("Controller/controller.new_group.php", {in_subject_id: subjectid}, function(data){
	
			//console.log(result);
			$('.new_group_content').html(data);
			
		});
		
	});
	
	
</script>
    
    
</html>












