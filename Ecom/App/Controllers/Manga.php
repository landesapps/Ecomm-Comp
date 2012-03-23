<?php namespace Ecom\App\Controllers;

use Ecom\System\MVC;

class Manga
{
	public function index()
	{
		$product_model = new \Ecom\App\Models\Product();
		$items = $product_model->getProductsByCategory('manga');
		/*$items = [
			0 => [
				'name' => 'Rurouni Kenshin',
				'desc' => 'Badass Samurai',
				'price' => '12.07',
				'image' => 'Assets/index/images/manga/kenshin.jpeg',
				'prod_id' => 1,
			],
			1 => [
				'name' => 'Naruto',
				'desc' => 'Badass Ninja',
				'price' => '5.00',
				'image' => 'Assets/index/images/manga/naruto.jpg',
				'prod_id' => 2,
			],
			2 => [
				'name' => 'Liar Game',
				'desc' => 'Badass Psychology Game',
				'price' => '10.00',
				'image' => 'Assets/index/images/manga/liar_game.jpeg',
				'prod_id' => 3,
			],
		];*/
		$content = new MVC\View('search.php', ['items' => $items]);
		$views = new MVC\View('template.php', ['content' => $content, 'selected' => 'manga']);
		$views->render();
	}

}