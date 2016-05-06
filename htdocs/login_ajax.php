<?php 

// Need two pieces of information:
require('includes/config.inc.php');
require MYSQL;


if (isset($_GET['email'], $_GET['password'])) {

	$e=$_GET['email'];
	$p=$_GET['password'];
	// Need a valid email address:
	if (filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
		
		//Test username and password against the database
		$query="SELECT user_id,user_name FROM users WHERE email='$e' AND password='$p'";
		
		$r=@mysqli_query($dbc,$query);
		// Must match specific values:
		if  (mysqli_num_rows($r)>0)
		//if ( ($_GET['email'] == 'email@example.com') && ($_GET['password'] == 'testpass') ) 
		 {
	
			// Set a cookie, if you want, or start a session.
			
			// Indicate success:
			$user=mysqli_fetch_row($r);
			setcookie('user_id',$user[0]);
            setcookie('user_name',$user[1]);
			echo 'CORRECT';
			
		} else { // Mismatch!
			echo 'INCORRECT';
		}
		
	} else { // Invalid email address!
		echo 'INVALID_EMAIL';
	}

} else { // Missing one of the two variables!
	echo 'INCOMPLETE';
}

?>