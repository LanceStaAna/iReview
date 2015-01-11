<?php 
	session_start();
		require'model/model.database.php';
		function cm_array_up($fv_td_array) {
			// loops a $td_array and makes it into an associative array and returns it
			 
			foreach ($fv_td_array as $row)
				return $row;
		}
		$qcel_user = array(
			'user_id' => $_SESSION['USER_ID']
		);
		
		$TD_user_info = cm_array_up( Database::getRow_v2('users WHERE FN_USER_ID = :user_id', $qcel_user));
		
	 //var_dump($TD_user_info);
	$TD_questions = Database::getRow_v2('questions INNER JOIN users ON questions.FN_USER_ID = users.FN_USER_ID ORDER BY FN_QUESTION_ID DESC');
	//var_dump($TD_questions);
	
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
	
	function zf_insert_answer($fa_insert_values) {
	
	/**
		$fa_insert_values = array(
				
				'in_user_id' => '1',
				'in_question_id' => '1',
		 		'in_answer' => 'TEST',
		);
	 */
	
	
	$fa_insert_parameters = array(
	
			'fel_USER_ID' => $fa_insert_values['in_uid'],
			'fel_QUESTION_ID' => $fa_insert_values['in_qid'],
			'fel_ANSWER' => $fa_insert_values['ans'],
	);
	
	
	Database::insertRow("ANSWERS(FN_USER_ID, FN_QUESTION_ID, FC_ANSWER)
						 VALUES(:fel_USER_ID, :fel_QUESTION_ID, :fel_ANSWER)", $fa_insert_parameters);
	}
	
	if(isset($_POST['submit_answer_button'])){
	
		zf_insert_answer($_POST);
	}
	
	if( isset($_GET['action']) && isset($_GET['ansid']) ){
		
		if($_GET['action'] == 'up'){
			 zf_vote_up($_GET['ansid']);
		}
		
		if($_GET['action'] == 'down'){
			 zf_vote_down($_GET['ansid']);
		}
		
		header("Location: ./questions.php");
	}
	
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8' />
<link href="Bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="Bootstrap/css/styles.css" rel="stylesheet">
<link href ="./Bootstrap/css/styles.css" rel="stylesheet">
<link href ="./Bootstrap/css/font-awesome.min.css" rel="stylesheet">
<link href ="./Bootstrap/css/clean-blog.css" rel="stylesheet">
</head>
<body>	
<?php 
$colours = array('007AFF','FF7000','FF7000','15E25F','CFC700','CFC700','CF1100','CF00BE','F00');
$user_colour = array_rand($colours);

?>

<script src="Bootstrap/js/jquery-2.1.1.js"></script>

			<script language="javascript" type="text/javascript">  
$(document).ready(function(){
	//create a new WebSocket object.
	var wsUri = "ws://localhost:9000/demo/server.php"; 	
	websocket = new WebSocket(wsUri); 
	
	websocket.onopen = function(ev) { // connection is open 
		//$('#message_box').append("<div class=\"system_msg\">Connected!</div>"); //notify user
	}

	$('#send-btn').click(function(){ //use clicks message send button	
		var mymessage = $('#message').val(); //get message text
		
		var myname = $('#name').val(); //get user name
		
		if(myname == ""){ //empty name?
			alert("Enter your Name please!");//validates if there's an active user
			return;
		}
		if(mymessage == ""){ //emtpy message?// validation of message
			alert("Enter Some message Please!");
			return;
		}
		
		//prepare json data
		var msg = {
		message: mymessage,
		name: myname
		};
		$.post("Controller/controller.insert_question.php",msg,function(response){
			console.log(response);
		});
		//convert and send data to server
		websocket.send(JSON.stringify(msg));
		
	});
	
	//#### Message received from server?
	websocket.onmessage = function(ev) {
	
		var msg = JSON.parse(ev.data); //PHP sends Json data
		var type = msg.type; //message type
		var umsg = msg.message; //message text
		var uname = msg.name; //user name
		var ucolor = msg.color; //color
		var pmsg = document.getElementById("message_box").innerHTML;
		//alert(pmsg);
		if(type == 'usermsg') 
		{
			document.getElementById("message_box").innerHTML = "<h2 class=\"post-title \">"+umsg+"</h2> <a class=\"post-meta\"> Posted by "+uname+"</a>" +  pmsg;
			
		}
		if(type == 'system')
		{
			//$('#message_box').append("<div class=\"system_msg\">"+umsg+"</div>");
		}
		
		$('#message').val(''); //reset text
	};
	
	websocket.onerror	= function(ev){$('#message_box').append("<div class=\"system_error\">Error Occurred - "+ev.data+"</div>");}; 
	websocket.onclose 	= function(ev){$('#message_box').append("<div class=\"system_msg\">Connection Closed</div>");}; 
});
</script>








</div>
  <div id="page-content-wrapper">
  <h2> Ask a question:</h2>	
            <div class="container-fluid">
               <!-- <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><span class="glyphicon glyphicon-list"></a>-->
						<div class="container">
				
						<div class="col-lg-8 col-lg-offset-1 col-md-10 col-md-offset-1">
                <div class="post-preview">
				<div class="panel">


	<div class="">
	  <div class="form-group">
		<label class="sr-only" for="exampleInputEmail2"></label>
		<input type="hidden" class="form-control" rows="4" cols="50"  name="name" value="<?=$TD_user_info['FC_USER_FIRSTNAME'];?>" id="name" maxlength="10"   />
		<input type="hidden" class="form-control" rows="4" cols="50"  name="userid" value="<?=$_SESSION['USER_ID'];?>" id="userid" maxlength="10"   />
	  </div>
	  <div class="form-group">
		<label class="sr-only" for="exampleInputPassword2">Password</label>
		<textarea class="form-control"  name="message" id="message" placeholder="Enter your question here!" maxlength="80"></textarea>
		
	  </div>
	 
	 <button class="btn pull-right" id="send-btn">Post</button>
	 <br/>
	 <br/>
	</div>


</div>
				<div class="message_box" id="message_box">
					
                  </div>
				  <?php if($TD_questions):
						foreach($TD_questions as $col):?>
						
                        <h2 class="post-title">
                            <?=$col['FC_QUESTION'];?>
                        </h2>
						
						<p class="post-meta">Posted by <?=$col['FC_USER_FIRSTNAME'];?> on September 24, 2014</p>
						<?php 
							$user_ques  = array(
								'uid' => $_SESSION['USER_ID'],
								'qid' => $col['FN_QUESTION_ID']
							);
							
						if(!Database::getRow_v2('answers WHERE FN_USER_ID = :uid AND FN_QUESTION_ID = :qid', $user_ques)):?>
						<button class="btn btn-success" onclick="myFunction()" id="answer-btn">Answer</button>
							<script>
						function myFunction(){
						document.getElementById("popupinput").style.visibility = "visible";
						document.getElementById("answer-btn").style.visibility = "hidden";
						}
						function cancel(){
						document.getElementById("popupinput").style.visibility = "hidden";
						}
						function changetogreen(){
						    document.getElementById("thumbsup").style.color = "green";
						}
						function changetoblack(){
						    document.getElementById("thumbsup").style.color = "black";
						    document.getElementById("thumbsdown").style.color = "black";
						}
						function changetored(){
						    document.getElementById("thumbsdown").style.color = "red";
						}
					</script>
					<div id="popupinput" class="new-post pad-bottom" data-bind="visible: signedIn">
					<form method="post" data-bind="submit: writePost">
						<div class="form-group">
							<label for="message">Write answer:</label>
							<input type="hidden" name="in_uid" value="<?=$_SESSION['USER_ID'];?>"/>
							<input type="hidden" name="in_qid" value="<?=$col['FN_QUESTION_ID'];?>"/>
							
							<textarea class="form-control" name="ans" id="ans" placeholder="Type your answer"></textarea>
						</div>
						<input type="submit" name="submit_answer_button" id="answer_btn"  class="btn btn-default" value="Submit"/>
						<button  class="btn btn-default" onclick="cancel()">Cancel</button>
						
					</form>
					
					</div>
						<hr>
						<?php else:?>
							<?php 
								$user_ans  = array(
								'qid' => $col['FN_QUESTION_ID']
							);
							$TD_answers = Database::getRow_v2('answers INNER JOIN users ON answers.FN_USER_ID = users.FN_USER_ID WHERE FN_QUESTION_ID = :qid', $user_ans);
							if($TD_answers):
							foreach($TD_answers as $row): $ansid = $row['FN_ANSWER_ID'];?>
							<p> <h4> &nbsp;&nbsp;&nbsp;<?=$row['FC_USER_FIRSTNAME'] . " " . $row['FC_USER_LASTNAME'];?> | Votes: 0
							<?php if($row['FN_VOTES_UP']==0 && $row['FN_VOTES_UP']==0):?>
							
							| <a href="?action=up&ansid=<?=$ansid;?>"><span onmouseover="changetogreen()" onmouseout="changetoblack()" id="thumbsup" class="glyphicon glyphicon-thumbs-up green"></span></a>
							<a href="?action=down&ansid=<?=$ansid;?>"><span onmouseout="changetoblack()" onmouseover="changetored()" id="thumbsdown" class="glyphicon glyphicon-thumbs-down red"></span></a>
							<?php endif;?>
							
							</h4>&nbsp;&nbsp;&nbsp;<?=$row['FC_ANSWER'];?></p>
						<?php endforeach; endif; endif;?>
						
						 <!--<a href="#"><span onmouseover="changetogreen()" onmouseout="changetoblack()" id="thumbsup" class="glyphicon glyphicon-thumbs-up green"></span></a>
						 <a href="#"><span onmouseout="changetoblack()" onmouseover="changetored()" id="thumbsdown" class="glyphicon glyphicon-thumbs-down red"></span></a>-->
					<?php endforeach; endif;?>
                    
		  
				
                </div>
						</div>
						
					</div>
				</div>
			</div>
			

</body>
</html>