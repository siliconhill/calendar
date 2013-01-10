<?php

namespace SH\Kalendar\Test;

use Nette\Environment;
use PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase
{


	protected function login()
	{
		Environment::getContext()->user->login('admin', '1234');
	}


	protected function logout()
	{
		Environment::getContext()->user->logout(TRUE);
	}
}
