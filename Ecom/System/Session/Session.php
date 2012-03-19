<?php namespace Ecom\System\Session;

class Session
{
	public function __construct()
	{
		\session_start();

		if(isset($_COOKIE['ecom_sess_id']))
		{
			session_id($_COOKIE['ecom_sess_id']);
		}
		else
		{
			setcookie('ecom_sess_id', session_id(), (time() + (60 * 60 * 24)), '/', 'ecommerce.com');
		}
	}

	public function __destroy()
	{
		session_write_close();
	}
}