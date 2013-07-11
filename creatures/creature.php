<?php
	require_once(dirname(__FILE__).'/../abilities/move.php');

	abstract class Creature
	{
		private $abilities;
		public function __construct()
		{
			$this->abilities = array();
			$this->lifespan = -1;
			$this->age = 0;

			$this->configure();

			$this->hungerMax = 5;
		}

		public function setLocation($location) {
			$this->location = $location;
		}
		public function getLocation() {
			return $this->location;
		}

		abstract public function on($event, $payload = null);

		abstract protected function configure();

		protected function hasAbility($name)
		{

			if (!in_array($name, $this->abilities)) {
				$this->$name = $this->abilities[] = $this->loadAbility($name);
			}
		}

		protected function eat() {
			$this->hunger = 0;
			$this->location->eatFood($this->food_needed);
		}

		private function loadAbility($name)
		{
			switch ($name) {
				case 'move':
					return new \Ability\Move($this);
					break;
			}
		}

		public final function onAfterTick()
		{
			$this->age++;
			$this->hunger++;
			if ($this->lifespan !== -1 && $this->age > $this->lifespan)
			{
				$this->vanish();
			}

			if ($this->hunger > $this->hungerMax) {
				echo 'Dying of hunger' . "\n";
				$this->vanish();
			}
		}

		public function vanish() {
			$this->getLocation()->removeCreature($this);
		}

		public function isDead()
		{
			return is_null($this->location);
		}
	}