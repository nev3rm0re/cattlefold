<?php
	// build world
	// put creatures in it
	// run simulation
	//
	require_once('world.php');
	require_once('creatures/mouse.php');

	$world = World::getInstance();

	for ($i = 0; $i < 100; $i++) {
		$world->getRegion(0, 0)->addCreature(new Mouse());
	}


	for ($i = 0; $i < 200; $i++) {
		$world->tick();

		echo str_pad("Turn $i", 40, ' ', STR_PAD_BOTH) . "\n";
		foreach ($world->getWorld() as $row) {
			foreach ($row as $cell) {
				if ($cell->countCreatures() > 0) {
					$label = 'C';
				} elseif ($cell->hasFood()) {
					$label = '.';
				} else {
					$label = 'x';
				}

				echo $label;
			}
			echo "\n";
		}

		echo "\n\n\n\n";
		usleep(100000);
	}
