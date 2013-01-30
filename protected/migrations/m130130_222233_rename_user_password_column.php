<?php

class m130130_222233_rename_user_password_column extends CDbMigration
{
	public function up()
	{
		$this->renameColumn('user','password','password_hash');
	}

	public function down()
	{
		$this->renameColumn('user','password_hash','password');
	}
}
