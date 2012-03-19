<?php namespace Ecom\System\Database\Implementation;

use Ecom\System\Configuration;

//TODO: Implement Mysql class
class Mysql implements \Ecom\System\Database\Database
{
	private $conn;

	public function __construct()
	{
		$configs = new Configuration\Configurator();

		$db_configs = $configs->database;

		$this->conn = new \PDO('mysql:dbname='.$db_configs['dbname'].';host='.$db_configs['dbhost'], $db_configs['dbuser'], $db_configs['dbpass']);
	}

	public function query($query, $data, $fetch_type = \PDO::FETCH_ASSOC)
	{
		$pdo_query = $this->conn->prepare($query);
		$pdo_query->execute($data);
		return $pdo_query->fetchAll($fetch_type);
	}
}