<?php

//include('includes/pe_config.php');

$LOGGED_IN=false;
//clear it out in case someone sets it in the URL or something
unset($LOGGED_IN);

/*

create table user (
user_id int not null auto_increment primary key,
user_name text,
real_name text,
email text,
password text,
remote_addr text,
confirm_hash text,
is_confirmed int not null default 0
);

*/

function user_isloggedin() {
	//global $user_name,$id_hash,$LOGGED_IN;
	//have we already run the hash checks? 
	//If so, return the pre-set var

	if (isset($LOGGED_IN) && $LOGGED_IN) {
		return $LOGGED_IN;
	}
	if ($_COOKIE[user_name] && $_COOKIE[id_hash]) {
		$hash=md5($_COOKIE[user_name].$GLOBALS['hidden_hash_var']);
		if ($hash == $_COOKIE[id_hash]) {
			$LOGGED_IN=true;
			return true;
		} else {
			$LOGGED_IN=false;
			return false;
		}
	} else {
		$LOGGED_IN=false;
		return false;
	}
}

function user_login($user_name,$password,$dbname) {
	//feedbackwashere;
	global $LOGGED_IN;


	if (!$user_name || !$password) {
		$_SESSION['pe_feedback'] .= ' ERROR - Missing user name or password ';
		return false;
	} else {
		$user_name=strtolower($user_name);
		
		$sql="SELECT * FROM site_user WHERE username='$user_name'";

		$result=db_query($sql, $dbname);
		if (!$result || db_numrows($result) < 1){
			$_SESSION['pe_feedback'] .= ' ERROR - User not found ';
			return false;
		} else {
			if (db_result($result,0,'password') != md5($password)) {
				$_SESSION['pe_feedback'] .= ' ERROR - Incorrect password ';
				return false;
			} else { 
			if (db_result($result,0,'is_confirmed') == '1') {
				user_set_tokens($user_name);
				$_SESSION['pe_feedback'] .= ' SUCCESS - You Are Now Logged In ';
				$LOGGED_IN = true;
				return true;
			} else {
				$_SESSION['pe_feedback'] .=  ' ERROR - You haven\'t Confirmed Your Account Yet ';
				return false;
			}
		}
	}}
}

function user_logout() {
	setcookie('user_name','',(time()+2592000),'/','',0);
	setcookie('id_hash','',(time()+2592000),'/','',0);
}

function user_set_tokens($user_name_in) {
	global $user_name,$id_hash;
	if (!$user_name_in) {
		$_SESSION['pe_feedback'] =  ' ERROR - User Name Missing When Setting Tokens ';
		return false;
	}
	$user_name=strtolower($user_name_in);
	$id_hash= md5($user_name.$GLOBALS['hidden_hash_var']);
	setcookie('user_name',$user_name,(time()+2592000),'/','',0);
	setcookie('id_hash',$id_hash,(time()+2592000),'/','',0);
}

function user_confirm($hash,$email) {
	/*
		Call this function on the user confirmation page,
		which they arrive at when the click the link in the
		account confirmation email
	*/

	//feedbackwashere;

	//verify that they didn't tamper with the email address
	$new_hash=md5($email.$GLOBALS['hidden_hash_var']);
	if ($new_hash && ($new_hash==$hash)) {
		//find this record in the db
		$sql="SELECT * FROM site_user WHERE confirm_hash='$hash'";
		$result=db_query($sql);
		if (!$result || db_numrows($result) < 1) {
			$_SESSION['pe_feedback'] = ' ERROR - User Not Found ';
			return false;
		} else {
			//confirm the email and set account to active
			user_set_tokens(db_result($result,0,'username'));
			$sql="UPDATE site_user SET email='$email',is_confirmed='1' WHERE confirm_hash='$hash'";
			$result=db_query($sql);
			return true;
		}
	} else {
		$_SESSION['pe_feedback'] = ' HASH INVALID - UPDATE FAILED ';
		return false;
	}
}

function user_change_password ($new_password1,$new_password2,$change_user_name,$old_password) {
	//feedbackwashere;
	//new passwords present and match?
	if ($new_password1 && ($new_password1==$new_password2)) {
		//is this password long enough?
		if (account_pwvalid($new_password1)) {
			//all vars are present?
			if ($change_user_name && $old_password) {
				//lower case user name
				$change_user_name=strtolower($change_user_name);
				
				$sql="SELECT * FROM site_user WHERE username='$change_user_name' AND password='". md5($old_password) ."'";
				$result=db_query($sql);
				if (!$result || db_numrows($result) < 1) {
					$_SESSION['pe_feedback'] = ' User not found or bad password '.db_error();
					return false;
				} else {
					$sql="UPDATE site_user SET password='". md5($new_password1). "' ".
						"WHERE username='$change_user_name' AND password='". md5($old_password). "'";
					$result=db_query($sql);
					if (!$result || db_affected_rows($result) < 1) {
						$_SESSION['pe_feedback'] = ' NOTHING Changed '.db_error();
						return false;
					} else {
						$_SESSION['pe_feedback'] = ' Password Changed ';
						return true;
					}
				}
			} else {
				$_SESSION['pe_feedback'] = ' Must Provide User Name And Old Password ';
				return false;
			}
		} else {
			$_SESSION['pe_feedback'] = ' New Password Does Not Meet Criteria ';
			return false;
		}
	} else {
		return false;
		$_SESSION['pe_feedback'] = ' New Passwords Must Match ';
	}
}

function user_lost_password ($email) {
	//feedbackwashere;
	if ($email) {
		$sql="SELECT * FROM site_user WHERE email='$email'";
		$result=db_query($sql);
		if (!$result || db_numrows($result) < 1) {
			//no matching user found
			$_SESSION['pe_feedback'] = ' We did not find a user with that email address. Please try again or <a href="/about/register">register as a new user</a>. ';
			return false;
		} else {
			//create a secure, new password
			$new_pass=strtolower(substr(md5(time().$user_name.$GLOBALS['hidden_hash_var']),1,14));
			$user_name = db_result($result,0,'username');
			//update the database to include the new password
			$sql="UPDATE site_user SET password='". md5($new_pass) ."' WHERE username='$user_name'";
			$result=db_query($sql);
			//send a simple email with the new password
			mail ($email,'Password Reset Notification from ProjectExplorer.org','The password for '. $user_name .' at ProjectExplorer.org '.
				'has been reset to: '. $new_pass . "\n \n Please use this new password the next time you visit http://projectexplorer.org, and be sure to reset your password at your earliest convenience at http://projectexplorer.org/about/changepass .",'From: register@projectexplorer.org');
			$_SESSION['pe_feedback'] = ' Your new password has been emailed to you. ';
			return true;
		}
	} else {
		$_SESSION['pe_feedback'] = ' A valid email address is required to retrieve your password. ';
		return false;
	}
}

function user_change_email ($password1,$new_email,$user_name) {
	//feedbackwashere;
	if (validate_email($new_email)) {
		$hash=md5($new_email.$GLOBALS['hidden_hash_var']);
		//change the confirm hash in the db but not the email - 
		//send out a new confirm email with a new hash
		$user_name=strtolower($user_name);

		$sql="UPDATE site_user SET confirm_hash='$hash' WHERE username='$user_name' AND password='". md5($password1) ."'";
		$result=db_query($sql);
		if (!$result || db_affected_rows($result) < 1) {
			$_SESSION['pe_feedback'] = ' ERROR - Incorrect User Name Or Password ';
			return false;
		} else {
			$_SESSION['pe_feedback'] = ' Confirmation Sent ';
			user_send_confirm_email($new_email,$hash);
			return true;
		}
	} else {
		$_SESSION['pe_feedback'] = ' New Email Address Appears Invalid ';
		return false;
	}
}

function user_send_confirm_email($email,$hash) {
	/*
		Used in the initial registration function
		as well as the change email address function
	*/

	$message = "Thank You For Registering with ProjectExplorer.".
		"\nSimply follow this link to confirm your registration: ".
		"\n\nhttp://www.projectexplorer.org/about/confirm?hash=$hash&email=". urlencode($email).
		"\n\nIf you have not registered, you can ignore this email, and no additional messages will be sent. If you have any questions, you can reply to this email and our staff will assist as soon as they can.";
	mail ($email,'ProjectExplorer Registration Confirmation',$message,'From: register@projectexplorer.org');
}


function sql_safe($s)
{
    if (get_magic_quotes_gpc())
        $s = stripslashes($s);

    return mysql_real_escape_string($s);
}


function user_register($user_name,$password1,$password2,$first,$last,$job,$level,$classsize,$orgname,$address,$address2,$city,$state,$zip,$country,$email,$se_topics,$future_loc,$comments,$optout) {
	//feedbackwashere;
	//all vars present?
	if ($user_name && $password1 && $first && $last && $address && $city && $zip && $email && validate_email($email)) {
	  //and passwords match?
	  if($password1==$password2){
		//password and name are valid?
		if (account_namevalid($user_name) && account_pwvalid($password1)) {
			$user_name=strtolower($user_name);

		//	does the email exist in the database?
			$sql="SELECT * FROM site_user WHERE email='$email'";
			$result=db_query($sql);
			if ($result && db_numrows($result) > 0) {
				$_SESSION['pe_feedback'] =  ' ERROR - Someone has already registered with that email address. ';
				return false;
			} else {
				//create a new hash to insert into the db and the confirmation email
				if(get_magic_quotes_gpc()==0) {
					$first = mysql_real_escape_string($first);
					$last = mysql_real_escape_string($last);
					$orgname = mysql_real_escape_string($orgname);
					$address = mysql_real_escape_string($address);
					$address2 = mysql_real_escape_string($address2);
					$city = mysql_real_escape_string($city);
					$country = mysql_real_escape_string($country);
					$se_topics = mysql_real_escape_string($se_topics);
					$future_loc = mysql_real_escape_string($future_loc);
					$comments = mysql_real_escape_string($comments);
				}
				
				$hash=md5($email.$GLOBALS['hidden_hash_var']);
				if(count($job)>0){
					$jobstr=implode(",", $job);
				}else{
					$jobstr="";
				}
				
				if(count($level)>0){
					$levelstr=implode(",", $level);
				}else{
					$levelstr="";
				}
				
				if(!is_numeric($classsize)){
					$classsize="0";
				}
				
				$password=md5($password1);
				
				
				$sql="INSERT INTO site_user (username,password,first,last,job,level,classsize,orgname,address,address2,city,state,zip,country,email,se_topics,future_loc,comments,email_optout,remote_addr,confirm_hash,is_confirmed) ".
					"VALUES ('$user_name','$password','$first','$last','$jobstr','$levelstr',$classsize,'$orgname','$address','$address2','$city','$state','$zip','$country','$email','$se_topics','$future_loc','$comments','$optout','$GLOBALS[REMOTE_ADDR]','$hash','0')";
				$result=db_query($sql);
				if (!$result) {
					$_SESSION['pe_feedback'] = ' ERROR - '.db_error();
					return false;
				} else {
					//send the confirm email
					user_send_confirm_email($email,$hash);
					$_SESSION['pe_feedback'] = 'You have successfully registered. Check your email for a message from us, and confirm your registration.<br />Be sure and check your Spam Folder, and add us to your address book so you don\'t miss any news!';
					return true;
				}
			} // end else: safe email
		} else {
			$_SESSION['pe_feedback'] =  ' Account Name or Password Invalid ';
			return false;
		}
	  } else {
		  $_SESSION['pe_feedback'] =  ' ERROR - Please retype your password, making sure both passwords match.';
		  return false;
	  }
	} else {
		$_SESSION['pe_feedback'] = ' ERROR - User must complete all required fields, marked with a "*".';   
		return false;
	}
}


function user_getid() {
	
	//see if we have already fetched this user from the db, if not, fetch it
	if (!$_SESSION['PE_USER_RESULT']) {
		$_SESSION['PE_USER_RESULT']=db_query("SELECT * FROM site_user WHERE username='" . user_getname() . "'");
	}
	if ($_SESSION['PE_USER_RESULT'] && db_numrows($_SESSION['PE_USER_RESULT']) > 0) {
		return db_result($_SESSION['PE_USER_RESULT'],0,'user_id');
	} else {
		return false;
	}
}

function user_getfirstname() {
	
	//see if we have already fetched this user from the db, if not, fetch it
	if (!$_SESSION['PE_USER_RESULT']) {
		$_SESSION['PE_USER_RESULT']=db_query("SELECT * FROM site_user WHERE username='" . user_getname() . "'");
	}
	if ($_SESSION['PE_USER_RESULT'] && db_numrows($_SESSION['PE_USER_RESULT']) > 0) {
		return stripslashes(db_result($_SESSION['PE_USER_RESULT'],0,'first'));
	} else {
		return false;
	}
}

function user_getlastname() {
	
	//see if we have already fetched this user from the db, if not, fetch it
	if (!$_SESSION['PE_USER_RESULT']) {
		$_SESSION['PE_USER_RESULT']=db_query("SELECT * FROM site_user WHERE username='" . user_getname() . "'");
	}
	if ($_SESSION['PE_USER_RESULT'] && db_numrows($_SESSION['PE_USER_RESULT']) > 0) {
		return stripslashes(db_result($_SESSION['PE_USER_RESULT'],0,'last'));
	} else {
		return false;
	}
}

function user_getemail() {
	
	//see if we have already fetched this user from the db, if not, fetch it
	if (!$_SESSION['PE_USER_RESULT']) {
		$_SESSION['PE_USER_RESULT']=db_query("SELECT * FROM site_user WHERE username='" . user_getname() . "'");
	}
	if ($_SESSION['PE_USER_RESULT'] && db_numrows($_SESSION['PE_USER_RESULT']) > 0) {
		return db_result($_SESSION['PE_USER_RESULT'],0,'email');
	} else {
		return false;
	}
}

function user_getname() {
	if (user_isloggedin()) {
		return $_COOKIE['user_name'];
	} else {
		//look up the user some day when we need it
		return ' ERROR - Not Logged In ';
	}
}

function account_pwvalid($pw) {
	//feedbackwashere;
	if (strlen($pw) < 6) {
		$_SESSION['pe_feedback'] = " Password must be at least 6 characters. ";
		return false;
	}
	return true;
}

function account_namevalid($name) {
	//feedbackwashere;
	// no spaces
	if (strrpos($name,' ') > 0) {
		$_SESSION['pe_feedback'] = " There cannot be any spaces in the login name. ";
		return false;
	}

	// must have at least one character
	if (strspn($name,"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ") == 0) {
		$_SESSION['pe_feedback'] = "There must be at least one character.";
		return false;
	}

	// must contain all legal characters
	if (strspn($name,"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_")
		!= strlen($name)) {
		$_SESSION['pe_feedback'] = " Illegal character in name. ";
		return false;
	}

	// min and max length
	if (strlen($name) < 5) {
		$_SESSION['pe_feedback'] = " Name is too short. It must be at least 5 characters. ";
		return false;
	}
	if (strlen($name) > 15) {
		$_SESSION['pe_feedback'] = "Name is too long. It must be less than 15 characters.";
		return false;
	}

	// illegal names
	if (preg_match("/^((root)|(bin)|(daemon)|(adm)|(lp)|(sync)|(shutdown)|(halt)|(mail)|(news)"
		. "|(uucp)|(operator)|(games)|(mysql)|(httpd)|(nobody)|(dummy)"
		. "|(www)|(cvs)|(shell)|(ftp)|(irc)|(debian)|(ns)|(download))$/i",$name)) {
		$_SESSION['pe_feedback'] = "Name is reserved.";
		return 0;
	}
	if (preg_match("/^(anoncvs_)/i",$name)) {
		$_SESSION['pe_feedback'] = "Name is reserved.";
		return false;
	}

	return true;
}

function validate_email ($address) {
	return (preg_match('/^[-!#$%&\'*+\\.\/0-9=?A-Z^_`a-z{|}~]+'. '@'. '[-!#$%&\'*+\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\.\/0-9=?A-Z^_`a-z{|}~]+$/', $address));
}

?>
