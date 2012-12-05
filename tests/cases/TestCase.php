<?php

namespace SH\Kalendar\Test;

use PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}
}
