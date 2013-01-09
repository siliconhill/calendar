<?php

require_once __DIR__ . '/../libs/autoload.php';

use Nette\Config\Configurator;

$configurator = new Configurator();
$configurator->addConfig(__DIR__ . '/../app/config/config.neon');
$configurator->setDebugMode();
$configurator->enableDebugger(__DIR__ . '/temp/log');
$configurator->setTempDirectory(__DIR__ . '/temp');
$configurator->createRobotLoader()
	->addDirectory(__DIR__ . '/cases')
	->addDirectory(__DIR__ . '/../app')
	->register();
$configurator->createContainer();