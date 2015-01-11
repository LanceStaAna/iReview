<?php 
session_start();

require dirname(dirname(__FILE__)) .'/Model/model.database.php';

function cm_array_up($fv_td_array) {
	// loops a $td_array and makes it into an associative array and returns it

	foreach ($fv_td_array as $row)
		return $row;
}

function zf_authenticate_group($fa_query_values) {
	
	
	$qcel_group = array(
			'qcel_GROUP_ID' => $fa_query_values['in_group_id'],
			'qcel_GROUP_PASSCODE' => $fa_query_values['in_password']
	);
	
	$td_group = Database::getOnlyOneRow_v2("GROUPS WHERE FN_GROUP_ID = :qcel_GROUP_ID AND FC_GROUP_PASSCODE = :qcel_GROUP_PASSCODE", $qcel_group);
	
	if ($td_group) {
		
		return cm_array_up($td_group);
	}else{
		
		return false;
	}
}

?>

<?php if (isset($_POST)) :  $td_group = zf_authenticate_group($_POST); ?>

	<?php if ($td_group) :  ?>
	
		
		<script type="text/javascript">

			window.location.href = "questions.php";
		
		</script>
				
				
	<?php else : ?>
	
		<div class="modal-header modal-header-danger">	
						
			<a href="#" class="close btn-lg" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span></a>
			<h4><strong>Authenticaiton Failed</strong></h4>
		
		</div>
		
		
		<div class="modal-body">
				
				
		</div>
	
	<?php endif;?>
	
	
<?php endif; ?>	
	
	
	
	