<?php

class ConfigRegistry {
	private static $instance_;

	private $registry;

	private function __constructor() {
		self::$instance_ = null;
		$this->registry = array();
	}

	public static function getInstance() {
		if (!isset(self::$instance_))
			self::$instance_ = new ConfigRegistry();
		return self::$instance_;
	}

	public function get($key) {
		if (in_array($key, $this->registry))
			return $this->registry[$key];
		else
			return null;
	}

	public function set($key, $value) {
		$this->registry[$key] = $value;
	}
}

?>
