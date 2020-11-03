<?php
	$msg = "";
if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['cPassword']) ){ 
	if (isset($_POST['submit'])) {
		$con = new mysqli('localhost', 'root', '', 'testing2');

		$name = $con->real_escape_string($_POST['name']);
		$email = $con->real_escape_string($_POST['email']);
		$password = $con->real_escape_string($_POST['password']);
        $cPassword = $con->real_escape_string($_POST['cPassword']);
        
        $query = mysqli_query($con,"SELECT user_id FROM user_details WHERE user_name = '$name'"); 
        if(mysqli_num_rows($query) == 1) 
        {
             // Pseudo déjà utilisé 
             echo 'Ce pseudo est déjà utilisé'; }


		if ($password != $cPassword)
			$msg = "Please Check Your Passwords!";
		else {
			$hash = password_hash($password, PASSWORD_BCRYPT);
			$con->query("INSERT INTO user_details (user_name,user_email,user_password, user_type, user_status) VALUES ('$name', '$email', '$hash', 'user', 'Active')");
			$msg = "You have been registered!";
		}
    }
}else{
    echo 'c vide';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Password Hashing - Register</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
	<div class="container" style="margin-top: 100px;">
		<div class="row justify-content-center">
			<div class="col-md-6 col-md-offset-3" align="center">
				<img src="images/logo.png"><br><br>

				<?php if ($msg != "") echo $msg . "<br><br>"; ?>

				<form method="post" action="#">
					<input class="form-control" minlength="3" name="name" placeholder="Name..."><br>
					<input class="form-control" name="email" type="email" placeholder="Email..."><br>
					<input class="form-control" minlength="5" name="password" type="password" placeholder="Password..."><br>
					<input class="form-control" minlength="5" name="cPassword" type="password" placeholder="Confirm Password..."><br>
					<input class="btn btn-primary" name="submit" type="submit" value="Register..."><br>
				</form>

			</div>
		</div>
	</div>
</body>
</html>