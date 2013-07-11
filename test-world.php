<?php
	require_once('world.php');

	$world = World::getInstance();

	$d = $world->getRegion(0, 0)->availableDirections();
	var_dump($d);

	$e = $world->getRegion(0, 0)->getAdjacent('e');
	var_dump($e->availableDirections());