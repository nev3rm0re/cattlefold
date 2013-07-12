<?php
	function render_world($world) {
		cls();
		echo str_repeat("\n", 10);
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
	}

	function cls() {
		array_map(function($a) {echo chr($a);}, array(27, 91, 72, 27, 91, 50, 74));
	}

	function render_output($title, $output) {
		static $buffer = array();
		$lines = explode("\n", $output);

		$buffer += $lines;
		$buffer = array_slice($buffer, -10);

		echo str_pad('  ' . $title . '  ', 60, '=', STR_PAD_LEFT);
		echo str_repeat("=", 60), "\n";
		foreach ($buffer as $line) {
			echo $line. "\n";
		}
	}