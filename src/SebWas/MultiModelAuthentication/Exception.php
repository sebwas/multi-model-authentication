<?php

namespace SebWas\MultiModelAuthentication;

class Exception extends \Exception {
	public function __construct($message = "", $code = 0, \Exception $previous = null){
		parent::__construct("Extension MultiModelAuthentication: $message", $code, $previous);
	}
}
