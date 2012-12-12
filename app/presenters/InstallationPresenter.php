<?php
use Nette\Database\Connection;
use Nette\InvalidArgumentException;
use Nette\Application\BadRequestException;

class InstallationPresenter extends BasePresenter
{

	/** @var Connection */
	protected $connection;


	/**
	 * @param \Connection $connection
	 */
	public function injectConnection(Connection $connection)
	{
		$this->connection = $connection;
	}


	public function actionDefault()
	{
		if ($this->isInstalled()) {
			throw new BadRequestException('Database is already created.');
		}

		$file = $this->context->parameters['appDir'] . '/config/database.sql';

		if (!file_exists($file)) {
			throw new InvalidArgumentException("File '{$file}' does not exist.");
		}

		$this->connection->query(file_get_contents($file));

		$this->flashMessage('Database has been created.', 'success');
		$this->redirect('Homepage:');
	}


	protected function isInstalled()
	{
		try {
			$this->connection->table('event')->count('*');
			return true;
		} catch (PDOException $e) {
			if ($e->getCode() !== '42S02') {
				throw $e;
			}
		}

		return false;
	}
}
