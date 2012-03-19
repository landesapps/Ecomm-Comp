<?php namespace Ecom\App\Models;

use Ecom\System\MVC;

class Product extends MVC\Model
{
	public function getProductsByIds(array $ids)
	{
		if(empty($ids))
		{
			return [];
		}

		$sql = 'SELECT
					*
				FROM products p
				LEFT JOIN product_images pi ON pi.product_id = p.id
				LEFT JOIN product_descriptions pd ON pd.product_id = p.id';

		if(!empty($ids))
		{
			$sql .= ' WHERE ';

			foreach($ids as $key => $val)
			{
				$sql .= 'pd.id = :'.$key.' OR ';
				$params[':'.$key] = $val;
			}

			$sql = substr($sql, 0, strlen($sql) - 4);
		}

		return $this->db->query($sql, $params);
	}

	public function getProducts($data)
	{
		$params = [];
		$sql = 'SELECT
					*
				FROM products p
				LEFT JOIN product_images pi ON pi.product_id = p.id
				LEFT JOIN product_descriptions pd ON pd.product_id = p.id';

		if(!empty($data))
		{
			$sql .= ' WHERE ';

			foreach($data as $key => $val)
			{
				$sql .= $key.' = :'.$key.' AND ';
				$params[':'.$key] = $val;
			}

			$sql = substr($sql, 0, strlen($sql) - 5);
		}

		return $this->db->query($sql, $params);
	}
}

/* End of file Home.php */