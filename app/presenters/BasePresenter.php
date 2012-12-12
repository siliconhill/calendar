<?php

use Nette\Application\UI\Form;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @var LoginControl */
	protected $loginControl;


	/**
	 * @param \LoginControl $loginControl
	 */
	public function injectLoginControl(LoginControl $loginControl)
	{
		$this->loginControl = $loginControl;
	}


	/**
	 * @return LoginControl
	 */
	protected function createComponentLogin()
	{
		$control = $this->loginControl;
		return $control;
	}
}
