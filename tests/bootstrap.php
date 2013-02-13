<?php

require_once __DIR__ . '/../libs/autoload.php';

use Nette\Config\Configurator;

$configurator = new Configurator();
$configurator->addConfig(__DIR__ . '/../app/config/config.neon');
$configurator->addConfig(__DIR__ . '/../app/config/config_testing.neon');
$configurator->setDebugMode();
$configurator->enableDebugger(__DIR__ . '/temp/log');
$configurator->setTempDirectory(__DIR__ . '/temp');
$configurator->createRobotLoader()
	->addDirectory(__DIR__ . '/cases')
	->addDirectory(__DIR__ . '/../app')
	->register();
$container = $configurator->createContainer();

// setup
$file = __DIR__ . '/../app/config/database.sql';

$connection = $container->getByType('Nette\\Database\\Connection');
$connection->query(file_get_contents($file))->closeCursor();

$container->user->login(
	$container->parameters['phpunit']['account']['login'],
	$container->parameters['phpunit']['account']['password']
);