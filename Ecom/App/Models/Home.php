<?php namespace Ecom\App\Models;

use Ecom\System;

class Home extends System\MVC\Model
{
	public function getProducts($id)
	{
		return $this->db->query('SELECT * FROM `products` WHERE id = :id', [':id' => $id]);
	}
}

/* End of file Home.php */