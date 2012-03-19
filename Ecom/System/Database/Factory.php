<?php namespace Ecom\System\Database;

use Ecom\System\Configuration;

class Factory
{
	public static function retrieve()
	{
		$config = new Configuration\Configurator();

		$db = $config->database;

		$class = 'Ecom\\System\\Database\\Implementation\\'.$db['implementation'];

		return new $class;
	}
}