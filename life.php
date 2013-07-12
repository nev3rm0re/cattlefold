<?php
	// build world
	// put creatures in it
	// run simulation
	//
	require_once('world.php');
	require_once('creatures/mouse.php');

	require_once('render.php');

	$world = World::getInstance();

	for ($i = 0; $i < 100; $i++) {
		$world->getRegion(0, 0)->addCreature(new Mouse());
	}


	for ($i = 0; $i < 200; $i++) {
		ob_start();
		$world->tick();
		$output = ob_get_clean();

		render_world($world);
		render_output("Tick $i", $output);
		usleep(100000);
	}
