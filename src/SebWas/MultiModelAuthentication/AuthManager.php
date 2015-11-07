<?php

namespace SebWas\MultiModelAuthentication;

/**
 * This class only overwrites setting up the EloquentUserProvider, using the one provided by this package
 */
class AuthManager extends \Illuminate\Auth\AuthManager {
    /**
     * Create an instance of the Eloquent user provider.
     *
     * @return \Illuminate\Auth\EloquentUserProvider
     */
    protected function createEloquentProvider()
    {
        $baseModel = $this->app['config']['auth.model'];

        return new MultiModelUserProvider($this->app['hash'], $baseModel);
    }
}
