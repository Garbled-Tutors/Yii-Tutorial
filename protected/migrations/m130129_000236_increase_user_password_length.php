<?php

class m130129_000236_increase_user_password_length extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('user','password','varchar(60)');
	}

	public function down()
	{
		$this->alterColumn('user','password','varchar(50)');
	}
}
