<?php

namespace SebWas\MultiModelAuthentication;

use Illuminate\Database\Eloquent\Model;

interface ConsumingModel {
	/**
	 * Consumes a base user model
	 * @param  Model  $model
	 * @return void
	 */
	public function consumeModel(Model $model);
}
