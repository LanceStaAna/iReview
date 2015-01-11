<div class="modal-header modal-header-success">
					
		<a href="#" class="close btn-lg" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span></a>
		<h4><strong>Authentication Required</strong></h4>
	
	</div>
	
	
	<div class="modal-body">
	
		<form id="group_authentication_form" action="Controller/controller.group_authentication.php" class="form-horizontal" method="post">
			
			<div class="form-group">
								
				<div class="col-sm-12">
					<input type="hidden" name="in_group_id" value="<?=htmlentities($_POST['in_group_id']);?>">
					<input type="password" id="group_pass" name="in_password" class="form-control input-sm" placeholder="Group Pass Code">
				</div>
			
			</div>
			
			
			<div class="form-group">
			<center>
				<div class="col-md-12">
				
				<input class="btn btn-primary group-authenticate-button" type="submit" value="Authenticate">
	
				</div>
			</center>
			</div>		
			
		</form>
			
</div>


<script type="text/javascript">


	$('form#group_authentication_form').on('submit', function () {
		
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
			//	console.log(response);
				$("#modal_group_authentication").modal('hide'); //hide popup 
				$('.group_authentication_result_content').html(data);
				$("#modal_authentication_result").modal('show'); //hide popup 
				
			}
			
		});
			
		return false;
	});	

	
</script>