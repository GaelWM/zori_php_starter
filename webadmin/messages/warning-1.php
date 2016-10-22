<?php
	echo "
		<!DOCTYPE html>
		<html>
		<head>
		    <title></title>
		    <link rel='stylesheet' href='https://limonte.github.io/sweetalert2/dist/sweetalert2.css'>
		    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'>
		    <script src='https://limonte.github.io/sweetalert2/dist/sweetalert2.min.js'></script>
		    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
		</head>

		<body>
		</body>
			<script>
				$(document).ready(function(){
					$('#login-form-div').fadeOut(1000,function(){});
   					swal({
   						title:'Login failed',
					    text: 'Username or Password is incorrect.',
					    type: 'warning'
   					});
   					setTimeout(function() {
   					   location.href='login.php';
   					}, 3000);
					
				});
			</script>
		</html>
	";
?>
