<?php
	class World
	{
		private function __construct()
		{
			$this->size = array(10, 10);
			$this->world = array();

			for ($n = 0; $n <= $this->size[0]; $n++) {
				for ($m = 0; $m <= $this->size[1]; $m++) {
					$this->world[$n][$m] = new Location($this, $n, $m);
				}
			}
		}

		static $instance = null;
		public static function getInstance()
		{
			if (is_null(self::$instance)) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function getRegion($x, $y)
		{
			return $this->world[$x][$y];
		}

		private $actions = array();
		public function tick()
		{
			$this->actions = array();

			for ($n = 0; $n <= $this->size[0]; $n++) {
				for ($m = 0; $m <= $this->size[1]; $m++) {
					$this->world[$n][$m]->tick();
				}
			}

			foreach ($this->actions as $callback) {
				call_user_func($callback);
			}
		}

		public function availableDirections($x, $y)
		{
			$directions = array();

			if ($x > 0) {
				$directions[] = 'w';
			}

			if ($x < $this->size[0] - 1) {
				$directions[] = 'e';
			}

			if ($y > 0) {
				$directions[] = 'n';
			}

			if ($y < $this->size[1] - 1) {
				$directions[] = 's';
			}

			return $directions;
		}

		public function getWorld()
		{
			return $this->world;
		}

		public function registerAction($callback)
		{
			$this->actions[] = $callback;
		}

		public function getAdjacent($x, $y, $direction)
		{
			switch ($direction) {
				case 'n':
				echo "$x:$y\n";
					return $this->world[$x][$y - 1];
				case 's':
					echo "$x:$y\n";
					return $this->world[$x][$y + 1];
				case 'w':
					echo "$x:$y\n";
					return $this->world[$x-1][$y];
				case 'e':
					echo "$x:$y\n";
					return $this->world[$x + 1][$y];
			}
		}
	}

	class Location
	{
		private $initial_food = 100;
		private $food;

		private $creatures = array();

		public function __construct($world, $x, $y)
		{
			$this->x = $x;
			$this->y = $y;

			$this->world = $world;

			$this->food = $this->initial_food + rand(1, 100);
		}

		public function eatFood($amount) {
			$this->food = max(0, $this->food - $amount);
		}

		public function hasFood()
		{
			return $this->food > 0;
		}

		public function addCreature(Creature $creature)
		{
			$this->creatures[] = $creature;
			$creature->setLocation($this);
		}

		public function removeCreature($creature)
		{
			foreach ($this->creatures as $n => $c) {
				if ($c === $creature) {
					$creature->setLocation(null);
					unset($this->creatures[$n]);
				}
			}
		}

		public function tick()
		{
			foreach ($this->creatures as $creature) {
				$creature->on('tick');
				$creature->onAfterTick();
			}
		}

		public function countCreatures()
		{
			return count($this->creatures);
		}

		public function availableDirections() {
			return $this->world->availableDirections($this->x, $this->y);
		}

		public function getAdjacent($direction) {
			return $this->world->getAdjacent($this->x, $this->y, $direction);
		}


	}