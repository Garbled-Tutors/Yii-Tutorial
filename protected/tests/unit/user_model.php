<? 
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

function add_user_to_database($details)
{
	$user = build_user_object($details);
	$user->save();
	return $user;
}

class UserModelTest extends CTestCase
{
	protected function setUp()
	{
		User::model()->deleteAll();
	}
	protected function tearDown()
	{
		User::model()->deleteAll();
	}
	public function testPasswordConfirmationUsingReturnCode()
	{
		//This makes sure the User Model will not allow new users to be created unless their passwords match
		$details = generate_random_user_details();
		$details['password_repeat'] = $details['password'] . '123';
		$user = build_user_object($details);
		$result = $user->save();
		$this->assertTrue($result != true);

		$details = generate_random_user_details();
		$user = build_user_object($details);
		$result = $user->save();
		$this->assertTrue($result == true);
	}
	public function testPasswordConfirmationInDatabase()
	{
		//This makes sure the User Model will not allow new users to be created unless their passwords match
		$details = generate_random_user_details();
		$details['password_repeat'] = $details['password'] . '123';
		$user = add_user_to_database($details);
		$found_user = User::model()->findAllByAttributes(array('username'=> $details['username']));
		$this->assertTrue(count($found_user) == 0);
	}
	public function testClearTextPasswordsInMemory()
	{
		//This checks to see if the model is keeping the users password as clear text in memory
		$details = generate_random_user_details();
		$user = add_user_to_database($details);
		$this->assertTrue($user->password != $details['password']);
	}
	public function testClearTextPasswordsInDatabase()
	{
		//This checks to see if the model is keeping the users password as clear text in the database
		$details = generate_random_user_details();
		$user = add_user_to_database($details);
		$found_user = User::model()->findAllByAttributes(array('username'=> $details['username']));
		$this->assertTrue(count($found_user) != 0);
		$this->assertTrue($found_user[0]['password'] != $details['password']);
	}
	public function testIsAuthenticatedDefaultValue()
	{
		$user = new User;
		$this->assertTrue($user['is_authenticated'] == false);

		$details = generate_random_user_details();
		add_user_to_database($details);
		$found_user = User::model()->findAllByAttributes(array('username'=> $details['username']));
		$this->assertTrue(count($found_user) == 1);
		$this->assertTrue($found_user[0]['is_authenticated'] == false);
	}
	public function testPasswordAgainstPasswordHash()
	{
		$details = generate_random_user_details();
		add_user_to_database($details);

		$found_user = User::model()->findAllByAttributes(array('username'=> $details['username']));
		$this->assertTrue(count($found_user) == 1);

		$user = $found_user[0];
		$result = $user->authenticate($details['password'] . '123');
		$this->assertTrue($result == false);
		$this->assertTrue($user['is_authenticated'] == false);

		$result = $user->authenticate($details['password']);
		$this->assertTrue($result == true);
		$this->assertTrue($user['is_authenticated'] == true);
	}
}
?>

