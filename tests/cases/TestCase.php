<?php

namespace SH\Kalendar\Test;

use Nette\Environment;
use PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase
{


	protected function login()
	{
		Environment::getContext()->user->login('test', 'tajne');
	}


	protected function logout()
	{
		Environment::getContext()->user->logout(TRUE);
	}
}
