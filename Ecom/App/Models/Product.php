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
				LEFT JOIN product_images pi ON pi.products_id = p.id
				LEFT JOIN product_descriptions pd ON pd.products_id = p.id';

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

	public function getProductsByCategory($category)
	{
		$params = [':category' => $category];
		$sql = 'SELECT
					pd.id AS prod_id,
					pd.*,
					pi.*
				FROM products p
				LEFT JOIN product_images pi ON pi.products_id = p.id
				LEFT JOIN product_descriptions pd ON pd.products_id = p.id
				LEFT JOIN product_categories_map pcm ON pcm.product_descriptions_id = pd.id
				LEFT JOIN categories c ON c.id = pcm.categories_id
				WHERE c.name = :category';

		return $this->db->query($sql, $params);
	}
}

/* End of file Home.php */