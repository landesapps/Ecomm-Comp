<?php namespace Ecom\System\Database;

interface Database
{
	public function query($query, $data, $fetch_type);
}