<?php

class AuthorizatorFactory extends \Nette\Object
{

	/** @var Nette\Database\Connection */
	private $database;

	/** @var \Nette\Security\User */
	private $user;


	/**
	 * @param Nette\Database\Connection $database
	 * @param Nette\Security\User $user
	 */
	public function __construct(Nette\Database\Connection $database, \Nette\Security\User $user)
	{
		$this->database = $database;
		$this->user = $user;
	}


	/**
	 * @return Nette\Security\Permission
	 */
	public function create()
	{
		$permissions = new \Nette\Security\Permission;

		foreach ($this->database->table('role')->where('role_id', NULL) as $row) {
			$this->addRole($permissions, $row);
		}

		foreach ($this->database->table('resource')->where('resource_id', NULL) as $row) {
			$this->addResource($permissions, $row);
		}

		return $permissions;
	}


	/**
	 * @param Nette\Security\User $user
	 * @return Nette\Security\Permission
	 */
	public function createForUser(\Nette\Security\User $user = NULL)
	{
		$user = $user ? : $this->user;
		$permissions = $this->create();

		if ($user->getIdentity() && count($user->identity->getRoles()) > 0) {
			foreach ($this->database->table('role_resource')->where('role_id', array($user->identity->getRoles())) as $role_resource) {
				$permissions->allow($role_resource->role->name, $role_resource->resource->name, $role_resource->privilege ? : NULL);
			}
		}

		return $permissions;
	}


	/**
	 * @param Nette\Security\Permission $permissions
	 * @param $row
	 */
	protected function addRole(\Nette\Security\Permission $permissions, $row)
	{
		$permissions->addRole($row->name, $row->role ? $row->role->name : NULL);

		foreach ($row->related('role') as $row) {
			$this->addRole($permissions, $row);
		}
	}


	/**
	 * @param Nette\Security\Permission $permissions
	 * @param $row
	 */
	protected function addResource(\Nette\Security\Permission $permissions, $row)
	{
		$permissions->addResource($row->name, $row->resource ? $row->resource->name : NULL);

		foreach ($row->related('resource') as $row) {
			$this->addResource($permissions, $row);
		}
	}
}
