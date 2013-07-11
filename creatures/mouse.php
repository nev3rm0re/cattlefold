<?php
	require_once('creature.php');

	class Mouse extends Creature
	{
		public function configure()
		{
			$this->food_needed = 30;
			$this->lifespan = -1;
			$this->hasAbility('move');
		}

		public function on($event, $payload = null)
		{
			if ($this->location->hasFood()) {
				$this->eat();
			} else {
				$directions = $this->move->availableDirections();
				$direction = $directions[array_rand($directions)];
				$this->move->go($direction);
				$this->last_move = $direction;
			}
		}
	}