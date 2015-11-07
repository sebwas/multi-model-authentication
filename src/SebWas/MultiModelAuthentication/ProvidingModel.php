<?php

namespace SebWas\MultiModelAuthentication;

interface ProvidingModel {
	/**
	 * Returns the column name that will determine which is the right model to use
	 * @return string
	 */
	public function modelColumn();
}
