<?php

abstract class SecuredPresenter extends BasePresenter
{

	const LOGIN_LINK = ':Login:';


	protected function startup()
	{
		$ref = $this->getReflection();

		if ($ref->hasAnnotation('Secured')) {
			if ($this->user->isLoggedIn()) {
				$resource = $this->getResource();
				$privilege = $this->action;

				if (!$this->user->isAllowed($resource, $privilege)) {
					throw new \Nette\Application\ForbiddenRequestException();
				}
			} else {
				$this->redirect(static::LOGIN_LINK);
			}
		}

		parent::startup();
	}


	public function getResource()
	{
		$ref = $this->getReflection();

		if (!$ref->hasAnnotation('Secured')) {
			return NULL;
		}

		$classSecured = $ref->getAnnotation('Secured');
		return isset($classSecured['resource']) ? $classSecured['resource'] : $this->name;
	}


	public function isLinkAllowed($link)
	{
		if (substr($link, 0, 1) === ':') {
			// @ToDo
		}

		$link = trim($link, '!');

		return $this->user->isAllowed($this->getResource(), 'create');
	}
}
