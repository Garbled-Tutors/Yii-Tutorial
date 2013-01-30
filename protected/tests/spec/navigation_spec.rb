require_relative 'spec_helper'

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
end
