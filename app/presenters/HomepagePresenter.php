<?php
use Nette\Application\UI\Form;
use Nette\Application\BadRequestException;
use Nette\Database\Connection;

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	/**
	 * @var
	 * @persistent
	 */
	public $id;

	/** @var EventFormFactory */
	protected $eventFormFactory;

	/** @var Connection */
	protected $connection;


	/**
	 * @param \EventFormFactory $eventFormFactory
	 */
	public function injectEventFormFactory(EventFormFactory $eventFormFactory)
	{
		$this->eventFormFactory = $eventFormFactory;
	}


	/**
	 * @param \Connection $connection
	 */
	public function injectConnection(Connection $connection)
	{
		$this->connection = $connection;
	}


	protected function startup()
	{
		parent::startup();

		if ($this->id && $this->action !== 'edit') {
			throw new BadRequestException('');
		}
	}


	protected function createComponentEventForm()
	{
		if ($this->id) {
			$form = $this->eventFormFactory->createEdit($this->id);
		} else {
			$form = $this->eventFormFactory->create();
		}
		$form['_submit']->onClick[] = $this->eventFormSuccess;
		return $form;
	}


	public function eventFormSuccess($button)
	{
		if ($button->form->isValid()) {
			if ($this->id) {
				$this->flashMessage('Event byl zeditován');
			} else {
				$this->flashMessage('Event byl přidán');
			}
			$this->redirect('default', array('id' => NULL));
		}
	}


	public function renderDefault()
	{
		$this->template->events = $this->connection->table('event');
	}
}
