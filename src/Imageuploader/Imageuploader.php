<?php

namespace Imageuploader;

class Imageuploader {
	
	private $s3;
	private $ph;
	
	public function __construct() {

		$this->s3 = new \AmazonS3();
		$this->ph = new \Pheanstalk('localhost');

	}

	public function addToQueue($filename) {

                $this->ph->useTube('resizeimagequeue')->put($filename);
	}

	public function process($filename) {

		if(file_exists($filename) && is_readable($filename)) {

			$imagine = new \Imagine\Gd\Imagine();
			$image = $imagine->open($filename);
			return $image->thumbnail(new \Imagine\Image\Box(100, 100));
		}
		else {
		
			die($filename." does not exist, or is not readable");
		}
		
	}

	public function fakeName() {

		return rand(1, 12).'.jpeg';
	}

	public function upload(\Imagine\Gd\Image $imgObj) {

     		$response = $this->s3->create_object(
         		'beanstalkd-demo',
          		$this->fakeName(),
          		array(
            			'body' => $imgObj->get('jpeg'),
            			'acl' => \AmazonS3::ACL_PUBLIC,
          		)
        	);

		return $response->status;
	}
}
