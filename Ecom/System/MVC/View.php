<?php namespace Ecom\System\MVC;

class View
{
	private $file;
	private $data;

	public function __construct($file = null, $data = [])
	{
		$this->file = $file;
		$this->data = $data;
	}

	public function __set($key, $data)
	{
		$this->data[$key] = $data;
	}

	public function __get($key)
	{
		return $this->data[$key];
	}

	public function render()
	{
		extract($this->data, EXTR_REFS);

		ob_start();

		include $this->find();

		ob_flush();
	}

	public function setFile($file)
	{
		$this->file = $file;
	}

	//TODO: Fix find
	private function find()
	{
		return getcwd().'/Ecom/App/Views/'.$this->file;
	}

	public function __toString()
	{
		$this->render();
		return '';
	}
}