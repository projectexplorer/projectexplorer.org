<?php

include('includes/db.php');
include('includes/pre.php');
include('includes/users.php');

	user_logout();
	$user_name='';

	echo '<script type="text/javascript">window.location.href = "/about/profile";</script>';

?>
