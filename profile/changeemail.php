<?php

include('includes/database.php');
include('includes/pre.php');
include('includes/user.php');

if ($_POST[submit]) {
	user_change_email ($_POST[password1],$_POST[new_email],$_POST[change_user_name]);
}


if ($feedback) {
	echo '<p><span class="error">'.$feedback.'</span></p>';
}

echo '
	<p>Please provide us your new email address, and a confirmation email will be sent to you.</p>
	<p>ProjectExplorer.org will not willfully disclose your personal information to any third party without first receiving your permission. See ProjectExplorer.org\'s <a href="/about/privacy">Privacy Policy</a> for more information.</p>

  <form action="'. $PHP_SELF .'" method="POST" id="register" name="register">
	<fieldset>
  <label for="change_user_name" class="required">User Name</label>
	<input type="text" id="change_user_name" name="change_user_name" value="'. $_POST[change_user_name] .'">
	<label for="password1" class="required">Password</label>
	<input type="password" id="password1" name="password1" value="">
	<label for="new_email" class="required">New Email</label>
	<input type="email" id="new_email" name="new_email">
	<input type="button" name="submit" id="submit" value="Send My Confirmation">
  </fieldset>
	</form>';

?>
