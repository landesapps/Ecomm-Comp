<?php namespace Ecom\System\Database\Implementation;

use Ecom\System\Configuration;

class PDO implements \Ecom\System\Database\Database
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

		if($pdo_query->execute($data) === false)
		{
			$message = '---'.date('Y-m-d H:i:s').'---'.PHP_EOL;
			$message .= 'Page: '.$_SERVER['SERVER_NAME'].'/'.$_SERVER['REQUEST_URI'].PHP_EOL;
			$message .= 'Query: '.$query.PHP_EOL;
			$message .= 'Params: '.print_r($data, true).PHP_EOL;
			$message .= 'Error: '.$error[2].PHP_EOL;
			$message .= '------'.PHP_EOL;

			error_log($message);
		}

		return $pdo_query->fetchAll($fetch_type);
	}
}