<?php

include('includes/database.php');
include('includes/pre.php');
include('includes/user.php');

if ($_POST[submit]) {
	user_login($_POST[user_name],$_POST[password]);
}

if (user_isloggedin()) {
	//modify to redirect to the page you came from: JS? Params?
	header("Location: $_POST[url]");
	return true;
}

if ($feedback) {
	echo '<p><span class="error">'.$feedback.'</span></p>';
}

if (!$_POST[url]) {
	$return_url = isset($_SERVER{'HTTP_REFERER'}) ? $_SERVER{'HTTP_REFERER'} : "http://projectexplorer.org/about/profile";
}
else
{
	$return_url = $url;
}

echo '
	<P>
	Enter your user name and password to log in.
	<P>

  <form action="'. $PHP_SELF .'" method="POST">
  <fieldset>
	<label for="user_name" class="required">User Name</label>
	<input type="text" id="user_name" name="user_name">
	
	<label for="password" class="required">Password</label>
	<input type="password" id="password" name="password">
	<br><a href="lostpass">Forgot your login/password?</a>
	<P>
	<input type="hidden" id="url" name="url" value="' . $return_url . '">
  <input type="button" name="submit" id="submit" value="Login to ProjectExplorer.org">
  </fieldset>
  </form>';


?>
