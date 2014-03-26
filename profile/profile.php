<?php

include('includes/database.php');
include('includes/pre.php');
include('includes/user.php');

if (user_isloggedin()) {
        $firstname = user_getfirstname();
        $lastname = user_getlastname();
        $email = user_getemail();
}


if ($firstname)
{
	echo '<h3>Welcome Back, '. $firstname .'</h3>';
	echo '<p>Here, you can: </p>
	<ul>
	<li><A HREF="logout">Logout of ProjectExplorer.org</A>
	<li><A HREF="register">Register A New Profile</A>
	<li><A HREF="changeemail">Change Your Email Address</A>
	<li><A HREF="changepass">Change Your Password</A>
	</ul>
	<p>&nbsp;</p>
	
	<p>ProjectExplorer.org will not willfully disclose your personal information 
	to any third party without first receiving your permission. 
	All newsletters and other emails come directly from ProjectExplorer.org, and not from any third party. See ProjectExplorer.org\'s 
			<a href="/about/privacy">Privacy Policy</a> for more information.</p>
	';
	
}
else
{

	echo '<h3>Welcome to ProjectExplorer.org</h3>';
	echo '		
		<p>To continue managing your ProjectExplorer.org account, please
		<a href="login">login to ProjectExplorer.org</a> or <a href="register">register as a new user</a>.
		</p>
		<p>As a registered user, you have the option of receiving updates and news about our ongoing expeditions, and
		also have access to discounts and offers provided by our sponsors and partners.</p>
		<p>We look forward to welcoming you on our travels, and thank you for your interest.</p>';
	
	echo '
		<p>ProjectExplorer.org will not willfully disclose your personal information 
			to any third party without first receiving your permission. See ProjectExplorer.org\'s 
			<a href="/about/privacy">Privacy Policy</a> for more information.</p>
			';
} //end if worked



?>
