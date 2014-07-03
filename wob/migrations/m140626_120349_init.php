<?php

class m140626_120349_init extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('currency', array(
			'id' => 'pk',
			'name' => "varchar(256) NOT NULL",
			'code' => "varchar(5) NOT NULL",
			'round' => "int(11) NOT NULL",
			'is_pay' => "tinyint(1) NOT NULL DEFAULT '0'",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));
		$this->insert('currency',  array(
			"id" => "1",
			"name" => "btc",
			"code" => "BTC",
			"round" => 8,
			"is_pay" => 1,
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('currency',  array(
			"id" => "2",
			"name" => "usd",
			"code" => "USD",
			"round" => 2,
			"is_pay" => 0,
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));

		$this->createTable('orders', array(
			'id' => 'pk',
			'id_shop' => "int(11) NOT NULL",
			'id_status' => "int(11) NOT NULL DEFAULT '1'",
			'id_order_shop' => "int(11) DEFAULT NULL",
			'id_currency_1' => "int(11) DEFAULT NULL",
			'id_currency_2' => "int(11) DEFAULT NULL",
			'amount_1' => "double DEFAULT NULL",
			'amount_2' => "double DEFAULT NULL",
			'amount_paid' => "double DEFAULT NULL",
			'course' => "double DEFAULT NULL",
			'commission' => "double NOT NULL DEFAULT '0'",
			'volume_commission' => "double DEFAULT NULL",
			'adress' => "varchar(1024) DEFAULT NULL",
			'hash' => "varchar(128) NOT NULL",
			'count_confirm' => "int(11) DEFAULT NULL",
			'email' => "varchar(1024) DEFAULT NULL",
			'note' => "varchar(2048) DEFAULT NULL",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));

		$this->createTable('orders_status', array(
			'id' => 'pk',
			'name' => "varchar(512) NOT NULL",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));
		$this->insert('orders_status',  array(
			"id" => "1",
			"name" => "новый",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('orders_status',  array(
			"id" => "2",
			"name" => "завершен",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('orders_status',  array(
			"id" => "3",
			"name" => "не достаточная сумма",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('orders_status',  array(
			"id" => "4",
			"name" => "не достаточное количество подтверждений",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('orders_status',  array(
			"id" => "5",
			"name" => "средства по заказу зачислены на счет",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));

		$this->createTable('pair', array(
			'id' => 'pk',
			'id_currency_1' => "int(11) NOT NULL",
			'id_currency_2' => "int(11) NOT NULL",
			'id_currency_3' => "int(11) DEFAULT NULL",
			'is_pay' => "tinyint(1) NOT NULL DEFAULT '0'",
			'course' => "double NOT NULL",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));
		$this->insert('pair',  array(
			"id" => "1",
			"id_currency_1" => "1",
			"id_currency_2" => "2",
			"id_currency_3" => NULL,
			"is_pay" => 1,
			"course" => 567,
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));

		$this->createTable('shops', array(
			'id' => 'pk',
			'id_user' => "int(11) NOT NULL",
			'url' => "varchar(2048) NOT NULL",
			'name' => "varchar(1024) NOT NULL",
			'email_admin' => "varchar(1024) DEFAULT NULL",
			'password_api' => "varchar(1024) DEFAULT NULL",
			'url_result_api' => "varchar(2048) DEFAULT NULL",
			'id_currency_2' => "int(11) DEFAULT NULL",
			'id_currency_1' => "varchar(512) DEFAULT NULL",
			'is_test_mode' => "tinyint(1) NOT NULL DEFAULT '1'",
			'is_enable' => "tinyint(1) NOT NULL DEFAULT '1'",
			'is_commission_shop' => "tinyint(1) NOT NULL DEFAULT '1'",
			'commission' => "float NOT NULL DEFAULT '0'",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));

		$this->createTable('users_wallet', array(
			'id' => 'pk',
			'id_user' => "int(11) NOT NULL",
			'id_currency' => "int(11) NOT NULL",
			'volume' => "double NOT NULL",
			'address' => "varchar(128) DEFAULT NULL",
			'is_address_activate' => "tinyint(1) NOT NULL DEFAULT '1'",
			'activate_key' => "varchar(128) DEFAULT NULL",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));

		$this->createTable('orders_payoff', array(
			'id' => 'pk',
			'id_wallet' => "int(11) NOT NULL",
			'id_status' => "int(11) NOT NULL DEFAULT '1'",
			'amount' => "double NOT NULL",
			'fee' => "double DEFAULT NULL",
			'count_confirm' => "int(11) DEFAULT NULL",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));
	}

	public function safeDown()
	{
	}
}