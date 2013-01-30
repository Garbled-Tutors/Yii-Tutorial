<?php

class m130129_220748_add_default_admin_user extends CDbMigration
{
	public function up()
	{
		$changeme_hash = '$2a$08$Tt1n.BO/z/Pq8vDLlBzTC.Hcd/Iir20d1m.QoxARJMiaArZWA2es.';
		$this->insert('user', array('username'=>'admin', 'role'=>'admin', 'password'=>$changeme_hash));
	}

	public function down()
	{
		$this->delete('user', 'username="admin"');
	}
}
