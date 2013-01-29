<?php

class m130129_220748_add_default_admin_user extends CDbMigration
{
	public function up()
	{
		Yii::app()->db->createCommand("INSERT INTO `user` (`username`, `role`, `password`) VALUES ('admin', 'admin', 'changeme');")->execute();
		//$this->execute("INSERT INTO `user` (`username`, `role`, `password`) VALUES ('admin', 'admin', 'changeme');");
	}

	public function down()
	{
		Yii::app()->db->createCommand("DELETE FROM `user` WHERE (`username` = 'admin');")->execute();
	}
}
