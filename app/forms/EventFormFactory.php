<?php

use Nette\Object;
use Nette\Database\Connection;
use Nette\Forms\Controls\Button;
use Nette\Application\UI\Form;

class EventFormFactory extends Object
{

	/** @var Connection */
	protected $connection;


	/** @var int */
	protected $id;


	/**
	 * @param Nette\Database\Connection $connection
	 */
	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}


	/**
	 * @return Nette\Application\UI\Form
	 */
	public function create()
	{
		$form = new Form();
		$form->addGroup();
		$form->setRenderer(new \Kdyby\Extension\Forms\BootstrapRenderer\BootstrapRenderer());
		$form->addText('name', 'Name');
		$form->addTextArea('description', 'Popis');

		$instances = $form->addDynamic('instances', function (\Nette\Forms\Container $container) {
			$container->setCurrentGroup($container->form->addGroup('Instance'));
			$container->addText('timeStart', 'Start');
			$container->addText('timeEnd', 'End');
			$container->addSubmit('remove', 'Smazat')->addRemoveOnClick();
		}, 1);

		$instances->addSubmit('add', 'Přidat instanci')->addCreateOnClick();

		$form->addGroup();
		$form->addSubmit('_submit', 'Save')->onClick[] = $this->handleSave;

		return $form;
	}


	public function createEdit($id)
	{
		$this->id = $id;
		$form = $this->create();

		$row = $this->connection->table('event')->find($id)->fetch();
		$form->setDefaults($row);

		foreach ($this->connection->table('instance')->where(array('event_id' => $row['id'])) as $instance) {
			/** @var $container \Kdyby\Extension\Forms\Replicator\Replicator */
			$container = $form['instances'];
			$container->createOne($instance['id'])->setDefaults($instance);
		}

		return $form;
	}


	public function handleSave(Button $button)
	{
		/** @var $form Form */
		$form = $button->form;
		$data = $form->getValues();
		$instances = $form['instances']->getValues();
		unset($data['_submit']);
		unset($data['instances']);

		try {
			$this->connection->beginTransaction();
			if (!$this->id) {
				$this->connection->table('event')->insert($data);
				$id = $this->connection->lastInsertId();
			} else {
				$this->connection->table('event')->where(array('id' => $this->id))->update($data);
				$id = $this->id;
			}

			$this->connection->table('instance')->where(array('event_id' => $id))->delete();

			foreach ($instances as $instance) {
				$instance['event_id'] = $id;
				$this->connection->table('instance')->insert($instance);
			}
			$this->connection->commit();
		} catch (PDOException $e) {
			$form->addError($e->getMessage());
		}
	}
}