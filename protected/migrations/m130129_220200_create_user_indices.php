<?php

class m130129_220200_create_user_indices extends CDbMigration
{
	public function up()
	{
		$this->createIndex('idxUsername', 'user', 'username', true);
	}

	public function down()
	{
		$this->dropIndex('idxUsername', 'user');
	}
}
