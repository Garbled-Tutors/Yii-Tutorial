<? 
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
		add_user_to_database($details);
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
		add_user_to_database($details);
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

		$result = try_user_login($details['username'], $details['password'] . '123');
		$this->assertTrue($result == false);

		$result = try_user_login($details['username'], $details['password']);
		$this->assertTrue($result == true);
	}

	public function testUserPasswordCannotBeBlank()
	{
		$details = generate_random_user_details();
		$details['password'] = '';
		$details['password_repeat'] = '';
		$this->assertFalse(add_user_to_database($details,false));
	}
	public function testUpdateUserWithoutChangingPassword()
	{
		//create a new user
		$details = generate_random_user_details();
		add_user_to_database($details);

		//find user and update role
		$found_user = User::model()->findAllByAttributes(array('username'=> $details['username']));
		$user = $found_user[0];
		$user->role = 'user';
		$user->save();

		//Lookup user again
		$this->assertTrue(try_user_login($details['username'], $details['password']));
	}
}
?>
