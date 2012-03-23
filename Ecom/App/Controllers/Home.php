<?php namespace Ecom\App\Controllers;

use Ecom\System\MVC;

class Home
{
	public function index()
	{
		//$home_model = new \Ecom\App\Models\Home();
		//$results = $home_model->getProducts(1);
		$content = new MVC\View('index.php');
		$views = new MVC\View('template.php', ['content' => $content, 'selected' => 'home']);
		$views->render();
	}

}