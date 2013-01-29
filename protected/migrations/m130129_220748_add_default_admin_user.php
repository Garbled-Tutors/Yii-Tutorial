<?php

class m130129_220748_add_default_admin_user extends CDbMigration
{
	public function up()
	{
		$changeme_hash = <<<EOS
$2a$08$Tt1n.BO/z/Pq8vDLlBzTC.Hcd/Iir20d1m.QoxARJMiaArZWA2es.
EOS
		Yii::app()->db->createCommand("INSERT INTO `user` (`username`, `role`, `password`) VALUES ('admin', 'admin', '$changeme_hash');")->execute();
	}

	public function down()
	{
		Yii::app()->db->createCommand("DELETE FROM `user` WHERE (`username` = 'admin');")->execute();
	}
}
