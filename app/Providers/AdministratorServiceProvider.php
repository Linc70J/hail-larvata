<?php

namespace App\Providers;

use App\Administrator\Menu;
use App\Administrator\Validator;
use Illuminate\Support\ServiceProvider;
use App\Administrator\DataTable\DataTable;
use Validator as LValidator;
use App\Administrator\Fields\Factory as FieldFactory;
use App\Administrator\Config\Factory as ConfigFactory;
use App\Administrator\Actions\Factory as ActionFactory;
use App\Administrator\DataTable\Columns\Factory as ColumnFactory;

class AdministratorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        //the admin validator
        $this->app->singleton('admin_validator', function ($app) {
            //get the original validator class so we can set it back after creating our own
            $originalValidator = LValidator::make(array(), array());
            $originalValidatorClass = get_class($originalValidator);

            //temporarily override the core resolver
            LValidator::resolver(function ($translator, $data, $rules, $messages) use ($app) {
                $validator = new Validator($translator, $data, $rules, $messages);
                $validator->setUrlInstance($app->make('url'));

                return $validator;
            });

            //grab our validator instance
            $validator = LValidator::make(array(), array());

            //set the validator resolver back to the original validator
            LValidator::resolver(function ($translator, $data, $rules, $messages) use ($originalValidatorClass) {
                return new $originalValidatorClass($translator, $data, $rules, $messages);
            });

            //return our validator instance
            return $validator;
        });

        //set up the shared instances
        $this->app->singleton('admin_config_factory', function ($app) {
            return new ConfigFactory($app->make('admin_validator'), LValidator::make(array(), array()), config('administrator'));
        });

        $this->app->singleton('admin_field_factory', function ($app) {
            return new FieldFactory($app->make('admin_validator'), $app->make('itemconfig'), $app->make('db'));
        });

        $this->app->singleton('admin_datatable', function ($app) {
            $dataTable = new DataTable($app->make('itemconfig'), $app->make('admin_column_factory'), $app->make('admin_field_factory'));
            $dataTable->setRowsPerPage($app->make('session.store'), config('administrator.global_rows_per_page'));

            return $dataTable;
        });

        $this->app->singleton('admin_column_factory', function ($app) {
            return new ColumnFactory($app->make('admin_validator'), $app->make('itemconfig'), $app->make('db'));
        });

        $this->app->singleton('admin_action_factory', function ($app) {
            return new ActionFactory($app->make('admin_validator'), $app->make('itemconfig'), $app->make('db'));
        });

        $this->app->singleton('admin_menu', function ($app) {
            return new Menu($app->make('config'), $app->make('admin_config_factory'));
        });
    }
}
