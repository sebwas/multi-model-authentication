<?php

namespace SebWas\MultiModelAuthentication;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait ConsumesModel {
	/**
	 * Holds the consumed model if any
	 * @var Model
	 */
	protected $consumedModel = null;

	/**
	 * Holds the props of the consumed model, to enable them for easy alteration
	 * @var array
	 */
	protected $consumedModelProps = [];

	/**
	 * Lets the model consume the old one
	 * @param  Model  $model The old model
	 * @return $this
	 */
	public function consumeModel(Model $model){
		$this->consumedModel = $model;
		$this->consumedModelProps = array_merge($model->attributesToArray(), $model->relationsToArray());

		return $this;
	}

	/**
	 * Gets the consumed model if any.
	 *
	 * @return Model
	 */
	public function getConsumedModel()
	{
		return $this->consumedModel;
	}

	/**
	 * Small override for helping with fetching data from the consumed model
	 * @param  string  $key The property name
	 * @return boolean
	 */
	public function hasGetMutator($key){
		return parent::hasGetMutator($key) || isset($this->consumedModelProps[Str::studly($key)]);
	}

	/**
	 * Overrides the parents call to interfere in case the getMutator is called
	 * @param  string $_method
	 * @param  array  $attributes
	 * @return mixed
	 */
	public function __call($_method, $attributes){
		$method = strtolower($_method);
		$prefix = substr($method, 0, 3);
		$suffix = substr($method, -9);
		$main   = substr($_method, 3, -9);
		if($prefix === 'get' && $suffix === 'attribute'){
			if(isset($this->consumedModelProps[$main])){
				return $this->consumedModel->{$main};
			}
		}

		return parent::__call($_method, $attributes);
	}
}
