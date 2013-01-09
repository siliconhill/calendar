<?php

use Nette\Application\UI\Form;
use Nette\Application\UI\Control;

class LoginControl extends Control
{

	/** @var LoginFormFactory */
	protected $loginFormFactory;


	/**
	 * @param LoginFormFactory $loginFormFactory
	 */
	public function __construct(LoginFormFactory $loginFormFactory)
	{
		parent::__construct();

		$this->loginFormFactory = $loginFormFactory;
	}


	public function createComponentLogin()
	{
		$form = $this->loginFormFactory->create();
		$form->onSuccess[] = $this->loginSuccess;
		return $form;
	}


	public function loginSuccess(Form $form)
	{
		if ($form->isValid()) {
			$this->presenter->flashMessage('Uživatel byl vpořádku přihlášen', 'success');
			$this->redirect('this');
		}
	}


	public function handleLogout()
	{
		$this->presenter->user->logout(TRUE);
	}


	public function render()
	{
		$this->template->setFile(__DIR__ . '/LoginControl.latte');
		$this->template->user = $this->presenter->user;
		$this->template->render();
	}
}
