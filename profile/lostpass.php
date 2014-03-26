<?php

include('includes/database.php');
include('includes/pre.php');
include('includes/user.php');

if (user_isloggedin()) {
	user_logout();
	$user_name='';
}

if ($_POST[submit]) {
	user_lost_password($_POST[email]);
}

if ($feedback) {
	echo '<p<span class="error">'.$feedback.'</span></p>';
}

echo '
	<p>Please provide the email address you used to sign up at ProjectExplorer.org, and we will send you an email containing your login information.</p>
	<form action="'. $PHP_SELF .'" method="POST" id="lostpass" name="lostpass">
  <fieldset>
	<label for="email" class="required">Email Address</label>
	<input type="email" NAME="email">

  <input type="button" name="submit" id="submit" value="Reset My Password">
	</form>';

?>
