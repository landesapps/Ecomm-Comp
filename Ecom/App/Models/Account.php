<?php namespace Ecom\App\Models;

use Ecom\System\MVC;

class Account extends MVC\Model
{
	public function insertCustomer($email, $pass, $salt)
	{
		$sql = 'INSERT INTO customers (email, password, salt) VALUES (:email, :pass, :salt)';
		$this->db->query($sql, [
			':email' => $email,
			':pass' => $pass,
			':salt' => $salt,
			]);
                
		$sql = 'SELECT id FROM customers WHERE email = :email';
		$data = $this->db->query($sql, [':email' => $email]);
		return $data[0]['id'];
	}

	public function getCustomer($email)
	{
		$sql = 'SELECT * FROM customers WHERE email = :email';
		return $this->db->query($sql, [':email' => $email]);
	}

	public function getCustomerAddress($cust_id, $type)
	{
		$sql = 'SELECT * FROM customer_addresses WHERE type = :type AND customers_id = :customer_id';

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
			$sql = 'INSERT INTO customer_addresses (';
			$columns = '';
			$holders = '';
			$values = '';

			foreach($data as $key => $val)
			{
				$columns .= $key.',';
				$holders .= ':'.$key.',';
				$values[':'.$key] = $val;
			}

			$columns .= 'type, customers_id';
			$holders .= ':type, :customers_id';

			$sql .= $columns.') VALUES ('.$holders.')';
		}
		else
		{
			$sql = 'UPDATE customer_addresses SET ';
			$values = '';

			foreach($data as $key => $val)
			{
				$sql .= $key.' = :'.$key.', ';
				$values[':'.$key] = $val;
			}

			$sql = substr($sql, 0, -2);

			$sql .= ' WHERE type = :type AND customers_id = :customers_id';
		}

		$values[':type'] = $type;
		$values[':customers_id'] = $cust_id;
                
		$this->db->query($sql, $values);
	}
}