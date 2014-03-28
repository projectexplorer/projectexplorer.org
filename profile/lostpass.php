<?php

include('includes/db.php');
include('includes/pre.php');
include('includes/users.php');

if (user_isloggedin()) {
	user_logout();
	$user_name='';
}

if ($_POST[submit]) {
	user_lost_password($_POST[email]);
}

  if ($_SESSION['pe_feedback']) {
    echo '<p class="error">'.$_SESSION['pe_feedback'].'</p>';
    unset($_SESSION['pe_feedback']);
  }

echo '
	<p>Please provide the email address you used to sign up at ProjectExplorer.org, and we will send you an email containing your login information.</p>
	<form action="/about/lostpass" method="POST" id="lostpass" name="lostpass">
  <fieldset>
	<label for="email" class="required">Email Address</label>
	<input type="email" NAME="email">

  <input type="submit" name="submit" id="submit" value="Reset My Password">
	</form>';

?>
