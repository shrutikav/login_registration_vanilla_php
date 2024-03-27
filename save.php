<?php
	include 'config.php';
	session_start();
	if($_POST['type']==1){
		$name=$_POST['name'];
		$email=$_POST['email'];
		$phone=$_POST['phone'];
		//$city=$_POST['city'];
		$password=$_POST['password'];
		$file   = $_FILES['file']['name'];
		//print_r([$file]);
	    $tmp_name = $_FILES['file']['tmp_name'];
	    $filesize = $_FILES['file']['size'];
	    $filetype = $_FILES['file']['type'];
	    
	    $newfilename= date('dmYHis').str_replace(" ", "", basename($_FILES["file"]["name"]));
	    $path = "upload/".$newfilename;
		$duplicate=mysqli_query($conn,"select * from tbl_registration where email='$email'");
		if (mysqli_num_rows($duplicate)>0)
		{
			echo json_encode(array("statusCode"=>201));
		}
		else
		{
			if($tmp_name == '')
		    {
		    	echo json_encode(array("statusCode"=>202,"message"=>"please select a photo"));
		        //echo "please select a photo";
		    }
		    elseif($filesize > 2000000)
		    {
		    	echo json_encode(array("statusCode"=>202,"message"=>"file size is greater than 2 mb"));
		        //echo "file size is greater than 2 mb";
		    }
		    elseif($filetype != "image/jpeg" && $filetype != "image/png" && $filetype != "image/gif" )
		    {
		    	echo json_encode(array("statusCode"=>202,"message"=>"please upload image in format of jpg, png or gif"));
		        //echo "please upload image in format of jpg, png or gif";
		    }
		    else
		    {
		    	move_uploaded_file($tmp_name,$path);
				$sql = "INSERT INTO `tbl_registration`( `name`, `email`, `phone`, `password`,`profile_picture`) 
				VALUES ('$name','$email','$phone','$password','$newfilename')";
				if (mysqli_query($conn, $sql)) {
					echo json_encode(array("statusCode"=>200));
				} 
				else {
					echo json_encode(array("statusCode"=>201));
				}
		    }
			
		}
		mysqli_close($conn);
	}
	if($_POST['type']==2){
		$email=$_POST['email'];
		$password=$_POST['password'];
		$check=mysqli_query($conn,"select * from tbl_registration where email='$email' and password='$password'");
		if(mysqli_num_rows($check)>0)
		{
			$_SESSION['email']=$email;
			echo json_encode(array("statusCode"=>200));
		}
		else{
			echo json_encode(array("statusCode"=>201));
		}
		mysqli_close($conn);
	}
?>