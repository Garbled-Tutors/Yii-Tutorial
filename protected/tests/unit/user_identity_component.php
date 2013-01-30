<? 
class UserIdentityComponentTest extends CTestCase
{
	protected function setUp()
	{
		User::model()->deleteAll();
	}

	protected function tearDown()
	{
		User::model()->deleteAll();
	}

	public function testSuccessfulLogin()
	{
		$details = generate_random_user_details();
		add_user_to_database($details);

		$user_identity = new UserIdentity($details['username'],$details['password']);
		$this->assertTrue($user_identity->authenticate());
	}
}
?>

