<?php

    foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/satellites/perihelion-satellite/php/model/*.php') AS $models) { require($models); }
    foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/satellites/perihelion-satellite/php/view/*.php') AS $views) { require($views); }
    foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/satellites/perihelion-satellite/php/controller/*.php') AS $controllers) { require($controllers); }

	$moduleSessionConstructor = new BiomassSessionController();
	$moduleSessionConstructor->setSession();

?>