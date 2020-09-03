<?php

namespace app\Db;

use app\Db\DataBase;

final class DbConfig extends DataBase {

			protected static $dbconf = [
				'host' => 'localhost',
				'name' => 'munovv_database',
				'user' => 'root',
				'password' => '',
			];

}

?>
