<?php

namespace SebWas\MultiModelAuthentication\Facades;

class Auth extends \Illuminate\Support\Facades\Facade {
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor(){
		return 'auth';
	}
}
