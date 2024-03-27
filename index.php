<?php
    include("header.php");
?>
<div style="margin: auto;width: 60%;border-style: solid;">
	<h2>Login Registration</h2>
	<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
	</div>
	<div class="alert alert-danger alert-dismissible" id="error" style="display:none;">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
	</div>
	<button type="button" class="btn btn-success btn-sm" id="register">Register</button> <button type="button" class="btn btn-success btn-sm" id="login">Login</button>
	
	<form id="register_form" name="form1" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="email">Name:</label>
			<input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
		</div>
		<div class="form-group">
			<label for="pwd">Email:</label>
			<input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
		</div>
		<div class="form-group">
			<label for="pwd">Phone:</label>
			<input type="text" class="form-control" id="phone" placeholder="Phone" name="phone" required>
		</div>
		<div class="form-group">
			<label for="pwd">Password:</label>
			<input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
		</div>
		<div class="form-group">
			<label for="pwd">Confirm Password:</label>
			<input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password" required>
		</div>
		<div class="form-group">
			<label for="pwd">Photo:</label>
			<input type="file" id="myFile" name="file" required="true">
		</div>
		
		<input type="button" name="save" class="btn btn-primary" value="Register" id="butsave">
	</form>
	<form id="login_form" name="form1" method="post" style="display:none;">
		
		<div class="form-group">
			<label for="pwd">Email:</label>
			<input type="email" class="form-control" id="email_log" placeholder="Email" name="email" required>
		</div>
		<div class="form-group">
			<label for="pwd">Password:</label>
			<input type="password" class="form-control" id="password_log" placeholder="Password" name="password" required>
		</div>
		<input type="button" name="save" class="btn btn-primary" value="Login" id="butlogin">
	</form>
</div>

<script>
$(document).ready(function() {
	$('#login').on('click', function() {
		$("#login_form").show();
		$("#register_form").hide();
	});
	$('#register').on('click', function() {
		$("#register_form").show();
		$("#login_form").hide();
	});
	$('#butsave').on('click', function() {
		//$("#butsave").attr("disabled", "disabled");
		$("#success").html("");
		$("#error").html("");
		var name = $('#name').val();
		var email = $('#email').val();
		var phone = $('#phone').val();
		var password = $('#password').val();
		var formData = new FormData($("#register_form")[0]);
		var confirm_password = $("#confirm_password").val();
		formData.append("type",1);
		if(password != confirm_password)
	    {
	        alert("Password and Confirm Password are mismatched...");
	        return false;
	    }
		if(name!="" && email!="" && phone!="" && password!=""){
			$.ajax({
				url: "save.php",
				type: "POST",
				data : formData,
				 cache: false,
				 contentType: false,
				 processData: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					$('#register_form')[0].reset();
					if(dataResult.statusCode==200){
						//$("#butsave").removeAttr("disabled");
						$("#success").show();
						$('#success').html('Registration successful !'); 						
					}
					else if(dataResult.statusCode==201){
						$("#error").show();
						$('#error').html('Email ID already exists !');
					}
					else if(dataResult.statusCode==202){
						$("#error").show();
						$('#error').html(dataResult.message);
					}
					
				}
			});
		}
		else{
			alert('Please fill all the field !');
		}
	});
	$('#butlogin').on('click', function() {
		var email = $('#email_log').val();
		var password = $('#password_log').val();
		if(email!="" && password!="" ){
			$.ajax({
				url: "save.php",
				type: "POST",
				data: {
					type:2,
					email: email,
					password: password						
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){
						location.href = "welcome.php";						
					}
					else if(dataResult.statusCode==201){
						$("#error").show();
						$('#error').html('Invalid EmailId or Password !');
					}
					
				}
			});
		}
		else{
			alert('Please fill all the field !');
		}
	});
	
});
</script>   
<?php
    include("footer.php");
?>   