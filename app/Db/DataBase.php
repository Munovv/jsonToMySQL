<?php

namespace app\Db;

use PDO;
use app\Db\DbConfig;

class DataBase {

			protected $db;

			public function __construct() {
				$config = DbConfig::$dbconf;
				$this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].'', $config['user'], $config['password']);
				$this->db->exec("set names utf8");
			}

			public function query($sql, $params = []) {
				$stmt = $this->db->prepare($sql);
				if (!empty($params)) {
					foreach ($params as $key => $val) {
						if (is_int($val)) {
							$type = PDO::PARAM_INT;
						} else {
							$type = PDO::PARAM_STR;
						}
						$stmt->bindValue(':'.$key, $val, $type);
					}
				}
				$stmt->execute();
				return $stmt;
			}

			public function row($sql, $params = []) {
				$result = $this->query($sql, $params);
				return $result->fetchAll(PDO::FETCH_ASSOC);
			}

			public function column($sql, $params = []) {
				$result = $this->query($sql, $params);
				return $result->fetchColumn();
			}

			public function fastInsert($table, $data) {
				$fields	     = '`' . implode('`, `', array_keys($data)) . '`';
				$fields_data = ':' . implode(', :', array_keys($data));
				$result      = $this->query('INSERT INTO '.$table.' ('.$fields.') VALUES ('.$fields_data.')', $data);
				return $result;
			}

			public function fastSelect($table, $data) {
				$fields	     = '`' . implode('`, `', array_keys($data)) . '`';
				$fields_data = ':' . implode(', :', array_keys($data));
				$result      = $this->row('SELECT * FROM '.$table.' WHERE '.$fields.' = '.$fields_data.'', $data)[0];
				return $result;
			}

}
