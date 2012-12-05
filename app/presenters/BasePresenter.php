<?php

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @var LoginFormFactory */
	protected $loginFormFactory;


	/**
	 * @param LoginFormFactory $loginFormFactory
	 */
	public function injectLoginFormFactory(LoginFormFactory $loginFormFactory)
	{
		$this->loginFormFactory = $loginFormFactory;
	}


	public function createComponentLogin()
	{
		$form = $this->loginFormFactory->create();
		$form->onSuccess[] = $this->loginSuccess;
		return $form;
	}


	public function loginSuccess()
	{
		$this->flashMessage('Uživatel byl vpořádku přihlášen', 'success');
	}
}
