<?php

namespace App;

use Crypt;

trait Encryptable
{
	public function getAttribute($key)
	{
		$value = parent::getAttribute($key);

		if (in_array($key, $this->encryptable)) {
			$value = Crypt::decryptString($value);
			return $value;
		}
		return $value;
	}

	public function setAttribute($key, $value)
	{
		if (in_array($key, $this->encryptable)) {
			$value = Crypt::encryptString($value);
		}
		return parent::setAttribute($key, $value);
	}
}
