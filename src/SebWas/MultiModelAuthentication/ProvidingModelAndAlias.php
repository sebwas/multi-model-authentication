<?php

namespace SebWas\MultiModelAuthentication;

interface ProvidingModelAndAlias extends ProvidingModel {
	/**
	 * Returns a list of aliases that should be used to resolve the correct model
	 * @return array
	 */
	public function modelAlias();
}
