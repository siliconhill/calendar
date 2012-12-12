<?php

use Nette\Object;
use Nette\Forms\Controls\Button;
use Nette\Application\UI\Form;

class LoginFormFactory extends Object
{

	/**
	 * @return Nette\Application\UI\Form
	 */
	public function create()
	{
		$form = new Form();
		$form->addText('name', 'Name');
		$form->addPassword('password', 'Password');
		$form->addSubmit('_submit', 'Login')->onClick[] = $this->handleSuccess;

		return $form;
	}


	public function handleSuccess(Button $button)
	{
		/** @var $form Form */
		$form = $button->form;

		try {
			$form->presenter->user->login($form['name']->value, $form['password']->value);
		} catch (\Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
			$form->presenter->flashMessage($e->getMessage(), 'warning');
		}
	}
}