require_relative 'spec_helper'

def login_admin
	login ADMIN_USER_NAME, ADMIN_PASSWORD
end

def login(user_name, password)
	click_link 'Login'
	fill_in 'LoginForm_username', with: user_name
	fill_in 'LoginForm_password', with: password
	click_button 'Login'
end

def does_link_exist(link_text)
	begin
		find_link link_text
	rescue
		return false
	end
	return true
end

describe 'Yii Application', type: :feature do
	before :each do
		visit HOME_PAGE
	end

	describe "Navigation" do
		it "should contain navigation links" do
			page.should have_link 'Home'
			page.should have_link 'About'
			page.should have_link 'Contact'
			page.should have_link 'Login'
		end
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
	end
end
