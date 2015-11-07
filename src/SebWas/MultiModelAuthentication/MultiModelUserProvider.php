<?php

namespace SebWas\MultiModelAuthentication;

use Illuminate\Database\Eloquent\Model;

class MultiModelUserProvider extends \Illuminate\Auth\EloquentUserProvider {
	/**
	 * Retrieve a user by their unique identifier.
	 *
	 * @param  mixed  $identifier
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function retrieveById($identifier)
	{
		return $this->convertToDesiredModel($this->createModel()->newQuery()->find($identifier));
	}

	/**
	 * Retrieve a user by their unique identifier and "remember me" token.
	 *
	 * @param  mixed  $identifier
	 * @param  string  $token
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function retrieveByToken($identifier, $token)
	{
		$model = $this->createModel();

		return $this->convertToDesiredModel($model->newQuery()
			->where($model->getKeyName(), $identifier)
			->where($model->getRememberTokenName(), $token)
			->first());
	}

	/**
	 * Retrieve a user by the given credentials.
	 *
	 * @param  array  $credentials
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function retrieveByCredentials(array $credentials)
	{
		// First we will add each credential element to the query as a where clause.
		// Then we can execute the query and, if we found a user, return it in a
		// Eloquent User "model" that will be utilized by the Guard instances.
		$query = $this->createModel()->newQuery();

		foreach ($credentials as $key => $value) {
			if (! Str::contains($key, 'password')) {
				$query->where($key, $value);
			}
		}

		return $this->convertToDesiredModel($query->first());
	}

	/**
	 * Converts a model to a new model letting it consume the old one
	 * @param  Model $model
	 * @return Model
	 */
	protected function convertToDesiredModel($model){
		if(is_null($model)){
			return null;
		}

		if($model instanceof ProvidingModel){
			$newModelName = $model->{$model->modelColumn()};
			$newModel = '\\App\\'.ucwords($newModelName)

			if($model instanceof ProvidingModelAndAlias){
				$aliases = $model->modelAlias();

				if(isset($aliases[$newModelName])){
					$newModel = $aliases[$newModelName];
				}
			}
		} else if($model instanceof SelfResolvingModel){
			$newModel = $model->resolveModel();
		} else {
			throw new Exception("The base mode must implement one of either \SebWas\MultiModelAuthentication\ProvidingModel, \SebWas\MultiModelAuthentication\ProvidingModelAndAlias or \SebWas\MultiModelAuthentication\SelfResolvingModel");
		}

		$newModel = new $newModel;

		if(!($newModel instanceof ConsumingModel)){
			throw new Exception("The new model must implement \SebWas\MultiModelAuthentication\ConsumingModel");
		}

		$newModel->consume($model);

		return $newModel;
	}
}
