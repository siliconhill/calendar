<?php

abstract class SecuredPresenter extends BasePresenter
{

	const LOGIN_LINK = ':Login:';


	protected function startup()
	{
		$ref = $this->getReflection();

		if ($ref->hasAnnotation('Secured')) {
			if ($this->user->isLoggedIn()) {
				$classSecured = $ref->getAnnotation('Secured');
				$resource = isset($classSecured['resource']) ? $classSecured['resource'] : $this->name;
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
}
