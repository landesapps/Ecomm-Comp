<?php namespace Ecom\System\Configuration;

class Configurator
{
	private $configs = [
		'database' => [
			'dbname'         => 'ecommerce',
			'dbhost'         => '127.0.0.1',
			'dbuser'         => 'root',
			'dbpass'         => 'admin',
			'implementation' => 'PDO',
		],
		'assets'   => [
			'location'       => '/var/www/ecommerce-comp/Ecom/App/Views/Assets',
		],
                'paypal'   => [
                        'username'       => 'wannas_1298918734_biz_api1.gmail.com',
                        'password'       => '1298918748',
                        'signature'      => 'A68mR8KQVhakpSkUwmRn8.oh5F-LA38LwEKAjt1FCiQWuE1pq3bSHC3.',
                        'api_url'        => 'https://api-3t.sandbox.paypal.com/nvp',
                        'pay_url'        => 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=',
                        'proxy'          => false,
						'version'        => '65.1',
                ]
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