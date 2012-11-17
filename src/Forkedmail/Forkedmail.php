<?php

namespace Forkedmail;

class Forkedmail implements \SplSubject {
	
	protected $observers = array();

	public function notify(){

		foreach($this->observers as $observer) {
		
			$observer->update($this);
		}
	}

	public function attach(\SplObserver $observer) {
		
		$this->observers[spl_object_hash($observer)] = $observer;

		return $this;
	}

	public function detach(\SplObserver $observer) {

		$key = spl_object_hash($observer);
		
		if(array_key_exists($key, $this->observers)) {
			
			unset($this->observers[$key]);
		}

		return $this;
	}
	
	public function sendEmail() {
	
		$this->notify();
		
		return true;
	}
}
