<?php namespace Ecom\App\Controllers;

use Ecom\System\MVC;
use Ecom\App\Models;
use Ecom\System\Payment\Implementation as Payment;

class Cart
{
	public function index()
	{
		$param = [];
		$items = [];
		$product_model = new Models\Product();

		if(isset($_SESSION['cart']))
		{
			foreach($_SESSION['cart'] as $item)
			{
				$param[] = $item['prod_id'];
			}

			$items = $product_model->getProductsByIds($param);
		}

		$content = new MVC\View('cart/index.php', ['items' => $items]);
		$views = new MVC\View('template.php', ['content' => $content, 'selected' => 'cart']);
		$views->render();
	}

	public function customer($error = null)
	{
		if(!empty($_SESSION['cust_id']))
		{
			$content = new MVC\View('cart/purchase.php', ['error' => $error]);
		}
		else
		{
			$content = new MVC\View('account/login.php', ['continue' => 'cart/customer']);
		}
		$views = new MVC\View('template.php', ['content' => $content, 'selected' => 'cart']);
		$views->render();
	}
        
	public function purchase($postData)
	{
		$payment = new Payment\Paypal();
		$customer = new Models\Account();
		$billing = $customer->getCustomerAddress($_SESSION['cust_id'], 'billing');
		
		$price = 0;
		
		foreach($_SESSION['cart'] as $item)
		{
			$price += $item['price'];
		}
		
		$data = [
			'amount'     => $price,
			'currency'   => 'USD',
			'card_type'  => $postData['card_type'],
			'card_num'   => $postData['card_num'],
			'exp_month'  => $postData['exp_month'],
			'exp_year'   => $postData['exp_year'],
			'cvv'        => $postData['card_cvv'],
			'first_name' => $postData['first_name'],
			'last_name'  => $postData['last_name'],
			'line_1'     => $billing[0]['address_1'],
			'city'       => $billing[0]['city'],
			'state'      => $billing[0]['state'],
			'zip'        => $billing[0]['zip_code'],
			'country'    => $billing[0]['country'],
		];
		
		$response = $payment->auth($data);
		
		if($response === true)
		{
			echo 'Success';
		}
		else
		{
			Cart::customer($response['L_LONGMESSAGE0']);
		}
	}

	public function addToCart($prod_id, $qty, $price)
	{
		$cart = [];

		if(isset($_SESSION['cart']))
		{
			$cart = $_SESSION['cart'];
		}

		$found = false;
		$totalQty = $qty;

		foreach($cart as $key => $item)
		{
			if($item['prod_id'] == $prod_id)
			{
				$cart[$key]['qty'] += $qty;
				$cart[$key]['price'] += $qty * $price;
				$found = true;
			}

			$totalQty += $item['qty'];
		}

		if($found === false)
		{
			$cart[$prod_id] = [
				'prod_id' => $prod_id, 
				'qty'     => $qty,
				'price'   => ($qty * $price),
				];
		}

		$_SESSION['cart'] = $cart;
		$_SESSION['cart_qty'] = $totalQty;
		
		echo $totalQty;
	}

	public function updateQty($prod_id, $qty, $price)
	{
		$cart = [];

		if(isset($_SESSION['cart']))
		{
			$cart = $_SESSION['cart'];
		}

		$found = false;
		$totalQty = $qty;

		foreach($cart as $key => $item)
		{
			if($item['prod_id'] == $prod_id)
			{
				if($qty == 0)
				{
					unset($cart[$key]);
					$item['qty'] = 0;
				}
				else
				{
					$cart[$key]['qty'] = $qty;
					$cart[$key]['price'] = $qty * $price;
				}
				$found = true;
			}

			$totalQty += $item['qty'];
		}

		if($found === false)
		{
			$cart[$prod_id] = [
				'prod_id' => $prod_id, 
				'qty'     => $qty, 
				'price'   => ($qty * $price)
				];
		}

		$_SESSION['cart'] = $cart;
		$_SESSION['cart_qty'] = $totalQty;

		echo $totalQty;
	}

}