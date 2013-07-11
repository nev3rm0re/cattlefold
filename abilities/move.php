<?php
	namespace Ability;

	class Move
	{
		public function __construct($creature) {
			$this->creature = $creature;
		}

		public function go($direction)
		{
			if (!in_array($direction, $this->availableDirections())) {
				throw new Exception('Unable to move in this direction, call availableDirections() to find out where you can go');
			}

			$this->direction = $direction;

			$world = \World::getInstance();
			$world->registerAction(array($this, 'doGo'));
		}

		public function doGo() {
			if ($this->creature->isDead()) {
				// do nothing
				return;
			}

			$current_location = $this->creature->getLocation();
			$new_location = $this->creature->getLocation()->getAdjacent($this->direction);

			$current_location->removeCreature($this->creature);
			$new_location->addCreature($this->creature);
		}

		public function availableDirections() {
			return $this->creature->getLocation()->availableDirections();
		}
	}