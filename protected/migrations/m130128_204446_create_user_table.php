<?php

class m130128_204446_create_user_table extends CDbMigration
{
	public function up()
	{
    $this->createTable('user',
      array('id' => 'pk',
			'username' => 'varchar(100)',
			'role' => 'varchar(10)',
			'password' => 'varchar(50)'));
	}

	public function down()
	{
    $this->dropTable('user');
	}
}
