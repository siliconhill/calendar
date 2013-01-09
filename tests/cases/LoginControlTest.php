<?php

namespace SH\Kalendar\Test;

use Nette;
use BasePresenter;
use LoginFormFactory;
use LoginControl;
use Nette\Application\UI\Presenter;
use Nette\Environment;
use Nette\Application\IPresenter;

class LoginControlTest extends TestCase
{

	/** @var LoginControl */
	protected $control;

	/** @var IPresenter */
	protected $presenter;


	public function setUp()
	{
		/** @var $container \SystemContainer */
		$container = Environment::getContainer();

		$this->presenter = new LoginPresenter($container);
		$this->presenter->injectLoginControl($container->loginControl);
		$this->control = $this->presenter['login'];
	}


	public function testRenderDefault()
	{
		$this->assertEquals($this->presenter->user, $this->control->template->user);
	}
}


class LoginPresenter extends BasePresenter
{

}
