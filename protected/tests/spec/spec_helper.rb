require 'capybara/rspec'
require 'capybara/webkit'
require 'mysql'
Capybara.default_driver = :webkit
HOME_PAGE = 'http://localhost/Yii-Tutorial/index-test.php'
TESTING_ROOT_DIR = '/var/www/Yii-Tutorial/protected/tests/'
ADMIN_USER_NAME = 'admin'
ADMIN_PASSWORD = 'changeme'

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

def reset_database
	con = Mysql.new 'localhost', 'root', 'sqlpass', 'testtutorial'
	con.query('DELETE FROM user WHERE 1;')
	changeme_hash = '$2a$08$Tt1n.BO/z/Pq8vDLlBzTC.Hcd/Iir20d1m.QoxARJMiaArZWA2es.'
	con.query "INSERT INTO `user` (`username`, `role`, `password_hash`) VALUES ('admin', 'admin', '#{changeme_hash}');"
end
