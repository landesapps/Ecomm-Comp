<?php namespace Ecom\App\Controllers;

use Ecom\App\Models;
use Ecom\System\MVC;
use Ecom\System\Encryption\Implementation;

class Account
{
	public function index()
	{
		if(!empty($_SESSION['cust_id']))
		{
			Account::verify();
		}
		else
		{
			Account::login();
		}
	}

	public function verify($postData = null)
	{
		$cust_account = [
			'states' => [
				'UT',
				'NV',
				'WY',
			],
			'countries' => [
				'US',
				'CA',
			]
		];

		if(!empty($_SESSION['cust_id']))
		{
			$acc_model = new Models\Account();
			$cust_account['billing'] = $acc_model->getCustomerAddress($_SESSION['cust_id'], 'billing')[0];
			$cust_account['shipping'] = $acc_model->getCustomerAddress($_SESSION['cust_id'], 'shipping')[0];
		}

		$cust_account['continue'] = '//'.$_SERVER['HTTP_HOST'].'/';

		$content = new MVC\View('account/verify.php', $cust_account);

		$views = new MVC\View('template.php', ['content' => $content, 'selected' => 'account']);
		$views->render();
	}

	public function login()
	{
		$content = new MVC\View('account/login.php', ['continue' => 'account/verify']);

		$views = new MVC\View('template.php', ['content' => $content, 'selected' => 'account']);
		$views->render();
	}

	public function logout()
	{
		unset($_SESSION['cust_id']);
	}

	public function loginValidation($postData = null)
	{
		if(filter_var($postData['email'], FILTER_VALIDATE_EMAIL) and !empty($postData['pass']))
		{
			$postData['pass'] = filter_var($postData['pass'], FILTER_SANITIZE_STRING);

			$acc_model = new Models\Account();
			$crypt = new Implementation\Mcrypt();
			$customerData = $acc_model->getCustomer($postData['email']);

			if($crypt->decrypt($customerData[0]['password'],
					$customerData[0]['salt']) == $postData['pass'])
			{
				$_SESSION['cust_id'] = $customerData[0]['id'];
				header('Location: //'.$_SERVER['HTTP_HOST'].'/'.$postData['return']);
			}

		}
	}

	public function signup($postData = null)
	{
		$crypt = new Implementation\Mcrypt();
		if(filter_var($postData['email'], FILTER_VALIDATE_EMAIL) and !empty($postData['pass']) and $postData['pass'] == $postData['pass2'])
		{
			$postData['pass'] = filter_var($postData['pass'], FILTER_SANITIZE_STRING);
			$pass = $crypt->encrypt($postData['pass']);
			$acc_model = new Models\Account();
			$_SESSION['cust_id'] = $acc_model->insertCustomer($postData['email'], $pass['encoded'], $pass['salt']);

			header('Location: //'.$_SERVER['HTTP_HOST'].'/'.$postData['return']);
		}
		else
		{
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}

	}

	public function updateCustomer($postData = null)
	{
		$billing = [];
		$shipping = [];

		foreach($postData as $key => $dat)
		{
			if(strpos($key, 'billing_') !== false)
			{
				$billing[substr($key, 8)] = $dat;
			}
			else
			{
				$shipping[substr($key, 9)] = $dat;
			}
		}

		if(!empty($_SESSION['cust_id']))
		{
			$acc_model = new Models\Account();

			$acc_model->updateCustomerAddress(
					$_SESSION['cust_id'], 'billing', $billing);
			$acc_model->updateCustomerAddress(
					$_SESSION['cust_id'], 'shipping', $shipping);
		}

		if(!empty($postData['continue']))
		{
			header('Location: '.$postData['continue']);
		}
	}

}