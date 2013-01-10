<?php

namespace SH\Kalendar\Test;

use Nette;
use Nette\Environment;
use HomepagePresenter;

class HomepagePresenterTest extends TestCase
{

	/** @var HomepagePresenter */
	protected $presenter;


	public function setUp()
	{
		/** @var $container \SystemContainer */
		$container = Environment::getContainer();

		$this->presenter = $container->createInstance('HomepagePresenter');
		$this->presenter->injectConnection($container->getByType('Nette\Database\Connection'));
		$this->presenter->injectEventFormFactory($container->eventFormFactory);
	}


	public function testRenderDefault()
	{
		$request = new Nette\Application\Request('Homepage', 'GET', array());
		$response = $this->presenter->run($request);


		$this->assertTrue(isset($this->presenter->template->events));
		$this->assertInstanceOf('Nette\Database\Table\Selection', $this->presenter->template->events);
		$this->assertInstanceOf('Nette\Application\UI\Form', $this->presenter['eventForm']);
		$this->assertInstanceOf('Nette\Application\Responses\TextResponse', $response);
	}


	public function testRenderCreate()
	{
		$request = new Nette\Application\Request('Homepage', 'GET', array('action' => 'create'));
		$response = $this->presenter->run($request);

		$this->assertInstanceOf('Nette\Application\Responses\TextResponse', $response);
	}


	/**
	 * @expectedException Nette\Application\BadRequestException
	 */
	public function testRenderDefaultException()
	{
		$request = new Nette\Application\Request('Homepage', 'GET', array('id' => 5));
		$response = $this->presenter->run($request);
	}


	/**
	 * @expectedException Nette\Application\BadRequestException
	 */
	public function testRenderCreateException()
	{
		$request = new Nette\Application\Request('Homepage', 'GET', array('action' => 'create', 'id' => 5));
		$response = $this->presenter->run($request);
	}
}
