<?php namespace Ecom\System\Encryption\Implementation;

class Mcrypt
{
	public function __construct()
	{
		if(!function_exists('mcrypt_encrypt'))
		{
			throw new \RuntimeException('Do not have mcrypt installed');
		}
	}

	public function encrypt($message)
	{
		$data = [];
		$data['salt']    = $this->createSalt();
		$data['encoded'] = mcrypt_encrypt(MCRYPT_BLOWFISH, $data['salt'], $message, MCRYPT_MODE_ECB);

		return $data;
	}

	public function decrypt($message, $salt)
	{
		return trim(mcrypt_decrypt(MCRYPT_BLOWFISH, $salt, $message, MCRYPT_MODE_ECB));
	}

	public function createSalt()
	{
		$salt = '';

		for($i = 0; $i < 20; $i++)
		{
			do
			{
				$rand = rand()%128;
			}
			while($rand < 46 or ($rand > 58 and $rand < 64) or ($rand > 91 and $rand < 96) or $rand > 123);

			$salt .= chr($rand);
		}

		return $salt;
	}
}