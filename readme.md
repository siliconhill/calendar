Kalendář
========

Instalace
---------

	curl -s http://getcomposer.org/installer | php
	php composer.phar install

Testování
---------

	curl -s http://getcomposer.org/installer | php
	php composer.phar install --dev
	php libs/bin/phpunit

	
GIT Help:
========


  1) stažení projektu:
    git clone https://github.com/siliconhill/calendar.git calendar
    
  2) pokud v budoucnu chceme aktualizovat projekt ze serveru, postačí spusti příkaz:
    git pull
    
  3) nahrání našich změn na server:
    git push origin

Testování:
==========

  Spuštění testů po nainstalování phpunit:
  1) php libs/bin/phpunit

  2) případně php libs/bin/phpunit UnitTest tests/cases/HomepagePresenterTest.php

  Na windowsu:
  Spuštění testů po nainstalování phpunit:
  ??
  

Composer na windowsu:
  composer install
   