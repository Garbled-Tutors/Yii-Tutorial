<?php

// change the following paths if necessary
$yiit=dirname(__FILE__).'/../../../yii/framework/yiit.php';
$config=dirname(__FILE__).'/../config/test.php';

require_once($yiit);
require_once(dirname(__FILE__).'/WebTestCase.php');

Yii::createWebApplication($config);

define('SAMPLE_USER_NAMES', serialize( array ('bob', 'joe', 'david', 'al', 'ronald') ) );
define('SAMPLE_ROLES', serialize( array ('user', 'admin') ) );
define('SAMPLE_PASSWORDS', serialize( array ('securepassword', 'password', 'pass', 'qwerty', 'i3=%~CT!', '*{S&LH2c','UFWmL3p','hCEjBVaqX','QJW58zts','4Vu5mm','XvNB85NDaB') ) );

function get_random_element($const_array)
{
	$value_list = unserialize($const_array);
	$index = rand(1, count($value_list)) - 1;
	return $value_list[$index];
}

function generate_random_user_details()
{
	$password = get_random_element(SAMPLE_PASSWORDS);
	$details = array(
		'username' => get_random_element(SAMPLE_USER_NAMES),
		'role' => get_random_element(SAMPLE_ROLES),
		'password' => $password,
	 	'password_repeat' => $password);
	return $details;
}

function build_user_object($details)
{
	$user = new User;
	if ($details['username'] 				!= null) 	{$user->username = 				$details['username'];}
	if ($details['role'] 						!= null) 	{$user->role = 						$details['role'];}
	if ($details['password']				!= null) 	{$user->password = 				$details['password'];}
	if ($details['password_repeat'] != null) 	{$user->password_repeat = $details['password_repeat'];}
	return $user;
}

function add_user_to_database($details, $return_user = true)
{
	//Some tests want a simple yes or no return value. If we return a user to these tests, then they print out too much information when failing.
	//return_user is used for that purpose
	$user = build_user_object($details);
	$user->save();
	if ($return_user == true)
	{
		return $user;
	}
	return $user == true;
}

function try_user_login($username, $password)
{
	$found_user = User::model()->findAllByAttributes(array('username'=> $username));
	if (count($found_user) != 1)
	{
		return false;
	}
	$user = $found_user[0];
	$result = $user->authenticate($password);
	if ($result == false)
	{
		return false;
	}
	if ($user['is_authenticated'] == false)
	{
		return false;
	}
	return true;
}
