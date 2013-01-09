<?php

use Nette\Object;
use Nette\Database\Connection;
use Nette\Forms\Controls\Button;
use Nette\Application\UI\Form;

class EventFormFactory extends Object
{

	/** @var Connection */
	protected $connection;


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
		$form->setRenderer(new \Kdyby\Extension\Forms\BootstrapRenderer\BootstrapRenderer());
		$form->addHidden('id');
		$form->addText('name', 'Name');
		$form->addTextArea('description', 'Popis');
		$form->addSubmit('_submit', 'Save')->onClick[] = $this->handleSave;

		return $form;
	}


	public function createEdit($id)
	{
		$form = $this->create();

		$form->setDefaults($this->connection->table('event')->find($id)->fetch());

		return $form;
	}


	public function handleSave(Button $button)
	{
		/** @var $form Form */
		$form = $button->form;
		$data = $form->getValues();
		unset($data['_submit']);

		try {
			if (!$data['id']) {
				$this->connection->table('event')->insert($data);
			} else {
				$this->connection->table('event')->where(array('id' => $data['id']))->update($data);
			}
		} catch (PDOException $e) {
			$form->addError($e->getMessage());
		}
	}
}