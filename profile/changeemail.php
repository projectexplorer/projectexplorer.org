<?php

include('includes/db.php');
include('includes/pre.php');
include('includes/users.php');

if ($_POST[submit]) {
	user_change_email($_POST[password1],$_POST[new_email],$_POST[change_user_name]);
}


  if ($_SESSION['pe_feedback']) {
    echo '<p class="error">'.$_SESSION['pe_feedback'].'</p>';
    unset($_SESSION['pe_feedback']);
  }

echo '
	<p>Please provide us your new email address, and a confirmation email will be sent to you.</p>
	<p>ProjectExplorer.org will not willfully disclose your personal information to any third party without first receiving your permission. See ProjectExplorer.org\'s <a href="/about/privacy">Privacy Policy</a> for more information.</p>

  <form action="/about/changeemail" method="POST" id="changeemail" name="changeemail">
	<fieldset>
  <label for="change_user_name" class="required">User Name</label>
	<input type="text" id="change_user_name" name="change_user_name" value="'. $_POST[change_user_name] .'">
	<label for="password1" class="required">Password</label>
	<input type="password" id="password1" name="password1" value="">
	<label for="new_email" class="required">New Email</label>
	<input type="email" id="new_email" name="new_email">
	<input type="submit" name="submit" id="submit" value="Send My Confirmation">
  </fieldset>
	</form>';

?>
