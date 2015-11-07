<?php

namespace SebWas\MultiModelAuthentication;

interface SelfResolvingModel {
	/**
	 * Returns the class name of the model to be used
	 * @return string
	 */
	public function resolveModel();
}
