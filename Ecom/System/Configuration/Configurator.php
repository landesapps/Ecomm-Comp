<?php namespace Ecom\System\Configuration;

class Configurator
{
	private $configs = [
		'database' => [
			'dbname'         => 'ecomm',
			'dbhost'         => '127.0.0.1',
			'dbuser'         => 'root',
			'dbpass'         => 'admin',
			'implementation' => 'PDO',
		],
		'assets'   => [
			'location'       => '/var/www/ecommerce-comp/Ecom/App/Views/Assets',
		],
	];

	public function __get($key)
	{
		return $this->configs[$key];
	}

	public function __set($key, $value)
	{
		$this->configs[$key] = $value;
	}
}