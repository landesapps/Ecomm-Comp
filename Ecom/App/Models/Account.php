<?php namespace Ecom\App\Models;

use Ecom\System\MVC;

class Account extends MVC\Model
{
	public function insertCustomer($email, $pass, $salt)
	{
		$sql = 'INSERT INTO customer (email, password, salt) VALUES (:email, :pass, :salt)';
		$this->db->query($sql, [
			':email' => $email,
			':pass' => $pass,
			':salt' => $salt,
			]);

		$sql = 'SELECT id FROM customer WHERE email = :email';
		$data = $this->db->query($sql, [':email' => $email]);
		die('end');
		return $data[0]['id'];
	}

	public function getCustomer($email)
	{
		$sql = 'SELECT * FROM customer WHERE email = :email';
		return $this->db->query($sql, [':email' => $email]);
	}

	public function getCustomerAddress($cust_id, $type)
	{
		$sql = 'SELECT * FROM customer_address WHERE address_type = :type AND customer_id = :customer_id';

		return $this->db->query($sql, [
			':type' => $type,
			':customer_id' => $cust_id,
		]);
	}

	public function updateCustomerAddress($cust_id, $type, $data)
	{
		$customer = $this->getCustomerAddress($cust_id, $type);

		if(empty($customer))
		{
			$sql = 'INSERT INTO customer_address (';
			$columns = '';
			$holders = '';
			$values = '';

			foreach($data as $key => $val)
			{
				$columns .= $key.',';
				$holders .= ':'.$key.',';
				$values[':'.$key] = $val;
			}

			$columns .= 'address_type, customer_id';
			$holders .= ':type, :customer_id';

			$sql .= $columns.') VALUES ('.$holders.')';
		}
		else
		{
			$sql = 'UPDATE customer_address SET ';
			$values = '';

			foreach($data as $key => $val)
			{
				$sql .= $key.' = :'.$key.', ';
				$values[':'.$key] = $val;
			}

			$sql = substr($sql, 0, -2);

			$sql .= ' WHERE address_type = :type AND customer_id = :customer_id';
		}

		$values[':type'] = $type;
		$values[':customer_id'] = $cust_id;

		$this->db->query($sql, $values);
	}
}