require_relative 'spec_helper'

EXAMPLE_USERS = ['joe', 'brian', 'david', 'steven', 'taylor']
EXAMPLE_PASSWORDS = ['qwerty', 'password', 'abc123', 'securepass', 'god', 'letmein', 'nomoresecrets']

def generate_new_user
	username = EXAMPLE_USERS.sample
	password = EXAMPLE_PASSWORDS.sample
	{:username => username, :password => password}
end

describe 'Yii Application', type: :feature do
	before :each do
		reset_database
		visit HOME_PAGE
	end

	after :each do
		reset_database
	end

	describe "Javascript Navigation", js: true do
		it "should allow users to login" do
			page.should have_link 'Login'
			does_link_exist('Logout').should == false
			login_admin
			does_link_exist('Logout').should == true
		end

		it "should have user link when logged in", js: true do
			login_admin
			page.should have_link 'Users'
		end

		it "should be able to add users", js: true do
			login_admin
			click_link 'Users'
			click_link 'Create User'
			user_details = generate_new_user
			fill_in 'User_username', with: user_details[:username]
			select('user', :from => 'User_role')
			fill_in 'User_password', with: user_details[:password]
			fill_in 'User_password_repeat', with: user_details[:password]
			click_button 'Create'
			find_link('Logout').click
			login user_details[:username], user_details[:password]
			does_link_exist('Logout').should == true
		end
	end
end
