<?php

include('includes/database.php');
include('includes/pre.php');
include('includes/user.php');

if (user_isloggedin()) {
	user_logout();
	$user_name='';
}

if ($_POST[submit]) {
	user_change_password ($_POST[new_password1],$_POST[new_password2],$_POST[change_user_name],$_POST[old_password]);
}


if ($feedback) {
	echo '<p><span class="error">'.$feedback.'</span></p>';
}

echo '
	<form action="'. $PHP_SELF .'" method="POST" id="register" name="register">
  <fieldset>
	<label for="change_user_name" class="required">User Name</label>
	<input type="text" name="change_user_name" value="'.$_POST[user_name].'">
	<label for="old_password" class="required">OLD Password</label>
	<input type="password" id="old_password" name="old_password">
	<label for="new_password1" class="required">NEW Password</label>
	<input type="password" name="new_password1">
	<label for="new_password2" class="required">NEW Password (again)</label>
	<input type="password" name="new_password2">
  <input type="button" name="submit" id="submit" value="Change My Password">
  </fieldset>
  </form>';

?>
