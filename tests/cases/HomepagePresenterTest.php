<?php

namespace SH\Kalendar\Test;

use Nette;
use Nette\Environment;
use Nette\Application\IPresenter;
use HomepagePresenter;

class HomepagePresenterTest extends TestCase
{

	/** @var IPresenter */
	protected $presenter;


	public function setUp()
	{
		$this->presenter = new HomepagePresenter(Environment::getContainer());
	}


	public function testRenderDefault()
	{
		$request = new Nette\Application\Request('Homepage', 'GET', array());
		$response = $this->presenter->run($request);

		$this->assertEquals('any value', $this->presenter->template->anyVariable);
		$this->assertInstanceOf('Nette\Application\Responses\TextResponse', $response);
	}

}
