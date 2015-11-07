# Laravel MultiModelAuthentication
An approach to enable multi model authentication, which means that from a derived base class used for authentication there are certain decorating classes.

## Usage
The usage is relatively easy and basically means to active the correct Service Provider and setup the _base model_.

### Activation
In `config/app.php` setup up the `\SebWas\MultiModelAuthentication\AuthServiceProvider` instead of the default one, and also setup the right alias of `Auth => SebWas\MultiModelAuthentication\Facades\Auth::class`.

### Model
All models derived that should be user have to implement the `\SebWas\MultiModelAuthentication\ConsumingModel` interface to set everything up. You can also use the `\SebWas\MultiModelAuthentication\ConsumesModel` trait which gives you some handy functionality as well.

The model under `$this->app['config']['auth.model']` must implement the `\SebWas\MultiModelAuthentication\ProvidingModel` interface, which makes it obligatory to have the method `modelColumn()` defined which is supposed to tell the driver which column of the DB to use to get the right model.

Alternatively, the _base model_ can implement the `\SebWas\MultiModelAuthentication\ProvidingModelAndAlias` interface which makes it, in addition to the first one, obligatory to implement a `modelAlias()` method which can then return an array with aliases that the value of `modelColumn()` should use to determine which Model to use.

As a third option you can use the `\SebWas\MultiModelAuthentication\SelfResolvingModel` interface, which then needs to implement a `resolveModel()` method that, itself, returns a valid fully qualified class name.

