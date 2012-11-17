<?php

namespace Example;

class Beanstalk implements \SplObserver {
	
	private $ph;
	
	public function __construct() {

		$this->ph = new \Pheanstalk('localhost');
	}
	
	public function update(\SplSubject $subject){

		$bodyTxt = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam purus nibh, volutpat a tempus quis, rhoncus id mauris. Aenean at nisi mauris. Quisque id interdum ipsum. Vestibulum eu nisi vel elit consequat cursus. Etiam volutpat urna ac justo iaculis iaculis. Nunc sed ligula ligula. Praesent in semper tortor. Donec feugiat laoreet massa vel congue. Vestibulum hendrerit odio eget purus semper laoreet. Maecenas dictum sem non ligula vehicula bibendum cursus enim scelerisque. Phasellus auctor lacus justo, pharetra auctor lorem. Sed elementum nulla non est luctus sit amet sodales turpis tempor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Ut bibendum libero non orci vehicula condimentum. Nam ornare adipiscing pharetra.';

	    	$headers = array("From"=>"apache@vm", "Subject"=>'[BeanstalkD] Test Mail '.uniqid());
	
	    	$mail = \Mail::factory("mail");
		$mail->headers = $headers;
		$mail->body = $bodyTxt;
		$mail->to = 'andrew@vm';
		
		$mailMessage = serialize($mail);
		
		$this->ph->useTube('mailqueue')->put($mailMessage);
  	}
}
