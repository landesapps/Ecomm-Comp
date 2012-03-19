<?php namespace Ecom\System\MVC;

use Ecom\System\Database;

class Model
{
	protected $db;

	public function __construct()
	{
		$this->db = Database\Factory::retrieve();
	}
}