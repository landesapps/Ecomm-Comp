<?php namespace Ecom\App\Controllers;

use Ecom\System\MVC;
use Ecom\App\Models;

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

	public function customer()
	{
		if(!empty($_SESSION['cust_id']))
		{
			$content = new MVC\View('cart/purchase.php');
		}
		else
		{
			$content = new MVC\View('account/login.php', ['continue' => 'cart/customer']);
		}
		$views = new MVC\View('template.php', ['content' => $content, 'selected' => 'cart']);
		$views->render();
	}

	public function addToCart($prod_id, $qty)
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
				$found = true;
			}

			$totalQty += $item['qty'];
		}

		if($found === false)
		{
			$cart[$prod_id] = ['prod_id' => $prod_id, 'qty' => $qty];
		}

		$_SESSION['cart'] = $cart;
		$_SESSION['cart_qty'] = $totalQty;

		echo $totalQty;
	}

	public function updateQty($prod_id, $qty)
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
				}
				$found = true;
			}

			$totalQty += $item['qty'];
		}

		if($found === false)
		{
			$cart[$prod_id] = ['prod_id' => $prod_id, 'qty' => $qty];
		}

		$_SESSION['cart'] = $cart;
		$_SESSION['cart_qty'] = $totalQty;

		echo $totalQty;
	}

}