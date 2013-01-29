<?php

class m130129_220200_create_user_indices extends CDbMigration
{
	public function up()
	{
		Yii::app()->db->createCommand()->createIndex('idxUsername', 'user', 'username', true);
	}

	public function down()
	{
		Yii::app()->db->createCommand()->dropIndex('idxUsername', 'user');
	}
}
