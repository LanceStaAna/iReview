<?php
session_start();

?>

<div class="modal-header modal-header-success">
					
		<a href="#" class="close btn-lg" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span></a>
		<h4><strong>New Group</strong></h4>
	
</div>

<div class="modal-body">
	
	<form id="new_group_form" action="Controller/controller.insert_group.php" class="form-horizontal" method="post">
		
		<div class="form-group">
							
			<div class="col-sm-12">
				<input type="text" id="group_pass" name="in_group_name" class="form-control input-sm" placeholder="Group Name">
				<input type="hidden" name="in_subject_id" value="<?=htmlentities($_POST['in_subject_id']);?>">
				<input type="hidden" name="in_user_id" value="<?=htmlentities($_SESSION['USER_ID']);?>">
				<input type="hidden" name="in_group_passcode" value="1234">
			</div>
		
		</div>
		
		<div class="form-group">
							
			<div class="col-sm-12">
			Passcode: 1234
			</div>
		
		</div>
		
		<div class="form-group">
		<center>
			<div class="col-md-12">
			
			<input class="btn btn-primary create-group-button" type="submit" value="Create Group">

			</div>
		</center>
		</div>		
		
	</form>
			
</div>

<script type="text/javascript">


	$('form#new_group_form').on('submit', function () {
		
		var that = $(this),
			type = that.attr('method'),
			data = {};
			
		that.find('[name]').each(function(index, value){
			
			var that = $(this),
				name = that.attr('name'),
				value = that.val();
			
			data[name] = value;
			
		});
		
		$.ajax({
			
			url: that.attr('action'),
			type: type,
			data: data,
			success: function(data){
				//console.log(data);
				$("#modal_new_group").modal('hide'); //hide popup 
				location.reload();
			}
			
		});
			
		return false;
	});	

	
</script>